<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Tests;

use Fusio\Engine\Connection\Introspection\Details;
use Fusio\Engine\Connection\Introspection\Entity;
use Fusio\Engine\Connection\Introspection\Row;
use PHPUnit\Framework\TestCase;

/**
 * EntityTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
