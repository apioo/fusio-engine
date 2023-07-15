<?php
/*
 * Fusio is an open source API management platform which helps to create innovative API solutions.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Fusio\Engine\Tests;

use Fusio\Engine\Action\MemoryQueue;
use Fusio\Engine\Action\Resolver\DatabaseAction;
use Fusio\Engine\Action\Resolver\PhpClass;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Exception\FactoryResolveException;
use Fusio\Engine\Model\Action;
use Fusio\Engine\Processor;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\RequestInterface;
use Fusio\Engine\Response\FactoryInterface;
use Fusio\Engine\Test\CallbackAction;
use Fusio\Engine\Test\EngineTestCaseTrait;
use Fusio\Engine\Tests\Test\TestAdapter;
use PHPUnit\Framework\TestCase;
use PSX\Http\Environment\HttpResponseInterface;

/**
 * ProcessorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
        $this->expectException(FactoryResolveException::class);

        $repository = $this->getActionRepository();
        $processor  = $this->newProcessor($repository);

        $processor->execute(2, $this->getRequest(), $this->getContext());
    }

    private function newRepository(bool $async = false): Repository\ActionInterface
    {
        $repository = $this->getActionRepository();

        $action = new Action(
            id: 1,
            name: 'foo',
            class: CallbackAction::class,
            async: $async,
            config: ['callback' => function(FactoryInterface $response){
                return $response->build(200, [], ['foo' => 'bar']);
            }]
        );

        $repository->add($action);

        return $repository;
    }

    private function newProcessor(Repository\ActionInterface $repository): ProcessorInterface
    {
        $resolvers = [
            new DatabaseAction($repository),
            new PhpClass(),
        ];
        return new Processor($resolvers, $this->getActionFactory(), $this->getActionQueue());
    }

    protected function getAdapterClass(): string
    {
        return TestAdapter::class;
    }
}
