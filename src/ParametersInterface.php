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

use IteratorAggregate;

/**
 * The parameters represent a general set of key values which is used in various places. As argument to the action
 * method it contains the configuration parameters of the action. At the request object it contains the query and uri
 * fragment parameters
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 *
 * @template-extends IteratorAggregate<string, mixed>
 */
interface ParametersInterface extends IteratorAggregate
{
    /**
     * Returns a specific parameter
     */
    public function get(string $key): mixed;

    /**
     * Checks whether a parameter is available
     */
    public function has(string $key): bool;

    /**
     * Sets a specific parameter
     */
    public function set(string $key, mixed $value): void;

    /**
     * Returns whether no parameter is available
     */
    public function isEmpty(): bool;

    /**
     * Returns an array representation of this collection
     */
    public function toArray(): array;
}
