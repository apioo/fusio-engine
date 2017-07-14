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

namespace Fusio\Engine\Tests\Repository;

use Fusio\Engine\Model\Action;
use Fusio\Engine\Model\ActionInterface;
use Fusio\Engine\Repository;

/**
 * ActionMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
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

    public function testCount()
    {
        $repository = $this->createRepository();

        $this->assertEquals(1, count($repository));
    }

    public function testJsonSerialize()
    {
        $repository = $this->createRepository();

        $actual = json_encode($repository, JSON_PRETTY_PRINT);
        $expect = <<<'JSON'
[
    {
        "id": 1,
        "name": "foo",
        "class": "\\stdClass",
        "engine": null,
        "config": {
            "foo": "bar"
        },
        "date": null
    }
]
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testJsonSerializeEmpty()
    {
        $repository = new Repository\ActionMemory();

        $this->assertSame([], $repository->jsonSerialize());
    }

    public function testFromJson()
    {
        $json = <<<'JSON'
[
    {
        "id": 1,
        "name": "foo",
        "class": "\\stdClass",
        "engine": null,
        "config": {
            "foo": "bar"
        },
        "date": null
    }
]
JSON;

        $actual = Repository\ActionMemory::fromJson($json);
        $expect = $this->createRepository();

        $this->assertEquals($expect, $actual);
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
        $action->setConfig(['foo' => 'bar']);

        $repository = new Repository\ActionMemory();
        $repository->add($action);

        return $repository;
    }
}
