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
 * SetupInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface SetupInterface
{
    /**
     * Adds a new schema
     * 
     * @param string $name
     * @param array $source
     * @return integer
     */
    public function addSchema($name, $source);

    /**
     * Adds a new action
     * 
     * @param string $name
     * @param string $class
     * @param string $engine
     * @param array $config
     * @return integer
     */
    public function addAction($name, $class, $engine, $config);

    /**
     * Adds a new route
     * 
     * @param integer $priority
     * @param string $path
     * @param string $controller
     * @param array $scopes
     * @param array $config
     * @return integer
     */
    public function addRoute($priority, $path, $controller, $scopes, $config);
}
