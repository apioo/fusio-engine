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

namespace Fusio\Engine\Tests\Request;

use Fusio\Engine\Request\RpcRequest;
use Fusio\Engine\RequestInterface;
use PHPUnit\Framework\TestCase;
use PSX\Record\Record;

/**
 * RpcRequestTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class RpcRequestTest extends TestCase
{
    public function testRequest()
    {
        $request = new RpcRequest('myAction', Record::fromArray(['foo' => 'bar']));

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals('bar', $request->get('foo'));
    }
}
