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

namespace Fusio\Engine\Factory;

use Fusio\Engine\ActionInterface as EngineActionInterface;
use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Exception\FactoryResolveException;

/**
 * ActionInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface ActionInterface extends FactoryInterface
{
    /**
     * Tries to create an action interface based on the provided class name. Note the class name can also be a string to
     * a php or javascript file which is the then resolved by the factory
     *
     * @throws FactoryResolveException
     * @throws ActionNotFoundException
     *
     * @template T of EngineActionInterface
     * @param class-string<T> $className
     * @return T
     */
    public function factory(string $className): EngineActionInterface;
}
