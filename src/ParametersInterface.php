<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine;

use IteratorAggregate;

/**
 * The parameters represent a general set of key values which is used in various
 * places. As argument to the action method it contains the configuration
 * parameters of the action. At the request object it contains the query and uri
 * fragment parameters
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ParametersInterface extends IteratorAggregate
{
    /**
     * Returns a specific parameter
     * 
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * Checks whether a parameter is available
     * 
     * @param string $key
     * @return boolean
     */
    public function has($key);

    /**
     * Sets a specific parameter
     * 
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Returns whether no parameter is available
     * 
     * @return boolean
     */
    public function isEmpty();

    /**
     * Returns an array representation of this collection
     * 
     * @return array
     */
    public function toArray();
}
