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

use Fusio\Engine\Exception\ConnectionNotFoundException;

/**
 * Connector
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Connector implements ConnectorInterface
{
    private Repository\ConnectionInterface $repository;
    private Factory\ConnectionInterface $factory;

    /**
     * @var array<string|int, Model\ConnectionInterface>
     */
    private array $connections = [];

    public function __construct(Repository\ConnectionInterface $repository, Factory\ConnectionInterface $factory)
    {
        $this->repository = $repository;
        $this->factory    = $factory;
    }

    /**
     * @throws ConnectionNotFoundException
     */
    public function getConnection(string|int $connectionId): mixed
    {
        if (isset($this->connections[$connectionId])) {
            return $this->connections[$connectionId];
        }

        $connection = $this->repository->get($connectionId);

        if ($connection instanceof Model\ConnectionInterface) {
            $parameters = new Parameters($connection->getConfig());

            return $this->connections[$connectionId] = $this->factory->factory($connection->getClass())->getConnection($parameters);
        } else {
            throw new ConnectionNotFoundException('Could not find connection ' . $connectionId);
        }
    }

    public function clear(): void
    {
        $this->connections = [];
    }
}
