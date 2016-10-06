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

/**
 * ResponseInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ResponseInterface
{
    /**
     * Returns the status code of the HTTP response
     * 
     * @see https://tools.ietf.org/html/rfc7231#section-6
     * @return integer
     */
    public function getStatusCode();

    /**
     * Returns all available headers of the response. The header keys are all 
     * lowercased
     * 
     * @return array
     */
    public function getHeaders();

    /**
     * Returns a single header based on the provided header name or null if the
     * header does not exist. The name is case insensitive
     * 
     * @param string $name
     * @return string|null
     */
    public function getHeader($name);

    /**
     * Returns the body of the response
     * 
     * @return mixed
     */
    public function getBody();
}
