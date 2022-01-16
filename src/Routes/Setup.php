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

namespace Fusio\Engine\Routes;

/**
 * Setup
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Setup implements SetupInterface
{
    private array $schemas = [];
    private array $actions = [];
    private array $routes = [];
    private int $schemaIndex = -1;
    private int $actionIndex = -1;
    private int $routesIndex = -1;

    public function addSchema(string $name, array $source): int
    {
        $this->schemaIndex++;

        $this->schemas[$this->schemaIndex] = (object) [
            'name' => $name,
            'source' => (object) $source,
        ];

        return $this->schemaIndex;
    }

    public function addAction(string $name, string $class, string $engine, array $config): int
    {
        $this->actionIndex++;

        $this->actions[$this->actionIndex] = (object) [
            'name' => $name,
            'class' => $class,
            'engine' => $engine,
            'config' => (object) $config,
        ];

        return $this->actionIndex;
    }

    public function addRoute(int $priority, string $path, string $controller, array $scopes, array $config): int
    {
        $this->routesIndex++;

        $this->routes[$this->routesIndex] = (object) [
            'priority' => $priority,
            'path' => $path,
            'controller' => $controller,
            'scopes' => $scopes,
            'config' => $config,
        ];

        return $this->routesIndex;
    }

    public function getSchemas(): array
    {
        return $this->schemas;
    }
    
    public function getActions(): array
    {
        return $this->actions;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
