<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015 Christoph Kappestein <k42b3.x@gmail.com>
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

use Fusio\Engine\Model\ActionInterface as ModelActionInterface;

/**
 * ContextInterface
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ContextInterface
{
    /**
     * Returns the id of the route
     *
     * @return integer
     */
    public function getRouteId();

    /**
     * Returns the app which was used for this request. Can also be an anonymous
     * app if authorization is not required for the endpoint
     *
     * @return \Fusio\Engine\Model\AppInterface
     */
    public function getApp();

    /**
     * Returns the current action
     *
     * @return \Fusio\Engine\Model\ActionInterface
     */
    public function getAction();

    /**
     * Creates a new context containing the given action
     *
     * @param \Fusio\Engine\Model\ActionInterface $action
     * @return \Fusio\Engine\ContextInterface
     */
    public function withAction(ModelActionInterface $action);

    /**
     * Returns the connection which is currently used by the action
     *
     * @return mixed
     */
    public function getConnection();

    /**
     * Sets the currently used connection
     *
     * @param mixed $connection
     * @return \Fusio\Engine\ContextInterface
     */
    public function withConnection($connection);
}
