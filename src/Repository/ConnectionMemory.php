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

namespace Fusio\Engine\Repository;

use Fusio\Engine\Model;

/**
 * ConnectionMemory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ConnectionMemory implements ConnectionInterface
{
    /**
     * @var Model\ConnectionInterface[]
     */
    private array $connections;

    public function __construct(array $connections = array())
    {
        $this->connections = $connections;
    }

    public function add(Model\ConnectionInterface $connection): void
    {
        $this->connections[$connection->getId()] = $connection;
    }

    /**
     * @return Model\ConnectionInterface[]
     */
    public function getAll(): array
    {
        return $this->connections;
    }

    public function get(string|int $id): ?Model\ConnectionInterface
    {
        if (empty($this->connections)) {
            return null;
        }

        if (isset($this->connections[$id])) {
            return $this->connections[$id];
        }

        foreach ($this->connections as $connection) {
            if ($connection->getName() == $id) {
                return $connection;
            }
        }

        return null;
    }
}
