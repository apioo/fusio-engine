<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Tests\Json;

use Fusio\Engine\Json\Processor;
use PSX\Data\Reader;
use PSX\Data\Writer;

/**
 * ProcessorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testRead()
    {
        $data = <<<JSON
{"foo": "bar"}
JSON;

        $processor = $this->newProcessor();
        $result    = $processor->read($data);

        $this->assertEquals((object) ['foo' => 'bar'], $result);
    }

    public function testWrite()
    {
        $data = (object) ['foo' => 'bar'];

        $processor = $this->newProcessor();
        $result    = $processor->write($data);

        $this->assertJsonStringEqualsJsonString('{"foo": "bar"}', $result);
    }

    protected function newProcessor()
    {
        return new Processor(
            new Reader\Json(),
            new Writer\Json()
        );
    }
}
