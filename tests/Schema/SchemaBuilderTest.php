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

namespace Fusio\Engine\Tests\Schema;

use Fusio\Engine\Schema\SchemaBuilder;
use PHPUnit\Framework\TestCase;

/**
 * SchemaBuilderTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class SchemaBuilderTest extends TestCase
{
    public function testMakeCollectionParameters()
    {
        $actual = \json_encode(SchemaBuilder::makeCollectionParameters(), \JSON_PRETTY_PRINT);
        $expect = \file_get_contents(__DIR__ . '/resource/expect_parameters.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testMakeCollectionResponse()
    {
        $type = \json_decode(\file_get_contents(__DIR__ . '/resource/file.json'));

        $actual = \json_encode(SchemaBuilder::makeCollectionResponse('File_Directory_Index', $type), \JSON_PRETTY_PRINT);
        $expect = \file_get_contents(__DIR__ . '/resource/expect_collection.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testMakeCollectionResponseAny()
    {
        $actual = \json_encode(SchemaBuilder::makeCollectionResponse('File_Directory_Index', null), \JSON_PRETTY_PRINT);
        $expect = \file_get_contents(__DIR__ . '/resource/expect_collection_any.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
