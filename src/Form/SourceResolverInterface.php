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

namespace Fusio\Engine\Form;

use Fusio\Engine\ParametersInterface;

/**
 * SourceResolverInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface SourceResolverInterface
{
    /**
     * In case you action can resolve a configuration form through the configuration i.e. through attributes at the code
     * you can implement this interface. In this case the user of the action gets the resolved form instead of the form
     * from the action class. This can be especially useful to build reusable actions which can be shared across the
     * marketplace
     */
    public function resolveFormSource(ParametersInterface $configuration): ?SourceInterface;
}
