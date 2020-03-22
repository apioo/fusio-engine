<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Psr\Container\ContainerInterface;

/**
 * If an action or connection implements this method the factory will inject the
 * used DI container. Note usually this is bad practice since your action/
 * connection accesses hard coded service keys which might be not available in
 * a different environment
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 * @deprecated - please use autowiring and constructor injection
 */
interface ContainerAwareInterface
{
    /**
     * @param \Psr\Container\ContainerInterface $container
     * @deprecated - please use autowiring and constructor injection
     */
    public function setContainer(ContainerInterface $container);
}
