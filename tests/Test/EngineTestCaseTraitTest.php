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

namespace Fusio\Engine\Tests\Test;

use Fusio\Engine\ActionInterface;
use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\Factory;
use Fusio\Engine\Form;
use Fusio\Engine\Parameters;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\Parser;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\RequestInterface;
use Fusio\Engine\Response\FactoryInterface;
use Fusio\Engine\Schema;
use Fusio\Engine\Test\EngineTestCase;
use Psr\Container\ContainerInterface;
use PSX\Http\Environment\HttpResponseInterface;

/**
 * EngineTestCaseTraitTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class EngineTestCaseTraitTest extends EngineTestCase
{
    public function testGetRequest()
    {
        $this->assertInstanceOf(RequestInterface::class, $this->getRequest());
    }

    public function testGetParameters()
    {
        $this->assertInstanceOf(ParametersInterface::class, $this->getParameters());
    }

    public function testGetContext()
    {
        $this->assertInstanceOf(ContextInterface::class, $this->getContext());
    }

    public function testGetActionHandle()
    {
        $action = $this->getActionFactory()->factory(Impl\Action::class);

        $this->assertInstanceOf(ActionInterface::class, $action);

        $parameters = $this->getParameters([]);
        $response   = $action->handle($this->getRequest(), $parameters, $this->getContext());

        $actual = json_encode($response->getBody(), JSON_PRETTY_PRINT);
        $expect = <<<JSON
{
    "foo": "bar"
}
JSON;

        $this->assertInstanceOf(HttpResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testGetActionConfigure()
    {
        $action  = $this->getActionFactory()->factory(Impl\Action::class);
        $builder = new Form\Builder();
        $factory = $this->getFormElementFactory();

        $this->assertInstanceOf(ActionInterface::class, $action);

        $action->configure($builder, $factory);

        $this->assertInstanceOf(Form\Container::class, $builder->getForm());
    }

    public function testGetActionRepository()
    {
        $repository = $this->getActionRepository();

        $this->assertInstanceOf(Repository\ActionInterface::class, $repository);
    }

    public function testGetConnection()
    {
        $connection = $this->getConnectionFactory()->factory(Impl\Connection::class);
        $parameters = new Parameters([]);

        $this->assertInstanceOf(ConnectionInterface::class, $connection);

        $result = $connection->getConnection($parameters);

        $this->assertInstanceOf(\stdClass::class, $result);
    }

    public function testGetConnectionConfigure()
    {
        $connection = $this->getConnectionFactory()->factory(Impl\Connection::class);
        $builder    = new Form\Builder();
        $factory    = $this->getFormElementFactory();

        $this->assertInstanceOf(ConnectionInterface::class, $connection);

        $connection->configure($builder, $factory);

        $this->assertInstanceOf(Form\Container::class, $builder->getForm());
    }

    public function testGetConnectionRepository()
    {
        $repository = $this->getConnectionRepository();

        $this->assertInstanceOf(Repository\ConnectionInterface::class, $repository);
    }

    public function testGetFormElementFactory()
    {
        $this->assertInstanceOf(Form\ElementFactoryInterface::class, $this->getFormElementFactory());
    }

    public function testContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->getContainer());
        $this->assertInstanceOf(Parser\ParserInterface::class, $this->getContainer()->get('action_parser'));
        $this->assertInstanceOf(Factory\ActionInterface::class, $this->getContainer()->get('action_factory'));
        $this->assertInstanceOf(Repository\ActionInterface::class, $this->getContainer()->get('action_repository'));
        $this->assertInstanceOf(ProcessorInterface::class, $this->getContainer()->get('processor'));
        $this->assertInstanceOf(Parser\ParserInterface::class, $this->getContainer()->get('connection_parser'));
        $this->assertInstanceOf(Factory\ConnectionInterface::class, $this->getContainer()->get('connection_factory'));
        $this->assertInstanceOf(Repository\ConnectionInterface::class, $this->getContainer()->get('connection_repository'));
        $this->assertInstanceOf(ConnectorInterface::class, $this->getContainer()->get('connector'));
        $this->assertInstanceOf(Repository\AppInterface::class, $this->getContainer()->get('app_repository'));
        $this->assertInstanceOf(Repository\UserInterface::class, $this->getContainer()->get('user_repository'));
        $this->assertInstanceOf(Form\ElementFactoryInterface::class, $this->getContainer()->get('form_element_factory'));
        $this->assertInstanceOf(FactoryInterface::class, $this->getContainer()->get('response'));
    }
}
