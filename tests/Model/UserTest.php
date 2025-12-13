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

namespace Fusio\Engine\Tests\Model;

use Fusio\Engine\Model\User;
use Fusio\Engine\Model\UserAnonymous;
use PHPUnit\Framework\TestCase;

/**
 * UserTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class UserTest extends TestCase
{
    public function testModel()
    {
        $model = new User(false, 1, 1, 1, 1, 'foo', 'me@chrisk.app', 1337, 'external_id', '1');

        $this->assertSame(1, $model->getId());
        $this->assertSame(1, $model->getRoleId());
        $this->assertSame(1, $model->getCategoryId());
        $this->assertSame(1, $model->getStatus());
        $this->assertSame('foo', $model->getName());
        $this->assertSame('me@chrisk.app', $model->getEmail());
        $this->assertSame(1337, $model->getPoints());
        $this->assertSame('external_id', $model->getExternalId());
        $this->assertSame('1', $model->getPlanId());
        $this->assertNull($model->getMetadata('foo'));
    }

    public function testModelAnonymous()
    {
        $model = new UserAnonymous();

        $this->assertSame(0, $model->getId());
        $this->assertSame(0, $model->getRoleId());
        $this->assertSame(0, $model->getCategoryId());
        $this->assertSame(0, $model->getStatus());
        $this->assertSame('', $model->getName());
        $this->assertSame('', $model->getEmail());
        $this->assertSame(0, $model->getPoints());
        $this->assertSame(null, $model->getExternalId());
        $this->assertSame(null, $model->getPlanId());
        $this->assertNull($model->getMetadata('foo'));
    }

    public function testModelWithMetadata()
    {
        $model = new User(false, 1, 1, 1, 1, 'foo', 'me@chrisk.app', 1337, 'external_id', '1', (object) ['foo' => 'bar']);

        $this->assertEquals('bar', $model->getMetadata('foo'));
    }

    public function testModelSerialize()
    {
        $model = new User(false, 1, 1, 1, 1, 'foo', 'me@chrisk.app', 1337, 'external_id', '1', (object) ['foo' => 'bar']);

        $actual = json_encode($model);
        $expect = <<<'JSON'
{
  "anonymous": false,
  "id": 1,
  "roleId": 1,
  "categoryId": 1,
  "status": 1,
  "name": "foo",
  "email": "me@chrisk.app",
  "points": 1337,
  "externalId": "external_id",
  "planId": "1",
  "metadata": {
    "foo": "bar"
  }
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }


    public function testModelSerializeAnonymous()
    {
        $model = new UserAnonymous();

        $actual = json_encode($model);
        $expect = <<<'JSON'
{
  "anonymous": true
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
