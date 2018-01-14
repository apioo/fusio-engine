<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Tests\Repository;

use Fusio\Engine\Model\Connection;
use Fusio\Engine\Model\ConnectionInterface;
use Fusio\Engine\Repository;

/**
 * ConnectionMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ConnectionMemoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $repository = $this->createRepository();

        $connection = $repository->get(1);
        $this->assertInstanceOf(Connection::class, $connection);
        $this->assertSame(1, $connection->getId());
        $this->assertSame('foo', $connection->getName());

        $connection = $repository->get('foo');
        $this->assertInstanceOf(Connection::class, $connection);
        $this->assertSame(1, $connection->getId());
        $this->assertSame('foo', $connection->getName());
    }

    public function testGetAll()
    {
        $repository  = $this->createRepository();
        $connections = $repository->getAll();

        $this->assertContainsOnlyInstancesOf(ConnectionInterface::class, $connections);
        $this->assertSame(1, count($connections));

        $connection = reset($connections);
        $this->assertInstanceOf(Connection::class, $connection);
        $this->assertSame(1, $connection->getId());
        $this->assertSame('foo', $connection->getName());
    }

    /**
     * @return \Fusio\Engine\Repository\ConnectionInterface
     */
    protected function createRepository()
    {
        $connection = new Connection();
        $connection->setId(1);
        $connection->setName('foo');

        $repository = new Repository\ConnectionMemory();
        $repository->add($connection);

        return $repository;
    }
}
