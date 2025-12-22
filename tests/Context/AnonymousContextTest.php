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

namespace Fusio\Engine\Tests\Context;

use Fusio\Engine\Context;
use Fusio\Engine\Model\App;
use Fusio\Engine\Model\User;
use Fusio\Engine\NameBuilder;
use PHPUnit\Framework\TestCase;
use PSX\Json\Parser;

/**
 * AnonymousContextTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class AnonymousContextTest extends TestCase
{
    public function testContext(): void
    {
        $context = new Context\AnonymousContext('my_tenant');

        $actual = Parser::encode($context);
        $expect = file_get_contents(__DIR__ . '/../resource/context_anonymous.json');

        $this->assertNotFalse($expect);
        $this->assertJsonStringEqualsJsonString($expect, $actual);
    }
}
