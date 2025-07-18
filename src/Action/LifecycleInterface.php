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

namespace Fusio\Engine\Action;

use Fusio\Engine\ParametersInterface;

/**
 * If an action implements this interface those callback methods are called on the corresponding lifecycle event
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface LifecycleInterface
{
    /**
     * Is called if an action gets created
     */
    public function onCreate(string $name, ParametersInterface $config): void;

    /**
     * Is called if an action gets updated
     */
    public function onUpdate(string $name, ParametersInterface $config): void;

    /**
     * Is called if an action gets deleted
     */
    public function onDelete(string $name, ParametersInterface $config): void;
}
