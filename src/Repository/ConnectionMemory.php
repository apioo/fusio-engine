<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Repository;

use Fusio\Engine\Model;

/**
 * ConnectionMemory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ConnectionMemory implements ConnectionInterface
{
    /**
     * @var \Fusio\Engine\Model\ConnectionInterface[]
     */
    protected $connections;

    /**
     * @param array $connections
     */
    public function __construct(array $connections = array())
    {
        $this->connections = $connections;
    }

    /**
     * @param \Fusio\Engine\Model\ConnectionInterface $connection
     */
    public function add(Model\ConnectionInterface $connection)
    {
        $this->connections[$connection->getId()] = $connection;
    }

    /**
     * @return \Fusio\Engine\Model\ConnectionInterface[]
     */
    public function getAll()
    {
        return $this->connections;
    }

    /**
     * @param integer|string $connectionId
     * @return \Fusio\Engine\Model\ConnectionInterface|null
     */
    public function get($connectionId)
    {
        if (empty($this->connections)) {
            return null;
        }

        if (isset($this->connections[$connectionId])) {
            return $this->connections[$connectionId];
        }

        foreach ($this->connections as $connection) {
            if ($connection->getName() == $connectionId) {
                return $connection;
            }
        }

        return null;
    }
}
