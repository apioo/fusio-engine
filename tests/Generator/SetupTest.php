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

namespace Fusio\Engine\Tests\Generator;

use Fusio\Engine\Generator\Setup;
use PHPUnit\Framework\TestCase;

/**
 * SetupTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class SetupTest extends TestCase
{
    public function testAddAction()
    {
        $setup = new Setup();

        $return = $setup->addAction('foo_action', \stdClass::class, \stdClass::class, [
            'table' => 'foobar'
        ]);

        $expect = <<<JSON
{
  "name": "foo_action",
  "class": "stdClass",
  "engine": "stdClass",
  "config": {
    "table": "foobar"
  }
}
JSON;

        $this->assertSame(0, $return);
        $this->assertSame(1, count($setup->getActions()));
        $this->assertJsonStringEqualsJsonString($expect, json_encode($setup->getActions()[0]));

        $return = $setup->addAction('foo_action', \stdClass::class, \stdClass::class, [
            'table' => 'foobar'
        ]);

        $this->assertSame(1, $return);
    }

    public function testAddSchema()
    {
        $setup = new Setup();

        $return = $setup->addSchema('foo_schema', [
            'type' => 'object'
        ]);

        $expect = <<<JSON
{
  "name": "foo_schema",
  "source": {
    "type": "object"
  }
}
JSON;

        $this->assertSame(0, $return);
        $this->assertSame(1, count($setup->getSchemas()));
        $this->assertJsonStringEqualsJsonString($expect, json_encode($setup->getSchemas()[0]));

        $return = $setup->addSchema('foo_schema', [
            'type' => 'object'
        ]);

        $this->assertSame(1, $return);
    }

    public function testAddRoute()
    {
        $setup = new Setup();

        $schema = $setup->addSchema('foo_schema', [
            'type' => 'object'
        ]);

        $action = $setup->addAction('foo_action', \stdClass::class, \stdClass::class, [
            'table' => 'foobar'
        ]);

        $return = $setup->addRoute(1, '/foo', \stdClass::class, ['foo', 'bar'], [
            [
                'version' => 1,
                'methods' => [
                    'POST' => [
                        'active' => true,
                        'public' => false,
                        'description' => 'Creates a new entity',
                        'parameters' => $schema,
                        'request' => $schema,
                        'responses' => [
                            201 => $schema,
                        ],
                        'action' => $action,
                    ]
                ],
            ]
        ]);

        $expect = <<<JSON
{
  "priority": 1,
  "path": "\/foo",
  "controller": "stdClass",
  "scopes": [
    "foo",
    "bar"
  ],
  "config": [
    {
      "version": 1,
      "methods": {
        "POST": {
          "active": true,
          "public": false,
          "description": "Creates a new entity",
          "request": "0",
          "responses": {
            "201": "0"
          },
          "action": "0"
        }
      }
    }
  ]
}
JSON;

        $this->assertSame(0, $return);
        $this->assertSame(1, count($setup->getRoutes()));
        $this->assertJsonStringEqualsJsonString($expect, json_encode($setup->getRoutes()[0]));

        $return = $setup->addRoute(1, '/foo', \stdClass::class, ['foo', 'bar'], [
            'version' => 1,
            'methods' => [],
        ]);

        $this->assertSame(1, $return);
    }
}
