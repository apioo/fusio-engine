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

namespace Fusio\Engine;

/**
 * Through the connector it is possible to access configured connection objects.
 * A connection is i.e. a MYSQL connection which can be configured at the admin
 * panel. Inside an action it is possible to access this connection through this
 * class. Which objects is returned depends on the connection type i.e. the
 * MYSQL connection returns a Doctrine DBAL Connection instance and the HTTP
 * connection returns a Guzzle instance. There are already many adapters
 * available which allow many different kind of services i.e. ElasticSearch,
 * MongoDB, AMQP, etc.
 * 
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface ConnectorInterface
{
    /**
     * Returns an arbitrary connection to a remote service. It is recommended to
     * use the connection name but you can also use the actual database id of
     * the connection
     *
     * @param string|integer $connectionId
     * @return mixed
     */
    public function getConnection($connectionId);
}
