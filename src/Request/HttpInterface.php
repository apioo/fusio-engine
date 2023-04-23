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

namespace Fusio\Engine\Request;

use Fusio\Engine\RequestInterface;
use PSX\Record\RecordInterface;

/**
 * HttpInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface HttpInterface extends RequestInterface
{
    /**
     * Returns the HTTP request method i.e. GET, POST
     */
    public function getMethod(): string;

    /**
     * Returns a specific header or return null in case the header is not available
     */
    public function getHeader(string $name): ?string;

    /**
     * Returns all available headers
     */
    public function getHeaders(): array;

    /**
     * Returns a specific fragment from the uri. To specify a fragment your route must contain a variable fragment i.e.
     * /foo/:bar, then it is possible to access the bar fragment through this method
     */
    public function getUriFragment(string $name): ?string;

    /**
     * Returns all available uri fragments
     */
    public function getUriFragments(): array;

    /**
     * Returns a query parameter from the uri. Those are parsed by the parse_str function so the value is either a
     * string or an array in case the parameter uses a "[]" notation
     */
    public function getParameter(string $name): mixed;

    /**
     * Returns all available query parameters
     */
    public function getParameters(): array;

    /**
     * Returns the parsed body. If the body arrives at the action it is already valid against the defined JSON schema
     * (if provided)
     */
    public function getBody(): RecordInterface;

    /**
     * Returns a copy of the request object with the provided body
     */
    public function withBody(RecordInterface $body): self;
}
