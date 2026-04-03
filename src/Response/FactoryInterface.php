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

namespace Fusio\Engine\Response;

use Psr\Http\Message\ResponseInterface;
use PSX\Http\Environment\HttpResponseInterface;

/**
 * The response factory MUST be used to create a response for an action. It is a factory method which returns a specific
 * response object. Please always use this factory since this gives us the freedom to change the response implementation
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 *
 * @phpstan-type Headers array<string, string|list<string>>
 */
interface FactoryInterface
{
    /**
     * Builds a new response object
     *
     * @param Headers $headers
     */
    public function build(int $statusCode, array $headers, mixed $body): HttpResponseInterface;

    /**
     * Builds a response based on a PSR response
     */
    public function proxy(ResponseInterface $response): HttpResponseInterface;

    /**
     * Builds an ok (200) success response
     *
     * @param Headers $headers
     */
    public function ok(mixed $body, array $headers = []): HttpResponseInterface;

    /**
     * Builds a created (201) success response
     *
     * @param Headers $headers
     */
    public function created(mixed $body, array $headers = []): HttpResponseInterface;

    /**
     * Builds an accepted (202) success response
     *
     * @param Headers $headers
     */
    public function accepted(mixed $body, array $headers = []): HttpResponseInterface;

    /**
     * Builds a no content (204) success response
     *
     * @param Headers $headers
     */
    public function noContent(array $headers = []): HttpResponseInterface;

    /**
     * Builds a bad request (400) client error response
     *
     * @param Headers $headers
     */
    public function badRequest(string $message, array $headers = []): HttpResponseInterface;

    /**
     * Builds a forbidden (403) client error response
     *
     * @param Headers $headers
     */
    public function forbidden(string $message, array $headers = []): HttpResponseInterface;

    /**
     * Builds a not found (404) client error response
     *
     * @param Headers $headers
     */
    public function notFound(string $message, array $headers = []): HttpResponseInterface;

    /**
     * Builds a conflict (409) client error response
     *
     * @param Headers $headers
     */
    public function conflict(string $message, array $headers = []): HttpResponseInterface;

    /**
     * Builds a gone (410) client error response
     *
     * @param Headers $headers
     */
    public function gone(string $message, array $headers = []): HttpResponseInterface;

    /**
     * Builds an internal server error (500) server error response
     *
     * @param Headers $headers
     */
    public function internalServerError(string $message, array $headers = []): HttpResponseInterface;

    /**
     * Builds a not implemented (501) server error response
     *
     * @param Headers $headers
     */
    public function notImplemented(string $message, array $headers = []): HttpResponseInterface;
}
