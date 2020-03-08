<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Fusio\Engine\Connector;
use Fusio\Engine\Model\Connection;
use Fusio\Engine\Test\CallbackConnection;
use Fusio\Engine\Test\EngineTestCaseTrait;
use PHPUnit\Framework\TestCase;

/**
 * ConnectorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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

    /**
     * @expectedException \Fusio\Engine\Exception\ConnectionNotFoundException
     */
    public function testGetConnectionInvalid()
    {
        $repository = $this->getConnectionRepository();
        $factory    = $this->getConnectionFactory();
        $connector  = new Connector($repository, $factory);

        $connector->getConnection(2);
    }

    protected function getRepository()
    {
        $repository = $this->getConnectionRepository();

        $connection = new Connection();
        $connection->setId(1);
        $connection->setName('foo');
        $connection->setClass(CallbackConnection::class);
        $connection->setConfig(['callback' => function(){
            return new \stdClass();
        }]);

        $repository->add($connection);

        return $repository;
    }
}
