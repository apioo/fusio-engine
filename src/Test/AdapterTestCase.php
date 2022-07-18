<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Fusio\Engine\ActionInterface;
use Fusio\Engine\AdapterInterface;
use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Form\Builder;
use Fusio\Engine\Form\Container;
use Fusio\Engine\Generator;
use Fusio\Engine\Payment;
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

    public function testDefinition(): void
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

    private function validateSchema(\stdClass $data): void
    {
        $manager = new SchemaManager();
        $schema  = $manager->getSchema(__DIR__ . '/definition_schema.json');

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $schema);
    }

    private function validateClassTypes(\stdClass $data): void
    {
        $types = ['action', 'connection', 'user', 'payment', 'generator'];

        foreach ($types as $type) {
            $key = $type . 'Class';
            if (isset($data->{$key})) {
                foreach ($data->{$key} as $class) {
                    if (!class_exists($class)) {
                        $this->fail('Defined ' . $key . ' class ' . $class . ' does not exist');
                    }

                    $this->validateClassType($type, $class);
                }
            }
        }
    }

    /**
     * Returns the adapter class name
     */
    abstract protected function getAdapterClass(): string;

    private function validateClassType(string $type, string $class): void
    {
        switch ($type) {
            case 'action':
                $action = $this->getActionFactory()->factory($class);
                $this->validateAction($action);
                break;
            case 'connection':
                $connection = $this->getConnectionFactory()->factory($class);
                $this->validateConnection($connection);
                break;
            case 'user':
                $provider = $this->getContainerAutowireResolver()->getObject($class);
                if (!$provider instanceof User\ProviderInterface) {
                    $this->fail('Defined user ' . $class . ' must be an instance of ' . User\ProviderInterface::class);
                }

                $this->validateUser($provider);
                break;
            case 'payment':
                $provider = $this->getContainerAutowireResolver()->getObject($class);
                if (!$provider instanceof Payment\ProviderInterface) {
                    $this->fail('Defined payment ' . $class . ' must be an instance of ' . Payment\ProviderInterface::class);
                }

                $this->validatePayment($provider);
                break;
            case 'generator':
                $provider = $this->getContainerAutowireResolver()->getObject($class);
                if (!$provider instanceof Generator\ProviderInterface) {
                    $this->fail('Defined routes ' . $class . ' must be an instance of ' . Generator\ProviderInterface::class);
                }

                $this->validateGenerator($provider);
                break;
        }
    }

    private function validateAction(ActionInterface $action): void
    {
        $this->assertNotEmpty($action->getName());
        $this->validateConfigurable($action);
    }

    private function validateConnection(ConnectionInterface $connection): void
    {
        $this->assertNotEmpty($connection->getName());
        $this->validateConfigurable($connection);
    }

    private function validateConfigurable(ConfigurableInterface $object): void
    {
        $builder = new Builder();
        $factory = $this->getFormElementFactory();

        $object->configure($builder, $factory);

        $this->assertInstanceOf(Container::class, $builder->getForm());
    }

    private function validateUser(User\ProviderInterface $provider): void
    {
        $this->assertNotEmpty($provider->getId());
    }

    private function validatePayment(Payment\ProviderInterface $provider): void
    {
    }

    private function validateGenerator(Generator\ProviderInterface $provider): void
    {
        $this->assertNotEmpty($provider->getName());
    }
}
