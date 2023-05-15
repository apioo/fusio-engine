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

namespace Fusio\Engine\Tests\Generator;

use Fusio\Engine\Generator\Setup;
use Fusio\Model\Backend\Action;
use Fusio\Model\Backend\ActionConfig;
use Fusio\Model\Backend\Operation;
use Fusio\Model\Backend\Schema;
use Fusio\Model\Backend\SchemaSource;
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

        $action = new Action();
        $action->setName('foo_action');
        $action->setClass(\stdClass::class);
        $action->setEngine(\stdClass::class);
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

        $schema = new Schema();
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

        $schema = new Schema();
        $schema->setName('foo_schema');
        $schema->setSource(SchemaSource::fromArray(['type' => 'object']));
        $setup->addSchema($schema);

        $action = new Action();
        $action->setName('foo_action');
        $action->setClass(\stdClass::class);
        $action->setEngine(\stdClass::class);
        $action->setConfig(ActionConfig::fromArray(['table' => 'foobar']));
        $setup->addAction($action);

        $operation = new Operation();
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
