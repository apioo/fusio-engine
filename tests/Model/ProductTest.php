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

use Fusio\Engine\Model\Connection;
use Fusio\Engine\Model\Product;
use PHPUnit\Framework\TestCase;

/**
 * ProductTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ProductTest extends TestCase
{
    public function testModel()
    {
        $model = new Product(1, 'foo', 1337, 1024, 1, 'external_id');

        $this->assertSame(1, $model->getId());
        $this->assertSame('foo', $model->getName());
        $this->assertSame(1337, $model->getPrice());
        $this->assertSame(1024, $model->getPoints());
        $this->assertSame(1, $model->getInterval());
        $this->assertSame('external_id', $model->getExternalId());
        $this->assertNull($model->getMetadata('foo'));
    }

    public function testModelWithMetadata()
    {
        $model = new Product(1, 'foo', 1337, 1024, 1, 'external_id', (object) ['foo' => 'bar']);

        $this->assertEquals('bar', $model->getMetadata('foo'));
    }

    public function testModelSerialize()
    {
        $model = new Product(1, 'foo', 1337, 1024, 1, 'external_id', (object) ['foo' => 'bar']);

        $actual = json_encode($model);
        $expect = <<<'JSON'
{
  "id": 1,
  "name": "foo",
  "price": 1337,
  "points": 1024,
  "interval": 1,
  "externalId": "external_id",
  "metadata": {
    "foo": "bar"
  }
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
