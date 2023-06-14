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

namespace Fusio\Engine\Tests\Repository;

use Fusio\Engine\Model\Connection;
use Fusio\Engine\Model\ConnectionInterface;
use Fusio\Engine\Repository;
use PHPUnit\Framework\TestCase;

/**
 * ConnectionMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ConnectionMemoryTest extends TestCase
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

    protected function createRepository(): Repository\ConnectionInterface
    {
        $connection = new Connection(
            id: 1,
            name: 'foo',
            class: \stdClass::class,
            config: [],
        );

        $repository = new Repository\ConnectionMemory();
        $repository->add($connection);

        return $repository;
    }
}
