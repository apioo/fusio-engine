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

use Fusio\Engine\Model\App;
use Fusio\Engine\Model\AppAnonymous;
use PHPUnit\Framework\TestCase;
use PSX\Json\Parser;

/**
 * AppTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class AppTest extends TestCase
{
    public function testModel(): void
    {
        $model = new App(false, 1, 1, 1, 'foo', 'https://chrisk.app', 'key', ['param' => 'value'], ['foo']);

        $this->assertSame(1, $model->getId());
        $this->assertSame(1, $model->getUserId());
        $this->assertSame(1, $model->getStatus());
        $this->assertSame('foo', $model->getName());
        $this->assertSame('https://chrisk.app', $model->getUrl());
        $this->assertSame('key', $model->getAppKey());
        $this->assertSame(['param' => 'value'], $model->getParameters());
        $this->assertSame(['foo'], $model->getScopes());
        $this->assertNull($model->getMetadata('foo'));
    }

    public function testModelAnonymous(): void
    {
        $model = new AppAnonymous();

        $this->assertSame(0, $model->getId());
        $this->assertSame(0, $model->getUserId());
        $this->assertSame(0, $model->getStatus());
        $this->assertSame('', $model->getName());
        $this->assertSame('', $model->getUrl());
        $this->assertSame('', $model->getAppKey());
        $this->assertSame([], $model->getParameters());
        $this->assertSame([], $model->getScopes());
        $this->assertNull($model->getMetadata('foo'));
    }

    public function testModelWithMetadata(): void
    {
        $model = new App(false, 1, 1, 1, 'foo', 'https://chrisk.app', 'key', ['param' => 'value'], ['foo'], (object) ['foo' => 'bar']);

        $this->assertEquals('bar', $model->getMetadata('foo'));
    }

    public function testModelSerialize(): void
    {
        $model = new App(false, 1, 1, 1, 'foo', 'https://chrisk.app', 'key', ['param' => 'value'], ['foo'], (object) ['foo' => 'bar']);

        $actual = Parser::encode($model);
        $expect = <<<'JSON'
{
  "anonymous": false,
  "id": 1,
  "userId": 1,
  "status": 1,
  "name": "foo",
  "url": "https:\/\/chrisk.app",
  "parameters": {
    "param": "value"
  },
  "appKey": "key",
  "scopes": [
    "foo"
  ],
  "metadata": {
    "foo": "bar"
  }
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }


    public function testModelSerializeAnonymous(): void
    {
        $model = new AppAnonymous();

        $actual = Parser::encode($model);
        $expect = <<<'JSON'
{
  "anonymous": true
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
