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
 * Request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Request implements RequestInterface
{
    private array $arguments;
    private mixed $payload;
    private RequestContextInterface $context;

    public function __construct(array $arguments, mixed $payload, RequestContextInterface $context)
    {
        $this->arguments = $arguments;
        $this->payload = $payload;
        $this->context = $context;
    }

    public function get(string $name): mixed
    {
        return $this->arguments[$name] ?? null;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function withArguments(array $arguments): self
    {
        return new self($arguments, $this->payload, $this->context);
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }

    public function withPayload(mixed $payload): self
    {
        return new self($this->arguments, $payload, $this->context);
    }

    public function getContext(): RequestContextInterface
    {
        return $this->context;
    }

    public function withContext(RequestContextInterface $context): self
    {
        return new self($this->arguments, $this->payload, $context);
    }
}
