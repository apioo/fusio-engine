<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use Fusio\Engine\Factory\ContainerAwareInterface;
use Fusio\Engine\Factory\ResolverInterface;
use Fusio\Engine\Parameters;
use Fusio\Engine\Routes;
use Fusio\Engine\Routes\Setup;

/**
 * RoutesTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
trait RoutesTestCaseTrait
{
    protected function assertProvider(string $class)
    {
        if (!class_exists($class)) {
            $this->fail('Routes provider class ' . $class . ' does not exist');
        }

        $provider = new $class();
        if (!$provider instanceof Routes\ProviderInterface) {
            $this->fail('Defined routes ' . $class . ' must be an instance of ' . Routes\ProviderInterface::class);
        }

        if ($provider instanceof ContainerAwareInterface) {
            $provider->setContainer($this->getContainer());
        }

        $this->assertNotEmpty($provider->getName());
        $this->assertTrue(is_string($provider->getName()));

        $setup = new Setup();
        $configuration = $this->getConfiguration();

        $provider->setup($setup, '/foo', $configuration);

        $this->validateRoutesSchema($setup);
        $this->validateRoutesAction($setup);
        $this->validateRoutesRoute($setup);
    }
    
    protected function getConfiguration(): Parameters
    {
        return new Parameters([]);
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

