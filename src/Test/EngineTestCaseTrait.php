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

namespace Fusio\Engine\Test;

use Fusio\Engine\Action\QueueInterface;
use Fusio\Engine\Action\Runtime;
use Fusio\Engine\Context;
use Fusio\Engine\Dependency\EngineContainerFactory;
use Fusio\Engine\Factory;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\Model\Action;
use Fusio\Engine\Model\App;
use Fusio\Engine\Model\User;
use Fusio\Engine\Parameters;
use Fusio\Engine\Repository;
use Fusio\Engine\Request as EngineRequest;
use Fusio\Engine\Request\HttpRequestContext;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamInterface;
use PSX\Http\Request;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Uri\Uri;
use Symfony\Component\DependencyInjection\Container;

/**
 * EngineTestCaseTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
trait EngineTestCaseTrait
{
    private static ?ContainerInterface $container = null;

    protected function setUp(): void
    {
        parent::setUp();

        // always reset the container for each test
        self::$container = null;
    }

    protected function getRequest(?string $method = null, array $uriFragments = [], array $parameters = [], array $headers = [], ?RecordInterface $parsedBody = null, ?StreamInterface $rawBody = null): \Fusio\Engine\Request
    {
        $uri = Uri::parse('http://127.0.0.1/foo');
        $uri = $uri->withParameters($parameters);

        $request = new Request($uri, $method === null ? 'GET' : $method, $headers, $rawBody);

        return new EngineRequest(
            array_merge($uriFragments, $parameters),
            $parsedBody === null ? new Record() : $parsedBody,
            new HttpRequestContext($request, $uriFragments)
        );
    }

    protected function getParameters(array $parameters = array()): Parameters
    {
        return new Parameters($parameters);
    }

    protected function getContext(): Context
    {
        $app = new App(
            anonymous: false,
            id: 3,
            userId: 2,
            status: 1,
            name: 'Foo-App',
            url: 'http://google.com',
            appKey: '5347307d-d801-4075-9aaa-a21a29a448c5',
            parameters: ['foo' => 'bar'],
            scopes: ['foo', 'bar'],
        );

        $user = new User(
            anonymous: false,
            id: 2,
            roleId: 1,
            categoryId: 1,
            status: 0,
            name: 'Consumer',
            email: 'consumer@app.dev',
            points: 100,
        );

        $action = new Action(
            id: 1,
            name: 'foo',
            class: \stdClass::class,
            async: false,
            config: [],
        );

        $context = new Context(34, 'http://127.0.0.1', $app, $user);
        return $context->withAction($action);
    }

    protected function getActionFactory(): Factory\ActionInterface
    {
        return $this->getContainer()->get(Factory\ActionInterface::class);
    }

    protected function getActionQueue(): QueueInterface
    {
        return $this->getContainer()->get(QueueInterface::class);
    }

    protected function getActionRepository(): Repository\ActionInterface
    {
        return $this->getContainer()->get(Repository\ActionInterface::class);
    }

    protected function getConnectionFactory(): Factory\ConnectionInterface
    {
        return $this->getContainer()->get(Factory\ConnectionInterface::class);
    }

    protected function getConnectionRepository(): Repository\ConnectionInterface
    {
        return $this->getContainer()->get(Repository\ConnectionInterface::class);
    }

    protected function getFormElementFactory(): ElementFactoryInterface
    {
        return $this->getContainer()->get(ElementFactoryInterface::class);
    }

    protected function getContainer(): ContainerInterface
    {
        if (self::$container === null) {
            self::$container = $this->newContainer();
        }

        return self::$container;
    }

    protected function newContainer(): ContainerInterface
    {
        $configure = function (Runtime $runtime, Container $container): void {
            $this->configure($runtime, $container);
        };

        return (new EngineContainerFactory($configure))->factory();
    }

    protected function configure(Runtime $runtime, Container $container): void
    {
    }
}
