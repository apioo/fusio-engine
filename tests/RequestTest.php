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
 * @license http://www.gnu.org/licenses/agpl-3.0
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
}
