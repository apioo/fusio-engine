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

namespace Fusio\Engine\Test;

use Fusio\Engine\Action;
use Fusio\Engine\Factory;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\Processor;
use Fusio\Engine\Repository;

/**
 * EngineContainer
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
readonly class EngineContainer
{
    public function __construct(
        private Factory\ActionInterface $actionFactory,
        private Action\QueueInterface $actionQueue,
        private Processor\ExecutionStackInterface $executionStack,
        private Repository\ActionInterface $actionRepository,
        private Factory\ConnectionInterface $connectionFactory,
        private Repository\ConnectionInterface $connectionRepository,
        private ElementFactoryInterface $formElementFactory
    ) {
    }

    public function getActionFactory(): Factory\ActionInterface
    {
        return $this->actionFactory;
    }

    public function getActionQueue(): Action\QueueInterface
    {
        return $this->actionQueue;
    }

    public function getExecutionStack(): Processor\ExecutionStackInterface
    {
        return $this->executionStack;
    }

    public function getActionRepository(): Repository\ActionInterface
    {
        return $this->actionRepository;
    }

    public function getConnectionFactory(): Factory\ConnectionInterface
    {
        return $this->connectionFactory;
    }

    public function getConnectionRepository(): Repository\ConnectionInterface
    {
        return $this->connectionRepository;
    }

    public function getFormElementFactory(): ElementFactoryInterface
    {
        return $this->formElementFactory;
    }
}
