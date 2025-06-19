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

namespace Fusio\Engine\Generator;

use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\ParametersInterface;

/**
 * Preconfigured route provider which helps to create automatically schemas, actions and routes for the user. This can
 * be used to create complete applications
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface ProviderInterface extends ConfigurableInterface
{
    /**
     * The provider needs to add the schemas, actions and routes to the setup using the provided configuration. The
     * system then automatically creates and validates all provided data. The base path is path which was chosen by the
     * user, all routes are automatically registered under the base path so there is no need to add it manually, it is
     * there to build schema and action names based on the base path
     */
    public function setup(SetupInterface $setup, ParametersInterface $configuration): void;
}
