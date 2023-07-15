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

namespace Fusio\Engine\Factory;

use Fusio\Engine\ConnectionInterface as EngineConnectionInterface;
use Fusio\Engine\Exception\ConnectionNotFoundException;
use Fusio\Engine\Inflection\ClassName;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Connection
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Connection implements ConnectionInterface
{
    private ServiceLocator $connections;

    public function __construct(ServiceLocator $connections)
    {
        $this->connections = $connections;
    }

    public function factory(string $className): EngineConnectionInterface
    {
        $className = ClassName::unserialize($className);

        if (!$this->connections->has($className)) {
            throw new ConnectionNotFoundException('Connection class ' . $className . ' not found');
        }

        $connection = $this->connections->get($className);
        if (!$connection instanceof EngineConnectionInterface) {
            throw new ConnectionNotFoundException('Connection class ' . $className . ' is available but it must implement the interface: ' . EngineConnectionInterface::class);
        }

        return $connection;
    }
}
