<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use Fusio\Engine\Template;
use Fusio\Engine\Http;
use Fusio\Engine\Json;
use Fusio\Engine\Cache;
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $serviceNames;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
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
            $action->setConnector($this->getServiceImplementation(ConnectorInterface::class));
            $action->setResponse($this->getServiceImplementation(Response\FactoryInterface::class));
            $action->setProcessor($this->getServiceImplementation(ProcessorInterface::class));
            $action->setTemplateFactory($this->getServiceImplementation(Template\FactoryInterface::class));
            $action->setHttpClient($this->getServiceImplementation(Http\ClientInterface::class));
            $action->setJsonProcessor($this->getServiceImplementation(Json\ProcessorInterface::class));
            $action->setCacheProvider($this->getServiceImplementation(Cache\ProviderInterface::class));
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
        return $this->container->get($this->getServiceName($interface));
    }

    /**
     * @param string $interface
     * @return string
     */
    protected function getServiceName($interface)
    {
        if (isset($this->serviceNames[$interface])) {
            return $this->serviceNames[$interface];
        } else {
            throw new RuntimeException('Service name not specified for interface ' . $interface);
        }
    }
}
