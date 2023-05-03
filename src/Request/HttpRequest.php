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

use PSX\Http\Environment\HttpContextInterface;

/**
 * Request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class HttpRequest implements RequestContextInterface
{
    private HttpContextInterface $context;

    public function __construct(HttpContextInterface $context)
    {
        $this->context = $context;
    }

    public function getMethod(): string
    {
        return $this->context->getMethod();
    }

    public function getHeader(string $name): ?string
    {
        return $this->context->getHeader($name);
    }

    public function getHeaders(): array
    {
        return $this->context->getHeaders();
    }

    public function getUriFragment(string $name): ?string
    {
        return $this->context->getUriFragment($name);
    }

    public function getUriFragments(): array
    {
        return $this->context->getUriFragments();
    }

    public function getParameter(string $name): string|array|null
    {
        return $this->context->getParameter($name);
    }

    public function getParameters(): array
    {
        return $this->context->getParameters();
    }
}
