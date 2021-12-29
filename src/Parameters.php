<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * @link    https://www.fusio-project.org
 */
class Parameters implements ParametersInterface
{
    private array $container;

    public function __construct(array $container)
    {
        $this->container = $container;
    }

    public function get(string $key): mixed
    {
        return $this->container[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->container[$key]);
    }

    public function set(string $key, mixed $value)
    {
        $this->container[$key] = $value;
    }

    public function isEmpty(): bool
    {
        return empty($this->container);
    }

    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->container);
    }

    public function toArray(): array
    {
        return $this->container;
    }
}
