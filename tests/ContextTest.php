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

use Fusio\Engine\Context;
use Fusio\Engine\Model\App;
use Fusio\Engine\Model\User;
use Fusio\Engine\NameBuilder;
use PHPUnit\Framework\TestCase;
use PSX\Json\Parser;

/**
 * ContextTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ContextTest extends TestCase
{
    public function testContext(): void
    {
        $app = new App(false, 1, 1, 1, 'foo', 'https://myapp.com', 'key', ['foo' => 'bar'], ['foo', 'bar'], (object) ['foo' => 'bar']);
        $user = new User(false, 1, 1, 1, 1, 'bar', 'foo@bar.com', 1000, 'external_id', '1', (object) ['foo' => 'bar']);
        $context = new Context(1, 'https://api.acme.com', $app, $user, 'my_tenant');

        $actual = Parser::encode($context);
        $expect = file_get_contents(__DIR__ . '/resource/context.json');

        $this->assertNotFalse($expect);
        $this->assertJsonStringEqualsJsonString($expect, $actual);
    }
}
