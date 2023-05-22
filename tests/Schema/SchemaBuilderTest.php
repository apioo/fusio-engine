<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Tests\Schema;

use Fusio\Engine\Schema\SchemaBuilder;
use PHPUnit\Framework\TestCase;

/**
 * SchemaBuilderTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
