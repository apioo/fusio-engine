<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Dependency;

use Fusio\Engine\Factory\FactoryInterface;
use Symfony\Component\DependencyInjection\Container;
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
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

/**
 * EngineContainerFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class EngineContainerFactory
{
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

        $actionFactory = new Factory\Action($container);
        $actionFactory->addResolver(new Factory\Resolver\PhpClass($container));
        $container->set(Factory\ActionInterface::class, $actionFactory);

        $connectionFactory = new Factory\Connection($container);
        $container->set(Factory\ConnectionInterface::class, $connectionFactory);

        $elementFactory = new Form\ElementFactory($actionRepository, $connectionRepository);
        $container->set(Form\ElementFactoryInterface::class, $elementFactory);

        $queue = new Action\MemoryQueue();
        $container->set(Action\QueueInterface::class, $queue);

        $processor = new Processor($actionRepository, $actionFactory, $queue);
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

        return $container;
    }
}
