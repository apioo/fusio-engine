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

namespace Fusio\Engine;

use Fusio\Engine\Exception\ConnectionNotFoundException;

/**
 * Through the connector it is possible to access configured connection objects. A connection is i.e. a MYSQL connection
 * which can be configured at the admin panel. Inside an action it is possible to access this connection through this
 * class. Which objects is returned depends on the connection type i.e. the MYSQL connection returns a Doctrine DBAL
 * Connection instance and the HTTP connection returns a Guzzle instance. There are already many adapters available
 * which allow many different kind of services i.e. ElasticSearch, MongoDB, AMQP, etc.
 * 
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface ConnectorInterface
{
    /**
     * Returns an arbitrary connection to a remote service. It is recommended to use the connection name but you can
     * also use the actual database id of the connection
     *
     * @throws ConnectionNotFoundException
     */
    public function getConnection(string|int $connectionId): mixed;
}
