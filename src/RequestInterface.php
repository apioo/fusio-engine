<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Fusio\Engine\Request\RequestContextInterface;

/**
 * Represents an incoming request. This object can be used to access all values from an incoming request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface RequestInterface extends \JsonSerializable
{
    /**
     * Returns a value from the request. The request contains all uri fragment and query parameter which are also
     * defined at the schema
     */
    public function get(string $name): mixed;

    /**
     * Returns all arguments
     */
    public function getArguments(): array;

    /**
     * Returns the complete request payload
     */
    public function getPayload(): mixed;

    /**
     * Returns information about the context of the request i.e. whether it was invoked by an HTTP request, RPC call or
     * maybe also through a message queue. In general the request gets invoked by an HTTP request but it is recommended
     * to not rely on those context information in your action
     */
    public function getContext(): RequestContextInterface;
}
