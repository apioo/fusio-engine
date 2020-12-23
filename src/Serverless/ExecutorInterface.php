<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Serverless;

use PSX\Http\ResponseInterface;

/**
 * The serverless executor is used inside a specific handler to invoke the
 * framework logic for a specific route. This means the method gets called i.e.
 * inside a lambda function
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface ExecutorInterface
{
    /**
     * @param int $routeId
     * @param string $method
     * @param string $path
     * @param array $uriFragments
     * @param array $headers
     * @param string|null $body
     * @return ResponseInterface
     */
    public function execute(int $routeId, string $method, string $path, array $uriFragments, array $headers, ?string $body = null): ResponseInterface;
}
