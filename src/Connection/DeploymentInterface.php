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

namespace Fusio\Engine\Connection;

use Fusio\Engine\ParametersInterface;

/**
 * If a connection implements this interface, those callback methods are called if a connection gets created or is
 * removed. Those methods cannot work with the corresponding connection and it is guaranteed that they are called even
 * if the connection later on fails. It is recommended to implement it in an idempotent way that means that the
 * side effects of N > 0 method calls are the same as for a single call
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface DeploymentInterface
{
    /**
     * Is called on creation of a connection
     */
    public function onUp(string $name, ParametersInterface $config): void;

    /**
     * Is called on deletion of a connection
     */
    public function onDown(string $name, ParametersInterface $config): void;
}
