<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine;

use Fusio\Engine\Action\RuntimeInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\Response\FactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * ActionAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
abstract class ActionAbstract implements ActionInterface, ConfigurableInterface
{
    protected ConnectorInterface $connector;
    protected FactoryInterface $response;
    protected ProcessorInterface $processor;
    protected DispatcherInterface $dispatcher;
    protected LoggerInterface $logger;
    protected CacheInterface $cache;

    public function __construct(RuntimeInterface $runtime)
    {
        $this->connector = $runtime->getConnector();
        $this->response = $runtime->getResponse();
        $this->processor = $runtime->getProcessor();
        $this->dispatcher = $runtime->getDispatcher();
        $this->logger = $runtime->getLogger();
        $this->cache = $runtime->getCache();
    }

    public function getName(): string
    {
        return NameBuilder::fromClass(static::class);
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory): void
    {
    }
}
