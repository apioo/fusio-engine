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

namespace Fusio\Engine\Generator;

use Fusio\Model\Backend\ActionConfig;
use Fusio\Model\Backend\ActionCreate;
use Fusio\Model\Backend\RouteCreate;
use Fusio\Model\Backend\RouteMethod;
use Fusio\Model\Backend\RouteMethodResponses;
use Fusio\Model\Backend\RouteMethods;
use Fusio\Model\Backend\RouteVersion;
use Fusio\Model\Backend\SchemaCreate;
use Fusio\Model\Backend\SchemaSource;

/**
 * Setup
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Setup implements SetupInterface
{
    /**
     * @var SchemaCreate[]
     */
    private array $schemas = [];

    /**
     * @var ActionCreate[]
     */
    private array $actions = [];

    /**
     * @var RouteCreate[]
     */
    private array $routes = [];

    private int $schemaIndex = -1;
    private int $actionIndex = -1;
    private int $routesIndex = -1;

    public function addSchema(string $name, array $source): int
    {
        $this->schemaIndex++;

        $schema = new SchemaCreate();
        $schema->setName($name);
        $schema->setSource(SchemaSource::fromArray($source));

        $this->schemas[$this->schemaIndex] = $schema;

        return $this->schemaIndex;
    }

    public function addAction(string $name, string $class, string $engine, array $config): int
    {
        $this->actionIndex++;

        $action = new ActionCreate();
        $action->setName($name);
        $action->setClass($class);
        $action->setEngine($engine);
        $action->setConfig(ActionConfig::fromArray($config));

        $this->actions[$this->actionIndex] = $action;

        return $this->actionIndex;
    }

    public function addRoute(int $priority, string $path, string $controller, array $scopes, array $config): int
    {
        $this->routesIndex++;

        $route = new RouteCreate();
        $route->setPriority($priority);
        $route->setPath($path);
        $route->setController($controller);
        $route->setScopes($scopes);
        $route->setConfig($this->convertConfig($config));

        $this->routes[$this->routesIndex] = $route;

        return $this->routesIndex;
    }

    /**
     * @return SchemaCreate[]
     */
    public function getSchemas(): array
    {
        return $this->schemas;
    }

    /**
     * @return ActionCreate[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return RouteCreate[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function convertConfig(array $config): array
    {
        $result = [];
        foreach ($config as $version) {
            if ($version instanceof RouteVersion) {
                $result[] = $version;
            } elseif (is_array($version)) {
                $result[] = $this->convertVersion($version);
            } elseif ($version instanceof \stdClass) {
                $result[] = $this->convertVersion((array) $version);
            }
        }

        return $result;
    }

    private function convertVersion(array $version): RouteVersion
    {
        $result = new RouteVersion();

        if (isset($version['status']) && is_int($version['status'])) {
            $result->setStatus($version['status']);
        }

        if (isset($version['version']) && is_int($version['version'])) {
            $result->setVersion($version['version']);
        }

        if (isset($version['methods'])) {
            if ($version['methods'] instanceof RouteMethods) {
                $result->setMethods($version['methods']);
            } elseif (is_array($version['methods'])) {
                $result->setMethods($this->convertMethods($version['methods']));
            } elseif ($version['methods'] instanceof \stdClass) {
                $result->setMethods($this->convertMethods((array) $version['methods']));
            }
        }

        return $result;
    }

    private function convertMethods(array $methods): RouteMethods
    {
        $result = new RouteMethods();
        foreach ($methods as $methodName => $method) {
            if ($method instanceof RouteMethod) {
                $result[$methodName] = $method;
            } elseif (is_array($method)) {
                $result[$methodName] = $this->convertMethod($method);
            } elseif ($method instanceof \stdClass) {
                $result[$methodName] = $this->convertMethod((array) $method);
            }
        }

        return $result;
    }

    private function convertMethod(array $method): RouteMethod
    {
        $result = new RouteMethod();

        if (isset($method['version']) && is_int($method['version'])) {
            $result->setVersion($method['version']);
        }

        if (isset($method['status']) && is_int($method['status'])) {
            $result->setStatus($method['status']);
        }

        if (isset($method['active']) && is_bool($method['active'])) {
            $result->setActive($method['active']);
        }

        if (isset($method['public']) && is_bool($method['public'])) {
            $result->setPublic($method['public']);
        }

        if (isset($method['description']) && is_string($method['description'])) {
            $result->setDescription($method['description']);
        }

        if (isset($method['operationId']) && is_string($method['operationId'])) {
            $result->setOperationId($method['operationId']);
        }

        if (isset($method['parameters'])) {
            $result->setParameters((string) $method['parameters']);
        }

        if (isset($method['request'])) {
            $result->setRequest((string) $method['request']);
        }

        if (isset($method['responses'])) {
            if ($method['responses'] instanceof RouteMethodResponses) {
                $result->setResponses($method['responses']);
            } elseif (is_array($method['responses'])) {
                $result->setResponses($this->convertResponses($method['responses']));
            } elseif ($method['responses'] instanceof \stdClass) {
                $result->setResponses($this->convertResponses((array) $method['responses']));
            }
        }

        if (isset($method['action'])) {
            $result->setAction((string) $method['action']);
        }

        if (isset($method['costs']) && is_int($method['costs'])) {
            $result->setCosts($method['costs']);
        }

        return $result;
    }

    private function convertResponses(array $responses): RouteMethodResponses
    {
        $result = new RouteMethodResponses();

        foreach ($responses as $statusCode => $response) {
            $result[$statusCode] = (string) $response;
        }

        return $result;
    }
}
