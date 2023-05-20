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

namespace Fusio\Engine;

use Fusio\Engine\Request\RequestContextInterface;

/**
 * Represents an incoming request. This object can be used to access all values from an incoming request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface RequestInterface
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
