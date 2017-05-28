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

namespace Fusio\Engine;

use Fusio\Engine\Factory;
use RuntimeException;

/**
 * Connector
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Connector implements ConnectorInterface
{
    /**
     * @var \Fusio\Engine\Repository\ConnectionInterface
     */
    protected $repository;

    /**
     * @var \Fusio\Engine\Factory\ConnectionInterface
     */
    protected $factory;

    /**
     * @param \Fusio\Engine\Repository\ConnectionInterface $repository
     * @param \Fusio\Engine\Factory\ConnectionInterface $factory
     */
    public function __construct(Repository\ConnectionInterface $repository, Factory\ConnectionInterface $factory)
    {
        $this->repository = $repository;
        $this->factory    = $factory;
    }

    /**
     * Returns an arbitrary connection to a system which was previously
     * configured by the user
     *
     * @param integer $connectionId
     * @return \Fusio\Engine\ConnectionInterface
     */
    public function getConnection($connectionId)
    {
        $connection = $this->repository->get($connectionId);

        if ($connection instanceof Model\ConnectionInterface) {
            $parameters = new Parameters($connection->getConfig());

            return $this->factory->factory($connection->getClass())->getConnection($parameters);
        } else {
            throw new RuntimeException('Could not found connection ' . $connectionId);
        }
    }
}
