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

use Fusio\Engine\NameBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * NameBuilderTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class NameBuilderTest extends TestCase
{
    #[DataProvider('providerNames')]
    public function testFromClass(string $action, string $expect)
    {
        $this->assertSame($expect, NameBuilder::fromClass($action));
    }

    public static function providerNames(): array
    {
        return [
            ['Foo', 'Foo'],
            ['FooBar', 'Foo-Bar'],
            ['Bar\\Foo', 'Foo'],
            ['Bar\\FooBar', 'Foo-Bar'],
        ];
    }
}
