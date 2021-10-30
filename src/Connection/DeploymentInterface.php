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

namespace Fusio\Engine\Connection;

use Fusio\Engine\ParametersInterface;

/**
 * If a connection implements this interface those callback methods are called
 * if a connection gets created or is removed. Those methods can not work with
 * the corresponding connection and it is guaranteed that they are called even
 * if the connection later on fails. It is recommended to implement it in an 
 * idempotent way that means that the side-effects of N > 0 method calls is the 
 * same as for a single call
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface DeploymentInterface
{
    /**
     * Is called on creation of a connection
     *
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @return void
     */
    public function onUp($name, ParametersInterface $config);

    /**
     * Is called on deletion of a connection
     *
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @return void
     */
    public function onDown($name, ParametersInterface $config);
}
