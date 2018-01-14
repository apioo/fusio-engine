<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Tests\Test;

use Fusio\Engine\Response;
use Fusio\Engine\ResponseInterface;
use Fusio\Engine\Test\CallbackAction;
use Fusio\Engine\Test\EngineTestCase;
use PSX\Data\Record\Transformer;

/**
 * CallbackActionTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class CallbackActionTest extends EngineTestCase
{
    public function testHandle()
    {
        $callback = function(Response\FactoryInterface $response){
            return $response->build(200, [], [
                'foo' => 'bar'
            ]);
        };

        $action   = $this->getActionFactory()->factory(CallbackAction::class);
        $response = $action->handle($this->getRequest(), $this->getParameters(['callback' => $callback]), $this->getContext());

        $actual = json_encode(Transformer::toStdClass($response->getBody()), JSON_PRETTY_PRINT);
        $expect = <<<JSON
{
    "foo": "bar"
}
JSON;

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
