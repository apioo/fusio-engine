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

use Fusio\Engine\Model;

/**
 * Context
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
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
     * @inheritdoc
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * @inheritdoc
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @inheritdoc
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @inheritdoc
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @inheritdoc
     */
    public function withAction(Model\ActionInterface $action)
    {
        $me = clone $this;
        $me->action = $action;

        return $me;
    }

    /**
     * @inheritdoc
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @inheritdoc
     */
    public function withConnection($connection)
    {
        $me = clone $this;
        $me->connection = $connection;

        return $me;
    }
}
