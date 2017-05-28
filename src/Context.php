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

namespace Fusio\Engine;

use Fusio\Engine\Model;

/**
 * Context
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Context implements ContextInterface
{
    /**
     * @var integer
     */
    protected $routeId;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var \Fusio\Engine\Model\AppInterface
     */
    protected $app;

    /**
     * @var \Fusio\Engine\Model\UserInterface
     */
    protected $user;

    /**
     * @var \Fusio\Engine\Model\ActionInterface|null
     */
    protected $action;

    /**
     * @var mixed
     */
    protected $connection;

    /**
     * @param integer $routeId
     * @param string $baseUrl
     * @param \Fusio\Engine\Model\AppInterface $app
     * @param \Fusio\Engine\Model\UserInterface $user
     */
    public function __construct($routeId, $baseUrl, Model\AppInterface $app, Model\UserInterface $user)
    {
        $this->routeId = $routeId;
        $this->baseUrl = $baseUrl;
        $this->app     = $app;
        $this->user    = $user;
    }

    /**
     * Returns the id of the route
     *
     * @return integer
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * Returns the base url of the system to generate i.e. HATEOAS links. The 
     * url has a trailing slash
     * 
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Returns the app which was used for this request. Can also be an anonymous
     * app if authorization is not required for the endpoint
     *
     * @return \Fusio\Engine\Model\AppInterface
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Returns the user which has authenticated through the app. Can also be an
     * anonymous user if authorization is not required for the endpoint
     *
     * @return \Fusio\Engine\Model\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns the current action
     *
     * @return \Fusio\Engine\Model\ActionInterface
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Creates a new context containing the given action
     *
     * @param \Fusio\Engine\Model\ActionInterface $action
     * @return \Fusio\Engine\ContextInterface
     */
    public function withAction(Model\ActionInterface $action)
    {
        $me = clone $this;
        $me->action = $action;

        return $me;
    }

    /**
     * Returns the connection which is currently used by the action
     *
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Creates a new context containing the given connection. This can be i.e.
     * a PDO or MongoDB connection
     *
     * @param mixed $connection
     * @return \Fusio\Engine\ContextInterface
     */
    public function withConnection($connection)
    {
        $me = clone $this;
        $me->connection = $connection;

        return $me;
    }
}
