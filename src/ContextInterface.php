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

use Fusio\Engine\Model\ActionInterface as ModelActionInterface;

/**
 * The context contains all information about the incoming request which is not HTTP related i.e. it contains the
 * authenticated user and app or also the route id which was used
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
