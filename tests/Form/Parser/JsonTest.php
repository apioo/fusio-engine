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

use Fusio\Engine\Test\EngineTestCaseTrait;
use Fusio\Engine\Form;
use Fusio\Engine\Tests\Test\TestAdapter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PSX\Json\Parser;
use PSX\Schema\ObjectMapper;
use PSX\Schema\SchemaManager;

/**
 * JsonTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class JsonTest extends TestCase
{
    use EngineTestCaseTrait;

    public function testParse(): void
    {
        $data = $this->getExpect();
        $parser = new Form\Parser\Json($this->getFormElementFactory());

        $form = $parser->parse($data);

        $this->assertInstanceOf(Form\Container::class, $form);
        $this->assertEquals(11, count($form->getElements()));

        $actual = Parser::encode($form);
        $expect = $this->getExpect();

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    private function getExpect(): string
    {
        return <<<JSON
{
    "element": [
        {
            "element": "action",
            "name": "action",
            "title": "Action",
            "help": "Action description"
        },
        {
            "element": "agent",
            "name": "agent",
            "title": "Agent",
            "help": "Agent description"
        },
        {
            "element": "checkbox",
            "name": "checkbox",
            "title": "Checkbox",
            "help": "Checkbox description"
        },
        {
            "element": "collection",
            "name": "collection",
            "title": "Collection",
            "help": "Collection description",
            "type": "text"
        },
        {
            "element": "connection",
            "name": "connection",
            "title": "Connection",
            "help": "Connection description"
        },
        {
            "element": "input",
            "name": "input",
            "title": "Input",
            "help": "Input description",
            "type": "text"
        },
        {
            "element": "map",
            "name": "map",
            "title": "Map",
            "help": "Map description",
            "type": "text"
        },
        {
            "element": "select",
            "name": "select",
            "title": "Select",
            "help": "Select description",
            "options": [
                {
                    "key": "foo",
                    "value": "Foo"
                },
                {
                    "key": "bar",
                    "value": "Bar"
                }
            ]
        },
        {
            "element": "textarea",
            "name": "textarea",
            "title": "TextArea",
            "help": "TextArea description",
            "mode": "json"
        },
        {
            "element": "typeapi",
            "help": "TypeAPI description",
            "name": "typeapi",
            "title": "TypeAPI"
        },
        {
            "element": "typeschema",
            "help": "TypeSchema description",
            "name": "typeschema",
            "title": "TypeSchema"
        }
    ]
}
JSON;
    }

    protected function getAdapterClass(): string
    {
        return TestAdapter::class;
    }
}
