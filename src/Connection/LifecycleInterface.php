<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * If a connection implements this interface those methods are called on create,
 * update and delete of an connection object. This can be used to execute 
 * additional tasks i.e. generate code or create a database
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface LifecycleInterface
{
    /**
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @param mixed $connection
     * @return void
     */
    public function onCreate($name, ParametersInterface $config, $connection);

    /**
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @param mixed $connection
     * @return void
     */
    public function onUpdate($name, ParametersInterface $config, $connection);

    /**
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @param mixed $connection
     * @return void
     */
    public function onDelete($name, ParametersInterface $config, $connection);
}
