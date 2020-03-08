<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Fusio\Engine\Model\App;
use Fusio\Engine\Model\AppInterface;
use Fusio\Engine\Repository;
use PHPUnit\Framework\TestCase;

/**
 * AppMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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

    /**
     * @return \Fusio\Engine\Repository\AppInterface
     */
    protected function createRepository()
    {
        $app = new App();
        $app->setId(1);
        $app->setName('foo');

        $repository = new Repository\AppMemory();
        $repository->add($app);

        return $repository;
    }
}
