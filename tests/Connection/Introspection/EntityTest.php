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

namespace Fusio\Engine\Tests;

use Fusio\Engine\Connection\Introspection\Details;
use Fusio\Engine\Connection\Introspection\Entity;
use Fusio\Engine\Connection\Introspection\Row;
use PHPUnit\Framework\TestCase;

/**
 * EntityTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class EntityTest extends TestCase
{
    public function testEntity()
    {
        $entity = new Entity('foobar', [
            'Name',
            'Type',
            'Comment',
        ]);

        $entity->addRow(new Row([
            'foo',
            'string',
            'comment',
        ]));

        $entity->addRow(new Row([
            'bar',
            'string',
            'comment',
        ]));

        $actual = json_encode($entity);
        $expect = <<<JSON
{
  "name": "foobar",
  "headers": [
    "Name",
    "Type",
    "Comment"
  ],
  "rows": [
    {
      "values": [
        "foo",
        "string",
        "comment"
      ]
    },
    {
      "values": [
        "bar",
        "string",
        "comment"
      ]
    }
  ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
