<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Fusio\Engine\Model\User;
use Fusio\Engine\Model\UserInterface;
use Fusio\Engine\Repository;
use PHPUnit\Framework\TestCase;

/**
 * UserMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class UserMemoryTest extends TestCase
{
    public function testGet()
    {
        $repository = $this->createRepository();

        $user = $repository->get(1);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(1, $user->getId());
        $this->assertSame('foo', $user->getName());
    }

    public function testGetAll()
    {
        $repository  = $this->createRepository();
        $connections = $repository->getAll();

        $this->assertContainsOnlyInstancesOf(UserInterface::class, $connections);
        $this->assertSame(1, count($connections));

        $connection = reset($connections);
        $this->assertInstanceOf(UserInterface::class, $connection);
        $this->assertSame(1, $connection->getId());
        $this->assertSame('foo', $connection->getName());
    }

    /**
     * @return \Fusio\Engine\Repository\UserInterface
     */
    protected function createRepository()
    {
        $user = new User(
            anonymous: false,
            id: 1,
            roleId: 1,
            categoryId: 1,
            status: 1,
            name: 'foo',
            email: 'foo@bar.com',
            points: 10,
        );

        $repository = new Repository\UserMemory();
        $repository->add($user);

        return $repository;
    }
}
