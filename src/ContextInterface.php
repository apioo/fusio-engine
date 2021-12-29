<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * The context contains all information about the incoming request which is not
 * HTTP related i.e. it contains the authenticated user and app or also the
 * route id which was used
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface ContextInterface
{
    /**
     * Returns the id of the route
     */
    public function getRouteId(): int;

    /**
     * Returns the base url of the system to generate i.e. HATEOAS links. The url has a trailing slash
     */
    public function getBaseUrl(): string;

    /**
     * Returns the app which was used for this request. Can also be an anonymous app if authorization is not required
     * for the endpoint
     */
    public function getApp(): Model\AppInterface;

    /**
     * Returns the user which has authenticated through the app. Can also be an anonymous user if authorization is not
     * required for the endpoint
     */
    public function getUser(): Model\UserInterface;

    /**
     * Returns the current action
     */
    public function getAction(): ?Model\ActionInterface;

    /**
     * Creates a new context containing the given action
     */
    public function withAction(ModelActionInterface $action): self;

    /**
     * Returns the connection which is currently used by the action
     */
    public function getConnection(): mixed;

    /**
     * Sets the currently used connection
     */
    public function withConnection(mixed $connection): self;
}
