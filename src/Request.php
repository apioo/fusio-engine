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

use Fusio\Engine\Request\RequestContextInterface;

/**
 * Request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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

    public function jsonSerialize(): array
    {
        return [
            'arguments' => $this->arguments,
            'payload' => $this->payload,
            'context' => $this->context,
        ];
    }
}
