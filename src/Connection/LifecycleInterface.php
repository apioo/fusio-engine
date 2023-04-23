<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * on the corresponding lifecycle event. This can be used to execute additional
 * logic on the connection. Note the methods are only called if a connection 
 * could be established to the remote service
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface LifecycleInterface
{
    /**
     * Is called if a connection gets created. The connection contains the object to interact with the remote service
     */
    public function onCreate(string $name, ParametersInterface $config, mixed $connection): void;

    /**
     * Is called if a connection gets updated. The connection contains the object to interact with the remote service
     */
    public function onUpdate(string $name, ParametersInterface $config, mixed $connection): void;

    /**
     * Is called if a connection gets deleted. The connection contains the object to interact with the remote service
     */
    public function onDelete(string $name, ParametersInterface $config, mixed $connection): void;
}
