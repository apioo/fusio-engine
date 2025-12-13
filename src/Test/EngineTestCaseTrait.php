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

namespace Fusio\Engine\Test;

use Fusio\Engine\Action\QueueInterface;
use Fusio\Engine\AdapterInterface;
use Fusio\Engine\Context;
use Fusio\Engine\Factory;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\Model\Action;
use Fusio\Engine\Model\App;
use Fusio\Engine\Model\User;
use Fusio\Engine\Parameters;
use Fusio\Engine\Processor;
use Fusio\Engine\Repository;
use Fusio\Engine\Request as EngineRequest;
use Fusio\Engine\Request\HttpRequestContext;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamInterface;
use PSX\Http\Request;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Uri\Uri;
use RuntimeException;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

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
        return $this->getEngineContainer()->getActionFactory();
    }

    protected function getActionQueue(): QueueInterface
    {
        return $this->getEngineContainer()->getActionQueue();
    }

    protected function getExecutionStack(): Processor\ExecutionStackInterface
    {
        return $this->getEngineContainer()->getExecutionStack();
    }

    protected function getActionRepository(): Repository\ActionInterface
    {
        return $this->getEngineContainer()->getActionRepository();
    }

    protected function getConnectionFactory(): Factory\ConnectionInterface
    {
        return $this->getEngineContainer()->getConnectionFactory();
    }

    protected function getConnectionRepository(): Repository\ConnectionInterface
    {
        return $this->getEngineContainer()->getConnectionRepository();
    }

    protected function getFormElementFactory(): ElementFactoryInterface
    {
        return $this->getEngineContainer()->getFormElementFactory();
    }

    protected function getEngineContainer(): EngineContainer
    {
        return $this->getContainer()->get(EngineContainer::class);
    }

    protected function getContainer(): ContainerInterface
    {
        if (self::$container === null) {
            self::$container = $this->newContainer($this->getAdapterClass());
        }

        return self::$container;
    }

    abstract protected function getAdapterClass(): string;

    protected function newContainer(string $adapterClass): ContainerInterface
    {
        if (!class_exists($adapterClass)) {
            throw new \InvalidArgumentException('Provided adapter class does not exist');
        }

        $adapter = new $adapterClass();
        if (!$adapter instanceof AdapterInterface) {
            throw new \InvalidArgumentException('Provided class is not an adapter');
        }

        $containerFile = $adapter->getContainerFile();

        $targetFile = __DIR__ . '/compiled/container.php';
        $containerConfigCache = new ConfigCache($targetFile, true);

        if (!$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();

            $loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__));
            $loader->load(__DIR__ . '/../../resources/container.php');
            $loader->load(__DIR__ . '/container.php');
            $loader->load($containerFile);

            $containerBuilder->compile();

            $result = (new PhpDumper($containerBuilder))->dump();
            if (is_string($result)) {
                $containerConfigCache->write($result, $containerBuilder->getResources());
            }
        }

        if (!is_file($targetFile)) {
            throw new RuntimeException('Could not find container file');
        }

        require_once $targetFile;

        if (!class_exists('ProjectServiceContainer')) {
            throw new RuntimeException('Could not find container class');
        }

        $container = new \ProjectServiceContainer();
        if (!$container instanceof ContainerInterface) {
            throw new RuntimeException('Generated container must implement: ' . ContainerInterface::class);
        }

        return $container;
    }
}
