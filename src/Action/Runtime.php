<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Action;

use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\DispatcherInterface;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Response;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * A simple container which contains all dependencies for an action to work
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Runtime implements RuntimeInterface
{
    private ConnectorInterface $connector;
    private Response\FactoryInterface $response;
    private ProcessorInterface $processor;
    private DispatcherInterface $dispatcher;
    private LoggerInterface $logger;
    private CacheInterface $cache;

    public function __construct(ConnectorInterface $connector, Response\FactoryInterface $response, ProcessorInterface $processor, DispatcherInterface $dispatcher, LoggerInterface $logger, CacheInterface $cache)
    {
        $this->connector = $connector;
        $this->response = $response;
        $this->processor = $processor;
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
        $this->cache = $cache;
    }

    public function getConnector(): ConnectorInterface
    {
        return $this->connector;
    }

    public function getResponse(): Response\FactoryInterface
    {
        return $this->response;
    }

    public function getProcessor(): ProcessorInterface
    {
        return $this->processor;
    }

    public function getDispatcher(): DispatcherInterface
    {
        return $this->dispatcher;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getCache(): CacheInterface
    {
        return $this->cache;
    }
}
