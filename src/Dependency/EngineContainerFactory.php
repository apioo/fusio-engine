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

namespace Fusio\Engine\Dependency;

use Fusio\Engine\Action;
use Fusio\Engine\Connector;
use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\Dispatcher;
use Fusio\Engine\DispatcherInterface;
use Fusio\Engine\Factory;
use Fusio\Engine\Form;
use Fusio\Engine\Parser;
use Fusio\Engine\Processor;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\Response;
use Fusio\Engine\Test\CallbackAction;
use Fusio\Engine\Test\CallbackConnection;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\Container;

/**
 * EngineContainerFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class EngineContainerFactory
{
    private \Closure $configure;

    public function __construct(\Closure $configure)
    {
        $this->configure = $configure;
    }

    public function factory(): Container
    {
        $container = new Container();

        $actionRepository = new Repository\ActionMemory();
        $container->set(Repository\ActionInterface::class, $actionRepository);

        $connectionRepository = new Repository\ConnectionMemory();
        $container->set(Repository\ConnectionInterface::class, $connectionRepository);

        $appRepository = new Repository\AppMemory();
        $container->set(Repository\AppInterface::class, $appRepository);

        $userRepository = new Repository\UserMemory();
        $container->set(Repository\UserInterface::class, $userRepository);

        $elementFactory = new Form\ElementFactory($actionRepository, $connectionRepository);
        $container->set(Form\ElementFactoryInterface::class, $elementFactory);

        $actionFactory = new Factory\Action($container);
        $container->set(Factory\ActionInterface::class, $actionFactory);

        $connectionFactory = new Factory\Connection($container);
        $container->set(Factory\ConnectionInterface::class, $connectionFactory);

        $queue = new Action\MemoryQueue();
        $container->set(Action\QueueInterface::class, $queue);

        $resolvers = [
            new Action\Resolver\DatabaseAction($actionRepository),
            new Action\Resolver\PhpClass(),
        ];
        $processor = new Processor($resolvers, $actionFactory, $queue);
        $container->set(ProcessorInterface::class, $processor);

        $dispatcher = new Dispatcher();
        $container->set(DispatcherInterface::class, $dispatcher);

        $connector = new Connector($connectionRepository, $connectionFactory);
        $container->set(ConnectorInterface::class, $connector);

        $responseFactory = new Response\Factory();
        $container->set(Response\FactoryInterface::class, $responseFactory);

        $logger = new Logger('Fusio-Engine');
        $logger->pushHandler(new NullHandler());
        $container->set(LoggerInterface::class, $logger);

        $cache = new Psr16Cache(new ArrayAdapter());
        $container->set(CacheInterface::class, $cache);

        $actionRuntime = new Action\Runtime($connector, $responseFactory, $processor, $dispatcher, $logger, $cache);
        $container->set(Action\Runtime::class, $actionRuntime);

        $container->set(CallbackConnection::class, new CallbackConnection());
        $container->set(CallbackAction::class, new CallbackAction($actionRuntime));

        call_user_func_array($this->configure, [$actionRuntime, $container]);

        return $container;
    }
}
