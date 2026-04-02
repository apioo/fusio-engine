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

namespace Fusio\Engine\Tests\Response;

use Fusio\Engine\Response\Factory;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PSX\Http\Writer\Stream;

/**
 * FactoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class FactoryTest extends TestCase
{
    public function testBuild(): void
    {
        $response = new Factory()->build(200, ['x-customer' => 'my_header'], ['foo' => 'bar']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testProxy(): void
    {
        $response = new Factory()->proxy(new Response(200, ['x-customer' => 'my_header'], 'foobar'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());

        $body = $response->getBody();
        $this->assertInstanceOf(Stream::class, $body);

        $response = new \PSX\Http\Response();
        $body->writeTo($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['content-type' => ['application/octet-stream']], $response->getHeaders());
        $this->assertEquals('foobar', $response->getBody());
    }

    public function testOk(): void
    {
        $response = new Factory()->ok(['foo' => 'bar']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testOkWithHeader(): void
    {
        $response = new Factory()->ok(['foo' => 'bar'], ['x-customer' => 'my_header']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testCreated(): void
    {
        $response = new Factory()->created(['foo' => 'bar']);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testCreatedWithHeader(): void
    {
        $response = new Factory()->created(['foo' => 'bar'], ['x-customer' => 'my_header']);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testAccepted(): void
    {
        $response = new Factory()->accepted(['foo' => 'bar']);

        $this->assertEquals(202, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testAcceptedWithHeader(): void
    {
        $response = new Factory()->accepted(['foo' => 'bar'], ['x-customer' => 'my_header']);

        $this->assertEquals(202, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['foo' => 'bar'], $response->getBody());
    }

    public function testNoContent(): void
    {
        $response = new Factory()->noContent();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(null, $response->getBody());
    }

    public function testNoContentWithHeader(): void
    {
        $response = new Factory()->noContent(['x-customer' => 'my_header']);

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(null, $response->getBody());
    }

    public function testBadRequest(): void
    {
        $response = new Factory()->badRequest('error message');

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testBadRequestWithHeader(): void
    {
        $response = new Factory()->badRequest('error message', ['x-customer' => 'my_header']);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testForbidden(): void
    {
        $response = new Factory()->forbidden('error message');

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testForbiddenWithHeader(): void
    {
        $response = new Factory()->forbidden('error message', ['x-customer' => 'my_header']);

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testNotFound(): void
    {
        $response = new Factory()->notFound('error message');

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testNotFoundWithHeader(): void
    {
        $response = new Factory()->notFound('error message', ['x-customer' => 'my_header']);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testConflict(): void
    {
        $response = new Factory()->conflict('error message');

        $this->assertEquals(409, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testConflictWithHeader(): void
    {
        $response = new Factory()->conflict('error message', ['x-customer' => 'my_header']);

        $this->assertEquals(409, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testGone(): void
    {
        $response = new Factory()->gone('error message');

        $this->assertEquals(410, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testGoneWithHeader(): void
    {
        $response = new Factory()->gone('error message', ['x-customer' => 'my_header']);

        $this->assertEquals(410, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testInternalServerError(): void
    {
        $response = new Factory()->internalServerError('error message');

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testInternalServerErrorWithHeader(): void
    {
        $response = new Factory()->internalServerError('error message', ['x-customer' => 'my_header']);

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testNotImplemented(): void
    {
        $response = new Factory()->notImplemented('error message');

        $this->assertEquals(501, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }

    public function testNotImplementedWithHeader(): void
    {
        $response = new Factory()->notImplemented('error message', ['x-customer' => 'my_header']);

        $this->assertEquals(501, $response->getStatusCode());
        $this->assertEquals(['x-customer' => 'my_header'], $response->getHeaders());
        $this->assertEquals(['success' => false, 'message' => 'error message'], $response->getBody());
    }
}
