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

namespace Fusio\Engine\Tests\Model;

use Fusio\Engine\Model\Action;
use PHPUnit\Framework\TestCase;

/**
 * ActionTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ActionTest extends TestCase
{
    public function testModel()
    {
        $model = new Action(1, 'foo', self::class, true, ['dsn' => 'secret']);

        $this->assertSame(1, $model->getId());
        $this->assertSame('foo', $model->getName());
        $this->assertSame(self::class, $model->getClass());
        $this->assertSame(true, $model->isAsync());
        $this->assertSame(['dsn' => 'secret'], $model->getConfig());
        $this->assertNull($model->getMetadata('foo'));
    }

    public function testModelWithMetadata()
    {
        $model = new Action(1, 'foo', self::class, true, ['dsn' => 'secret'], (object) ['foo' => 'bar']);

        $this->assertEquals('bar', $model->getMetadata('foo'));
    }

    public function testModelSerialize()
    {
        $model = new Action(1, 'foo', self::class, true, ['dsn' => 'secret'], (object) ['foo' => 'bar']);

        $actual = json_encode($model);
        $expect = <<<'JSON'
{
  "id": 1,
  "name": "foo",
  "class": "Fusio\\Engine\\Tests\\Model\\ActionTest",
  "async": true,
  "config": {
    "dsn": "secret"
  },
  "metadata": {
    "foo": "bar"
  }
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
