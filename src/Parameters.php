<?php
/*
 * Fusio is an open source API management platform which helps to create innovative API solutions.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Fusio\Engine;

use ArrayIterator;

/**
 * Parameters
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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

    public function set(string $key, mixed $value): void
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
