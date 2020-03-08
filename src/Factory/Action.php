<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Factory;

use Fusio\Engine\Action\ServiceAwareInterface;
use Fusio\Engine\ActionInterface as EngineActionInterface;
use Fusio\Engine\CacheInterface;
use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\DispatcherInterface;
use Fusio\Engine\LoggerInterface;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Response;
use Psr\Container\ContainerInterface;
use PSX\Dependency\TypeResolverInterface;
use RuntimeException;

/**
 * Action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Action implements ActionInterface
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @var \PSX\Dependency\TypeResolverInterface
     */
    protected $typeResolver;

    /**
     * @var array
     */
    protected $resolvers;

    public function __construct(ContainerInterface $container, TypeResolverInterface $typeResolver)
    {
        $this->container    = $container;
        $this->typeResolver = $typeResolver;
        $this->resolvers    = [];
    }

    /**
     * @inheritdoc
     */
    public function factory($className, $engine = null)
    {
        if (!empty($engine) && isset($this->resolvers[$engine])) {
            $resolver = $this->resolvers[$engine];
        } else {
            $resolver = reset($this->resolvers);

            if (!$resolver instanceof ResolverInterface) {
                throw new RuntimeException('No resolver was configured');
            }
        }

        $action = $resolver->resolve($className);

        if (!$action instanceof EngineActionInterface) {
            throw new RuntimeException('Action ' . $className . ' must implement the Fusio\Engine\ActionInterface interface');
        }

        if ($action instanceof ServiceAwareInterface) {
            $service = $this->typeResolver->getServiceByType(ConnectorInterface::class);
            if ($service instanceof ConnectorInterface) {
                $action->setConnector($service);
            }

            $service = $this->typeResolver->getServiceByType(Response\FactoryInterface::class);
            if ($service instanceof Response\FactoryInterface) {
                $action->setResponse($service);
            }

            $service = $this->typeResolver->getServiceByType(ProcessorInterface::class);
            if ($service instanceof ProcessorInterface) {
                $action->setProcessor($service);
            }

            $service = $this->typeResolver->getServiceByType(DispatcherInterface::class);
            if ($service instanceof DispatcherInterface) {
                $action->setDispatcher($service);
            }

            $service = $this->typeResolver->getServiceByType(LoggerInterface::class);
            if ($service instanceof LoggerInterface) {
                $action->setLogger($service);
            }

            $service = $this->typeResolver->getServiceByType(CacheInterface::class);
            if ($service instanceof CacheInterface) {
                $action->setCache($service);
            }
        }

        if ($action instanceof ContainerAwareInterface) {
            $action->setContainer($this->container);
        }

        return $action;
    }

    /**
     * @param \Fusio\Engine\Factory\ResolverInterface $resolver
     */
    public function addResolver(ResolverInterface $resolver)
    {
        $this->resolvers[get_class($resolver)] = $resolver;
    }
}
