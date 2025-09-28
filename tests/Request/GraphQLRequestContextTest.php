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

namespace Fusio\Engine\Tests\Request;

use Fusio\Engine\Request\CronjobRequestContext;
use Fusio\Engine\Request\GraphQLRequestContext;
use PHPUnit\Framework\TestCase;

/**
 * GraphQLRequestContextTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class GraphQLRequestContextTest extends TestCase
{
    public function testSerialize()
    {
        $context = new GraphQLRequestContext('foo', 'bar', ['field' => true]);

        $actual = \json_encode($context);
        $expect = <<<JSON
{
  "type": "Fusio.Engine.Request.GraphQLRequestContext",
  "rootValue": "foo",
  "context": "bar",
  "fieldSelection": {
    "field": true
  }
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual);
    }
}
