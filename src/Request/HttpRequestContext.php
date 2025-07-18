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

namespace Fusio\Engine\Request;

use Fusio\Engine\Inflection\ClassName;
use PSX\Http\RequestInterface;

/**
 * Indicates that an action was invoked by an HTTP request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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

    public function jsonSerialize(): array
    {
        return [
            'type' => ClassName::serialize(self::class),
            'uriFragments' => (object) $this->parameters,
            'method' => $this->request->getMethod(),
            'path' => $this->request->getUri()->getPath(),
            'queryParameters' => (object) $this->request->getUri()->getParameters(),
            'headers' => $this->getRequestHeaders(),
        ];
    }

    private function getRequestHeaders(): object
    {
        $headers = new \stdClass();
        foreach ($this->request->getHeaders() as $key => $values) {
            $headers->{$key} = implode(', ', $values);
        }

        return $headers;
    }
}
