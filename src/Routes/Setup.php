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
    /**
     * @var array
     */
    private $schemas = [];

    /**
     * @var array 
     */
    private $actions = [];

    /**
     * @var array 
     */
    private $routes = [];

    /**
     * @var int 
     */
    private $schemaIndex = -1;

    /**
     * @var int 
     */
    private $actionIndex = -1;

    /**
     * @var int 
     */
    private $routesIndex = -1;

    /**
     * @inheritDoc
     */
    public function addSchema($name, $source)
    {
        $this->schemaIndex++;

        $this->schemas[$this->schemaIndex] = (object) [
            'name' => $name,
            'source' => (object) $source,
        ];

        return $this->schemaIndex;
    }

    /**
     * @inheritDoc
     */
    public function addAction($name, $class, $engine, $config)
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

    /**
     * @inheritDoc
     */
    public function addRoute($priority, $path, $controller, $scopes, $config)
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

    public function getSchemas()
    {
        return $this->schemas;
    }
    
    public function getActions()
    {
        return $this->actions;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}
