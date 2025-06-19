<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Tests\Test;

use Fusio\Engine\Action\Runtime;
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
use Symfony\Component\DependencyInjection\Container;

/**
 * EngineTestCaseTraitTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class EngineTestCaseTraitTest extends EngineTestCase
{
    protected function configure(Runtime $runtime, Container $container): void
    {
        $container->set(Impl\Connection::class, new Impl\Connection());
        $container->set(Impl\Action::class, new Impl\Action($runtime));
    }

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

    protected function getAdapterClass(): string
    {
        return TestAdapter::class;
    }
}
