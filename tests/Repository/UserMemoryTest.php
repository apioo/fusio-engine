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

namespace Fusio\Engine\Tests\Repository;

use Fusio\Engine\Model\User;
use Fusio\Engine\Model\UserInterface;
use Fusio\Engine\Repository;
use PHPUnit\Framework\TestCase;

/**
 * UserMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
