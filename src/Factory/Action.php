<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <k42b3.x@gmail.com>
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
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Action
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
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
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
            $action->setConnector($this->container->get('connector'));
            $action->setResponse($this->container->get('response'));
            $action->setProcessor($this->container->get('processor'));
            $action->setTemplateFactory($this->container->get('template_factory'));
            $action->setHttpClient($this->container->get('http_client'));
            $action->setJsonProcessor($this->container->get('json_processor'));
            $action->setCacheProvider($this->container->get('cache_provider'));
        }

        if ($action instanceof ContainerAwareInterface) {
            $action->setContainer($this->container);
        }

        return $action;
    }
}
