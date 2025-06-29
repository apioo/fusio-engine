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

namespace Fusio\Engine\Tests;

use Fusio\Engine\Request as EngineRequest;
use Fusio\Engine\Request\HttpRequestContext;
use Fusio\Engine\RequestInterface;
use PHPUnit\Framework\TestCase;
use PSX\Http\Request;
use PSX\Record\Record;
use PSX\Uri\Uri;

/**
 * RequestTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class RequestTest extends TestCase
{
    public function testRequest()
    {
        $context = new HttpRequestContext(new Request(Uri::parse('/'), 'GET'), []);
        $request = new EngineRequest(['foo' => 'bar'], Record::fromArray(['foo' => 'bar']), $context);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals('bar', $request->get('foo'));
        $this->assertEquals('bar', $request->getPayload()->get('foo'));
    }

    public function testRequestSerialize()
    {
        $context = new HttpRequestContext(new Request(Uri::parse('/my_endpoint?query=foo'), 'GET', ['User-Agent' => 'MyAgent'], 'my_body'), ['id' => 12]);
        $request = new EngineRequest(['foo' => 'bar'], Record::fromArray(['foo' => 'bar']), $context);

        $actual = \json_encode($request);
        $expect = file_get_contents(__DIR__ . '/resource/request.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual);
    }
}
