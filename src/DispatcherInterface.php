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

namespace Fusio\Engine;

/**
 * The dispatcher can be used to trigger specific events. A consumer can
 * subscribe to such events and they will receive a HTTP POST call to the
 * defined endpoint in case you dispatch an event. The call happens in the
 * background through a cronjob so the dispatch operation is not expensive
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface DispatcherInterface
{
    /**
     * Dispatches a specific event and sends the payload to all subscribers. The payload gets json encoded so it is
     * recommended to use i.e. an array or stdClass data type
     */
    public function dispatch(string $eventName, mixed $payload): void;
}
