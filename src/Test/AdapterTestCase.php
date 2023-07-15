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

namespace Fusio\Engine\Test;

use Fusio\Engine\ActionInterface;
use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Generator;
use Fusio\Engine\Payment;
use Fusio\Engine\User;
use PHPUnit\Framework\TestCase;

/**
 * AdapterTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
abstract class AdapterTestCase extends TestCase
{
    use EngineTestCaseTrait;

    public function testDefinition(): void
    {
        $container = $this->getContainer();

        $connections = $container->get('connections')->getServices();
        foreach ($connections as $connection) {
            $this->assertInstanceOf(ConnectionInterface::class, $connection);
        }

        $actions = $container->get('actions')->getServices();
        foreach ($actions as $action) {
            $this->assertInstanceOf(ActionInterface::class, $action);
        }

        $users = $container->get('users')->getServices();
        foreach ($users as $user) {
            $this->assertInstanceOf(User\ProviderInterface::class, $user);
        }

        $payments = $container->get('payments')->getServices();
        foreach ($payments as $payment) {
            $this->assertInstanceOf(Payment\ProviderInterface::class, $payment);
        }

        $generators = $container->get('generators')->getServices();
        foreach ($generators as $generator) {
            $this->assertInstanceOf(Generator\ProviderInterface::class, $generator);
        }
    }
}
