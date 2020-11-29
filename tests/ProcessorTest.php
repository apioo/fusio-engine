<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fusio\Engine\Tests;

use Fusio\Engine\Action\MemoryQueue;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Model\Action;
use Fusio\Engine\Processor;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\RequestInterface;
use Fusio\Engine\Response\FactoryInterface;
use Fusio\Engine\Test\CallbackAction;
use Fusio\Engine\Test\EngineTestCaseTrait;
use PHPUnit\Framework\TestCase;
use PSX\Http\Environment\HttpResponseInterface;

/**
 * ProcessorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class ProcessorTest extends TestCase
{
    use EngineTestCaseTrait;

    public function testExecute()
    {
        $repository = $this->newRepository();
        $processor  = $this->newProcessor($repository);

        $response = $processor->execute(1, $this->getRequest(), $this->getContext());

        $this->assertInstanceOf(HttpResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testExecuteAsync()
    {
        $repository = $this->newRepository(true);
        $processor  = $this->newProcessor($repository);

        $response = $processor->execute(1, $this->getRequest(), $this->getContext());

        $this->assertInstanceOf(HttpResponseInterface::class, $response);
        $this->assertEquals(202, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => true, 'message' => 'Request was queued for execution'], $response->getBody());
        
        /** @var MemoryQueue $queue */
        $queue = $this->getActionQueue();

        [$actionId, $request, $context] = $queue->pop();

        $this->assertEquals(1, $actionId);
        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertInstanceOf(ContextInterface::class, $context);
    }

    public function testGetConnectionNamed()
    {
        $repository = $this->newRepository();
        $processor  = $this->newProcessor($repository);

        $response = $processor->execute('foo', $this->getRequest(), $this->getContext());

        $this->assertInstanceOf(HttpResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testGetConnectionInvalid()
    {
        $this->expectException(ActionNotFoundException::class);

        $repository = $this->getActionRepository();
        $processor  = $this->newProcessor($repository);

        $processor->execute(2, $this->getRequest(), $this->getContext());
    }

    private function newRepository(bool $async = false): Repository\ActionInterface
    {
        $repository = $this->getActionRepository();

        $action = new Action();
        $action->setId(1);
        $action->setName('foo');
        $action->setClass(CallbackAction::class);
        $action->setAsync($async);
        $action->setConfig(['callback' => function(FactoryInterface $response){
            return $response->build(200, [], ['foo' => 'bar']);
        }]);

        $repository->add($action);

        return $repository;
    }

    private function newProcessor(Repository\ActionInterface $repository): ProcessorInterface
    {
        return new Processor($repository, $this->getActionFactory(), $this->getActionQueue());
    }
}
