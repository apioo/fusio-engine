<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * tasks i.e. generate code or create a database
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface LifecycleInterface
{
    /**
     * Is called if a connection gets created. Note this method is called before
     * a connection is established to the remote service because of that the 
     * method is also called if the connection to the remote service fails. So 
     * it is recommended to implement it in an idempotent way that means that 
     * the side-effects of N > 0 method calls is the same as for a single call
     * 
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @return void
     */
    public function onSetup($name, ParametersInterface $config);

    /**
     * Is called every time a connection gets deleted. Note this method is 
     * called before a connection is established to the remote service because 
     * of that the method is also called if the connection to the remote service 
     * fails. So it is recommended to implement it in an idempotent way that 
     * means that the side-effects of N > 0 method calls is the same as for a 
     * single call
     * 
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @return void
     */
    public function onTeardown($name, ParametersInterface $config);

    /**
     * Is called if a connection gets created. The connection contains the 
     * object to interact with the remote service
     * 
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @param mixed $connection
     * @return void
     */
    public function onCreate($name, ParametersInterface $config, $connection);

    /**
     * Is called if a connection gets updated. The connection contains the
     * object to interact with the remote service
     * 
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @param mixed $connection
     * @return void
     */
    public function onUpdate($name, ParametersInterface $config, $connection);

    /**
     * Is called if a connection gets deleted. The connection contains the
     * object to interact with the remote service
     * 
     * @param string $name
     * @param \Fusio\Engine\ParametersInterface $config
     * @param mixed $connection
     * @return void
     */
    public function onDelete($name, ParametersInterface $config, $connection);
}
