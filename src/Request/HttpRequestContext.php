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

use PSX\Http\RequestInterface;

/**
 * Request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class HttpRequestContext implements RequestContextInterface
{
    private RequestInterface $request;
    private array $parameters;

    public function __construct(RequestInterface $request, array $parameters)
    {
        $this->request = $request;
        $this->parameters = $parameters;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getParameter(string $name): ?string
    {
        return $this->parameters[$name] ?? null;
    }
}
