<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine;

use Fusio\Engine\Action\ServiceAwareInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\Response\FactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * ActionAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
abstract class ActionAbstract implements ActionInterface, ServiceAwareInterface
{
    protected ConnectorInterface $connector;
    protected FactoryInterface $response;
    protected ProcessorInterface $processor;
    protected DispatcherInterface $dispatcher;
    protected LoggerInterface $logger;
    protected CacheInterface $cache;

    public function setConnector(ConnectorInterface $connector): void
    {
        $this->connector = $connector;
    }

    public function setResponse(Response\FactoryInterface $response): void
    {
        $this->response = $response;
    }

    public function setProcessor(ProcessorInterface $processor): void
    {
        $this->processor = $processor;
    }

    public function setDispatcher(DispatcherInterface $dispatcher): void
    {
        $this->dispatcher = $dispatcher;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function setCache(CacheInterface $cache): void
    {
        $this->cache = $cache;
    }

    public function getName(): string
    {
        $className = get_class($this);
        $pos       = strrpos($className, '\\');
        $lastPart  = $pos !== false ? substr($className, $pos + 1) : $className;
        $name      = preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1-\\2', '\\1-\\2'), strtr($lastPart, '_', '.'));

        return $name;
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory): void
    {
    }
}
