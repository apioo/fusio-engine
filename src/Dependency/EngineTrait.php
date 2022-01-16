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

use Doctrine\Common\Annotations;
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
use PSX\Dependency\AutowireResolver;
use PSX\Dependency\AutowireResolverInterface;
use PSX\Dependency\Inspector\ContainerInspector;
use PSX\Dependency\InspectorInterface;
use PSX\Dependency\ObjectBuilder;
use PSX\Dependency\ObjectBuilderInterface;
use PSX\Dependency\TypeResolver;
use PSX\Dependency\TypeResolverInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

/**
 * EngineTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
trait EngineTrait
{
    public function getActionParser(): Parser\ParserInterface
    {
        return new Parser\Memory(
            $this->get('action_factory'),
            $this->get('form_element_factory'),
            []
        );
    }

    public function getActionFactory(): Factory\ActionInterface
    {
        $factory = new Factory\Action($this->get('container_type_resolver'));
        $factory->addResolver(new Factory\Resolver\PhpClass($this->get('container_autowire_resolver')));

        return $factory;
    }

    public function getActionQueue(): Action\QueueInterface
    {
        return new Action\MemoryQueue();
    }

    public function getActionRepository(): Repository\ActionInterface
    {
        return new Repository\ActionMemory();
    }

    public function getProcessor(): ProcessorInterface
    {
        return new Processor(
            $this->get('action_repository'),
            $this->get('action_factory'),
            $this->get('action_queue')
        );
    }

    public function getDispatcher(): DispatcherInterface
    {
        return new Dispatcher();
    }

    public function getConnectionParser(): Parser\ParserInterface
    {
        return new Parser\Memory(
            $this->get('connection_factory'),
            $this->get('form_element_factory'),
            []
        );
    }

    public function getConnectionFactory(): Factory\ConnectionInterface
    {
        return new Factory\Connection($this->get('container_autowire_resolver'));
    }

    public function getConnectionRepository(): Repository\ConnectionInterface
    {
        return new Repository\ConnectionMemory();
    }

    public function getConnector(): ConnectorInterface
    {
        return new Connector(
            $this->get('connection_repository'),
            $this->get('connection_factory')
        );
    }

    public function getAppRepository(): Repository\AppInterface
    {
        return new Repository\AppMemory();
    }

    public function getUserRepository(): Repository\UserInterface
    {
        return new Repository\UserMemory();
    }

    public function getFormElementFactory(): Form\ElementFactoryInterface
    {
        return new Form\ElementFactory(
            $this->get('action_repository'),
            $this->get('connection_repository')
        );
    }

    public function getResponse(): Response\FactoryInterface
    {
        return new Response\Factory();
    }

    public function getLogger(): LoggerInterface
    {
        $logger = new Logger('engine');
        $logger->pushHandler(new NullHandler());

        return $logger;
    }

    public function getCache(): CacheInterface
    {
        return new Psr16Cache(new ArrayAdapter());
    }

    public function getObjectBuilder(): ObjectBuilderInterface
    {
        return new ObjectBuilder(
            $this->get('container_type_resolver'),
            new ArrayAdapter(),
            true
        );
    }

    public function getContainerInspector(): InspectorInterface
    {
        return new ContainerInspector($this);
    }

    public function getContainerTypeResolver(): TypeResolverInterface
    {
        return new TypeResolver($this, $this->get('container_inspector'));
    }

    public function getContainerAutowireResolver(): AutowireResolverInterface
    {
        return new AutowireResolver($this->get('container_type_resolver'));
    }
}
