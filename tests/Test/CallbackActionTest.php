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

namespace Fusio\Engine\Tests\Test;

use Fusio\Engine\Response\FactoryInterface;
use Fusio\Engine\Test\CallbackAction;
use Fusio\Engine\Test\EngineTestCase;
use PSX\Http\Environment\HttpResponseInterface;

/**
 * CallbackActionTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class CallbackActionTest extends EngineTestCase
{
    public function testHandle()
    {
        $callback = function(FactoryInterface $response){
            return $response->build(200, [], [
                'foo' => 'bar'
            ]);
        };

        $action   = $this->getActionFactory()->factory(CallbackAction::class);
        $response = $action->handle($this->getRequest(), $this->getParameters(['callback' => $callback]), $this->getContext());

        $actual = json_encode($response->getBody(), JSON_PRETTY_PRINT);
        $expect = <<<JSON
{
    "foo": "bar"
}
JSON;

        $this->assertInstanceOf(HttpResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([], $response->getHeaders());
        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    protected function getAdapterClass(): string
    {
        return TestAdapter::class;
    }
}
