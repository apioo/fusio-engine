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

namespace Fusio\Engine\Connection;

use Fusio\Engine\Connection\Introspection\IntrospectorInterface;

/**
 * Each connection can implement this interface in case it is possible to obtain information about the schema of the
 * service. This is mostly useful for database like connections where we can obtain i.e. a list of tables and for each
 * table we can obtain a columns. This can be useful for users of Fusio so that they can get information about the
 * schema without the need to use a different tool
 *
 * This interface is deprecated since we have implemented a dedicated database view, in case we need a view for a
 * different connection like MongoDB or MQ we should also build a dedicated view.
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 * @deprecated
 */
interface IntrospectableInterface
{
    /**
     * Returns an introspector instance
     */
    public function getIntrospector(mixed $connection): IntrospectorInterface;
}
