<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use Fusio\Engine\ActionInterface;
use Fusio\Engine\AdapterInterface;
use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Factory\ResolverInterface;
use Fusio\Engine\Form\Builder;
use Fusio\Engine\Form\Container;
use Fusio\Engine\Parameters;
use Fusio\Engine\Payment;
use Fusio\Engine\Routes;
use Fusio\Engine\Routes\Setup;
use Fusio\Engine\User;
use PHPUnit\Framework\TestCase;
use PSX\Schema\SchemaManager;
use PSX\Schema\SchemaTraverser;

/**
 * AdapterTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
abstract class AdapterTestCase extends TestCase
{
    use EngineTestCaseTrait;

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

        $this->assertInstanceOf(\stdClass::class, $data);

        $this->validateSchema($data);
        $this->validateClassTypes($data);
    }

    private function validateSchema(\stdClass $data)
    {
        $manager = new SchemaManager(new SimpleAnnotationReader());
        $schema  = $manager->getSchema(__DIR__ . '/definition_schema.json');

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $schema);
    }

    private function validateClassTypes(\stdClass $data)
    {
        $types = ['action', 'connection', 'user', 'payment', 'routes'];

        foreach ($types as $type) {
            $key = $type . 'Class';
            if (isset($data->{$key})) {
                foreach ($data->{$key} as $class) {
                    if (!class_exists($class)) {
                        $this->fail('Defined ' . $key . ' class ' . $class . ' does not exist');
                    }

                    if ($type === 'action') {
                        $action = $this->getActionFactory()->factory($class);
                        if (!$action instanceof ActionInterface) {
                            $this->fail('Defined action ' . $class . ' must be an instance of ' . ActionInterface::class);
                        }

                        $this->validateAction($action);
                    } elseif ($type === 'connection') {
                        $connection = $this->getConnectionFactory()->factory($class);
                        if (!$connection instanceof ConnectionInterface) {
                            $this->fail('Defined connection ' . $class . ' must be an instance of ' . ConnectionInterface::class);
                        }

                        $this->validateConnection($connection);
                    } elseif ($type === 'user') {
                        $provider = new $class('google');
                        if (!$provider instanceof User\ProviderInterface) {
                            $this->fail('Defined user ' . $class . ' must be an instance of ' . User\ProviderInterface::class);
                        }

                        $this->validateUser($provider);
                    } elseif ($type === 'payment') {
                        $provider = new $class();
                        if (!$provider instanceof Payment\ProviderInterface) {
                            $this->fail('Defined payment ' . $class . ' must be an instance of ' . Payment\ProviderInterface::class);
                        }

                        $this->validatePayment($provider);
                    } elseif ($type === 'routes') {
                        $provider = new $class();
                        if (!$provider instanceof Routes\ProviderInterface) {
                            $this->fail('Defined routes ' . $class . ' must be an instance of ' . Routes\ProviderInterface::class);
                        }

                        $this->validateRoutes($provider);
                    }
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

    private function validateAction(ActionInterface $action)
    {
        $this->assertNotEmpty($action->getName());
        $this->assertTrue(is_string($action->getName()));

        if ($action instanceof ConfigurableInterface) {
            $this->validateConfigurable($action);
        }
    }

    private function validateConnection(ConnectionInterface $connection)
    {
        $this->assertNotEmpty($connection->getName());
        $this->assertTrue(is_string($connection->getName()));

        if ($connection instanceof ConfigurableInterface) {
            $this->validateConfigurable($connection);
        }
    }

    private function validateConfigurable(ConfigurableInterface $object)
    {
        $builder = new Builder();
        $factory = $this->getFormElementFactory();

        $object->configure($builder, $factory);

        $this->assertInstanceOf(Container::class, $builder->getForm());
    }

    private function validateUser(User\ProviderInterface $provider)
    {
        $this->assertNotEmpty($provider->getId());
        $this->assertTrue(is_int($provider->getId()));
    }

    private function validatePayment(Payment\ProviderInterface $provider)
    {
    }

    private function validateRoutes(Routes\ProviderInterface $provider)
    {
        $this->assertNotEmpty($provider->getName());
        $this->assertTrue(is_string($provider->getName()));

        $setup = new Setup();
        $configuration = new Parameters([]);

        $provider->setup($setup, '/foo', $configuration);

        $this->validateRoutesSchema($setup);
        $this->validateRoutesAction($setup);
        $this->validateRoutesRoute($setup);
    }

    private function validateRoutesSchema(Setup $setup)
    {
        $schemas = $setup->getSchemas();
        foreach ($schemas as $schema) {
            $this->assertNotEmpty($schema->name);
            $this->assertInstanceOf(\stdClass::class, $schema->source); // source contains the JSON schema
        }
    }

    private function validateRoutesAction(Setup $setup)
    {
        $actions = $setup->getActions();
        foreach ($actions as $action) {
            $this->assertNotEmpty($action->name);
            $this->assertNotEmpty($action->class);
            $this->assertNotEmpty($action->engine);

            $this->assertTrue(class_exists($action->class));
            $instance = $this->getActionFactory()->factory($action->class);
            $this->assertInstanceOf(ActionInterface::class, $instance);

            $this->assertTrue(class_exists($action->engine));
            $engine = $action->engine;
            $this->assertInstanceOf(ResolverInterface::class, new $engine());
        }
    }

    private function validateRoutesRoute(Setup $setup)
    {
        $routes = $setup->getRoutes();
        foreach ($routes as $route) {
            $this->assertNotEmpty($route->path);
            $this->assertNotEmpty($route->controller);
            $this->assertNotEmpty($route->config);

            // @TODO check whether the config is correct
        }
    }
}
