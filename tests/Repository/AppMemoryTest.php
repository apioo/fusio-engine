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

use Fusio\Engine\Model\App;
use Fusio\Engine\Model\AppInterface;
use Fusio\Engine\Repository;
use PHPUnit\Framework\TestCase;

/**
 * AppMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class AppMemoryTest extends TestCase
{
    public function testGet()
    {
        $repository = $this->createRepository();

        $app = $repository->get(1);
        $this->assertInstanceOf(App::class, $app);
        $this->assertSame(1, $app->getId());
        $this->assertSame('foo', $app->getName());
    }

    public function testGetAll()
    {
        $repository  = $this->createRepository();
        $connections = $repository->getAll();

        $this->assertContainsOnlyInstancesOf(AppInterface::class, $connections);
        $this->assertSame(1, count($connections));

        $connection = reset($connections);
        $this->assertInstanceOf(AppInterface::class, $connection);
        $this->assertSame(1, $connection->getId());
        $this->assertSame('foo', $connection->getName());
    }

    protected function createRepository(): Repository\AppInterface
    {
        $app = new App(
            anonymous: false,
            id: 1,
            userId: 1,
            status: 1,
            name: 'foo',
            url: 'url',
            appKey: 'key',
            parameters: [],
            scopes: [],
        );

        $repository = new Repository\AppMemory();
        $repository->add($app);

        return $repository;
    }
}
