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

namespace Fusio\Engine\Factory;

use Fusio\Engine\ActionInterface as EngineActionInterface;
use Fusio\Engine\Exception\FactoryResolveException;
use PSX\Dependency\Exception\AutowiredException;
use PSX\Dependency\Exception\NotFoundException;

/**
 * ActionInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface ActionInterface extends FactoryInterface
{
    /**
     * Tries to create an action interface based on the provided class name. Note the class name can also be a string to
     * a php or javascript file which is the then resolved by the factory
     *
     * @template T of EngineActionInterface
     * @psalm-param class-string<T> $className
     * @return T
     * @throws NotFoundException
     * @throws AutowiredException
     * @throws FactoryResolveException
     */
    public function factory(string $className, ?string $engine = null): EngineActionInterface;
}
