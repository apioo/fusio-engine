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
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
