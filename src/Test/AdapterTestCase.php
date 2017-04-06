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

namespace Fusio\Engine\Test;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Fusio\Engine\AdapterInterface;
use Fusio\Engine\Factory;
use Fusio\Engine\Repository;
use PSX\Schema\SchemaManager;
use PSX\Schema\SchemaTraverser;

/**
 * AdapterTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
abstract class AdapterTestCase extends \PHPUnit_Framework_TestCase
{
    public function testDefinition()
    {
        $class = $this->getAdapterClass();

        $this->assertTrue(class_exists($class));

        /** @var AdapterInterface $adapter */
        $adapter = new $class();

        $this->assertInstanceOf(AdapterInterface::class, $adapter);

        $path = $adapter->getDefinition();
        if (!is_file($path)) {
            $this->fail('Adapter definition file ' . $path . ' does not exist');
        }

        $data = json_decode(file_get_contents($path));

        $this->validateSchema($data);
        $this->validateClassExistence($data);
    }

    private function validateSchema(\stdClass $data)
    {
        $manager = new SchemaManager(new SimpleAnnotationReader());
        $schema  = $manager->getSchema(__DIR__ . '/definition_schema.json');

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $schema);
    }

    private function validateClassExistence(\stdClass $data)
    {
        if (isset($data->actionClass)) {
            foreach ($data->actionClass as $class) {
                if (!class_exists($class)) {
                    $this->fail('Defined action class ' . $class . ' does not exist');
                }
            }
        }

        if (isset($data->connectionClass)) {
            foreach ($data->connectionClass as $class) {
                if (!class_exists($class)) {
                    $this->fail('Defined connection class ' . $class . ' does not exist');
                }
            }
        }
    }

    /**
     * Returns the adapter class name
     * 
     * @return string
     */
    abstract protected function getAdapterClass();
}
