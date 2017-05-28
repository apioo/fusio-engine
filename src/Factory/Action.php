<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Response;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use RuntimeException;

/**
 * Action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Action implements ActionInterface
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $serviceNames;

    /**
     * @param \Psr\Container\ContainerInterface $container
     * @param array $serviceNames
     */
    public function __construct(ContainerInterface $container, array $serviceNames)
    {
        $this->container    = $container;
        $this->serviceNames = $serviceNames;
    }

    /**
     * @param string $className
     * @return \Fusio\Engine\ActionInterface
     */
    public function factory($className)
    {
        $action = new $className();

        if (!$action instanceof EngineActionInterface) {
            throw new RuntimeException('Action ' . $className . ' must implement the Fusio\Engine\ActionInterface interface');
        }

        if ($action instanceof ServiceAwareInterface) {
            $service = $this->getServiceImplementation(ConnectorInterface::class);
            if ($service instanceof ConnectorInterface) {
                $action->setConnector($service);
            }

            $service = $this->getServiceImplementation(Response\FactoryInterface::class);
            if ($service instanceof Response\FactoryInterface) {
                $action->setResponse($service);
            }

            $service = $this->getServiceImplementation(ProcessorInterface::class);
            if ($service instanceof ProcessorInterface) {
                $action->setProcessor($service);
            }

            $service = $this->getServiceImplementation(LoggerInterface::class);
            if ($service instanceof LoggerInterface) {
                $action->setLogger($service);
            }

            $service = $this->getServiceImplementation(CacheInterface::class);
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
     * @param string $interface
     * @return object
     */
    protected function getServiceImplementation($interface)
    {
        if (isset($this->serviceNames[$interface])) {
            return $this->container->get($this->serviceNames[$interface]);
        } else {
            return null;
        }
    }
}
