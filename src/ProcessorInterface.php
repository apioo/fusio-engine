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

namespace Fusio\Engine;

use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Exception\FactoryResolveException;

/**
 * The processor can be used to invoke another action. Normally an action should only contain simple logic but in some
 * cases you may want to invoke an existing action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface ProcessorInterface
{
    /**
     * Executes a specific action using the request and context and returns a response. It is recommended to use the
     * action name but you can also use the actual database id of the action
     *
     * @throws ActionNotFoundException
     * @throws FactoryResolveException
     */
    public function execute(string|int $actionId, RequestInterface $request, ContextInterface $context, bool $allowAsync = true): mixed;

    /**
     * Returns the action model assigned to the action id
     *
     * @throws ActionNotFoundException
     * @throws FactoryResolveException
     */
    public function getAction(string|int $actionId): Model\ActionInterface;
}
