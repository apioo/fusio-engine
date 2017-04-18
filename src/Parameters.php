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

namespace Fusio\Engine;

use ArrayIterator;

/**
 * Parameters
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Parameters implements ParametersInterface
{
    /**
     * @var array
     */
    protected $container;

    /**
     * @param array $container
     */
    public function __construct(array $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $key
     * @return string
     */
    public function get($key)
    {
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return isset($this->container[$key]);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->container);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->container);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->container;
    }
}
