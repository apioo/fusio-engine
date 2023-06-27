<?php
/*
 * Fusio is an open source API management platform which helps to create innovative API solutions.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Tests\Generator;

use Fusio\Engine\Generator\Setup;
use Fusio\Model\Backend\ActionConfig;
use Fusio\Model\Backend\ActionCreate;
use Fusio\Model\Backend\OperationCreate;
use Fusio\Model\Backend\SchemaCreate;
use Fusio\Model\Backend\SchemaSource;
use PHPUnit\Framework\TestCase;

/**
 * SetupTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class SetupTest extends TestCase
{
    public function testAddAction()
    {
        $setup = new Setup();

        $action = new ActionCreate();
        $action->setName('foo_action');
        $action->setClass(\stdClass::class);
        $action->setConfig(ActionConfig::fromArray(['table' => 'foobar']));
        $setup->addAction($action);

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

        $this->assertSame(1, count($setup->getActions()));
        $this->assertJsonStringEqualsJsonString($expect, json_encode($setup->getActions()[0]));
    }

    public function testAddSchema()
    {
        $setup = new Setup();

        $schema = new SchemaCreate();
        $schema->setName('foo_schema');
        $schema->setSource(SchemaSource::fromArray(['type' => 'object']));
        $setup->addSchema($schema);

        $expect = <<<JSON
{
  "name": "foo_schema",
  "source": {
    "type": "object"
  }
}
JSON;

        $this->assertSame(1, count($setup->getSchemas()));
        $this->assertJsonStringEqualsJsonString($expect, json_encode($setup->getSchemas()[0]));
    }

    public function testAddRoute()
    {
        $setup = new Setup();

        $schema = new SchemaCreate();
        $schema->setName('foo_schema');
        $schema->setSource(SchemaSource::fromArray(['type' => 'object']));
        $setup->addSchema($schema);

        $action = new ActionCreate();
        $action->setName('foo_action');
        $action->setClass(\stdClass::class);
        $action->setConfig(ActionConfig::fromArray(['table' => 'foobar']));
        $setup->addAction($action);

        $operation = new OperationCreate();
        $operation->setName('my_operation');
        $operation->setHttpMethod('POST');
        $operation->setHttpPath('/foo');
        $operation->setAction($action->getName());
        $operation->setIncoming($schema->getName());
        $operation->setOutgoing($schema->getName());
        $setup->addOperation($operation);

        $expect = <<<JSON
{
  "httpMethod": "POST",
  "httpPath": "\/foo",
  "name": "my_operation",
  "incoming": "foo_schema",
  "outgoing": "foo_schema",
  "action": "foo_action"
}
JSON;

        $this->assertSame(1, count($setup->getOperations()));
        $this->assertJsonStringEqualsJsonString($expect, json_encode($setup->getOperations()[0]));
    }
}
