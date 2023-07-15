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

namespace Fusio\Engine\Tests;

use Fusio\Engine\Connector;
use Fusio\Engine\Exception\ConnectionNotFoundException;
use Fusio\Engine\Model\Connection;
use Fusio\Engine\Repository\ConnectionInterface;
use Fusio\Engine\Test\CallbackConnection;
use Fusio\Engine\Test\EngineTestCaseTrait;
use Fusio\Engine\Tests\Test\TestAdapter;
use PHPUnit\Framework\TestCase;

/**
 * ConnectorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ConnectorTest extends TestCase
{
    use EngineTestCaseTrait;

    public function testGetConnection()
    {
        $repository = $this->getRepository();
        $factory    = $this->getConnectionFactory();
        $connector  = new Connector($repository, $factory);

        $this->assertInstanceOf(\stdClass::class, $connector->getConnection(1));
    }

    public function testGetConnectionNamed()
    {
        $repository = $this->getRepository();
        $factory    = $this->getConnectionFactory();
        $connector  = new Connector($repository, $factory);

        $this->assertInstanceOf(\stdClass::class, $connector->getConnection('foo'));
    }

    public function testGetConnectionInvalid()
    {
        $this->expectException(ConnectionNotFoundException::class);

        $repository = $this->getConnectionRepository();
        $factory    = $this->getConnectionFactory();
        $connector  = new Connector($repository, $factory);

        $connector->getConnection(2);
    }

    protected function getRepository(): ConnectionInterface
    {
        $repository = $this->getConnectionRepository();

        $connection = new Connection(
            id: 1,
            name: 'foo',
            class: CallbackConnection::class,
            config: ['callback' => function(){
                return new \stdClass();
            }]
        );

        $repository->add($connection);

        return $repository;
    }

    protected function getAdapterClass(): string
    {
        return TestAdapter::class;
    }
}
