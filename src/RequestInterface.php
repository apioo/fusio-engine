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

use PSX\Record\RecordInterface;

/**
 * RequestInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface RequestInterface
{
    /**
     * Returns the HTTP request method i.e. GET
     * 
     * @return string
     */
    public function getMethod();

    /**
     * Returns a specific header
     * 
     * @param string $name
     * @return string|null
     */
    public function getHeader($name);

    /**
     * Returns all available headers
     * 
     * @return array
     */
    public function getHeaders();

    /**
     * Returns a specific fragment from the uri
     * 
     * @param string $name
     * @return string
     */
    public function getUriFragment($name);

    /**
     * Returns all available uri fragments
     * 
     * @return \Fusio\Engine\Parameters
     */
    public function getUriFragments();

    /**
     * Returns a query parameter from the uri. Those are parsed by the parse_str
     * function so the value is either a string or an array in case the
     * parameter uses a "[]" notation
     * 
     * @param string $name
     * @return string|array
     */
    public function getParameter($name);

    /**
     * Returns all available query parameters
     * 
     * @return \Fusio\Engine\Parameters
     */
    public function getParameters();

    /**
     * Returns the parsed body
     * 
     * @return \PSX\Record\RecordInterface
     */
    public function getBody();

    /**
     * Returns a copy of the request object with the provided body
     * 
     * @param \PSX\Record\RecordInterface $body
     * @return self
     */
    public function withBody(RecordInterface $body);
}
