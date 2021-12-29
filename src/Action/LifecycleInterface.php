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

namespace Fusio\Engine\Action;

use Fusio\Engine\ParametersInterface;

/**
 * If an action implements this interface those callback methods are called on the corresponding lifecycle event
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface LifecycleInterface
{
    /**
     * Is called if an action gets created
     */
    public function onCreate(string $name, ParametersInterface $config): void;

    /**
     * Is called if an action gets updated
     */
    public function onUpdate(string $name, ParametersInterface $config): void;

    /**
     * Is called if an action gets deleted
     */
    public function onDelete(string $name, ParametersInterface $config): void;
}
