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

namespace Fusio\Engine\Tests\Http;

use Fusio\Engine\Http\Client;
use PSX\Http\Client as HttpClient;
use PSX\Http\RequestInterface;
use PSX\Http\Response;
use PSX\Http\Stream\StringStream;

/**
 * ClientTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $httpClient = $this->getMockBuilder(HttpClient::class)
            ->setMethods(['request'])
            ->getMock();
        $httpClient->expects($this->once())
            ->method('request')
            ->with($this->callback(function ($request) {
                /** @var \PSX\Http\RequestInterface $request */
                $this->assertInstanceOf(RequestInterface::class, $request);
                $this->assertSame('http://google.com', (string) $request->getUri());
                $this->assertSame('POST', $request->getMethod());
                $this->assertSame('application/json', $request->getHeader('Content-Type'));
                $this->assertJsonStringEqualsJsonString('{"foo":"bar"}', (string) $request->getBody());

                return true;
            }))
            ->will($this->returnValue(new Response(200, ['Content-Type' => 'application/json'], new StringStream(json_encode(['success' => true])))));

        $client   = new Client($httpClient);
        $response = $client->request('http://google.com', 'POST', ['Content-Type' => 'application/json'], json_encode(['foo' => 'bar']));

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(['content-type' => 'application/json'], $response->getHeaders());
        $this->assertSame('application/json', $response->getHeader('Content-Type'));
        $this->assertJsonStringEqualsJsonString('{"success":true}', $response->getBody());
    }
}
