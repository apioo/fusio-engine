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

/**
 * The dispatcher can be used to trigger specific events. A consumer can subscribe to such events and they will receive
 * a HTTP POST call to the defined endpoint in case you dispatch an event. The call happens in the background through a
 * cronjob so the dispatch operation is not expensive
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
