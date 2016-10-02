<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

use Fusio\Engine\Repository;
use Fusio\Engine\Model\Action;
use Fusio\Engine\Model\ActionInterface;

/**
 * ActionMemoryTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ActionMemoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $repository = $this->createRepository();

        $action = $repository->get(1);
        $this->assertInstanceOf(Action::class, $action);
        $this->assertSame(1, $action->getId());
        $this->assertSame('foo', $action->getName());

        $action = $repository->get('foo');
        $this->assertInstanceOf(Action::class, $action);
        $this->assertSame(1, $action->getId());
        $this->assertSame('foo', $action->getName());
    }

    public function testGetAll()
    {
        $repository = $this->createRepository();
        $actions    = $repository->getAll();

        $this->assertContainsOnlyInstancesOf(ActionInterface::class, $actions);
        $this->assertSame(1, count($actions));

        $action = reset($actions);
        $this->assertInstanceOf(Action::class, $action);
        $this->assertSame(1, $action->getId());
        $this->assertSame('foo', $action->getName());
    }

    /**
     * @return \Fusio\Engine\Repository\ActionInterface
     */
    protected function createRepository()
    {
        $action = new Action();
        $action->setId(1);
        $action->setName('foo');
        $action->setClass('\stdClass');

        $repository = new Repository\ActionMemory();
        $repository->add($action);

        return $repository;
    }
}
