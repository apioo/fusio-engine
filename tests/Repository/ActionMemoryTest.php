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

use Fusio\Engine\Model\Action;
use Fusio\Engine\Model\ActionInterface;
use Fusio\Engine\Repository;
use PHPUnit\Framework\TestCase;

/**
 * ActionMemoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ActionMemoryTest extends TestCase
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

        if ($repository instanceof Repository\ActionMemory) {
            $this->assertEquals(1, count($repository));
        }
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
        "class": "stdClass",
        "async": false,
        "config": {
            "foo": "bar"
        }
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
        "class": "stdClass",
        "async": false,
        "config": {
            "foo": "bar"
        }
    }
]
JSON;

        $actual = Repository\ActionMemory::fromJson($json);
        $expect = $this->createRepository();

        $this->assertEquals($expect, $actual);
    }

    protected function createRepository(): Repository\ActionInterface
    {
        $action = new Action(
            id: 1,
            name: 'foo',
            class: \stdClass::class,
            async: false,
            config: ['foo' => 'bar'],
        );

        $repository = new Repository\ActionMemory();
        $repository->add($action);

        return $repository;
    }
}
