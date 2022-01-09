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

use Fusio\Engine\ConnectionInterface as EngineConnectionInterface;
use PSX\Dependency\AutowireResolverInterface;
use RuntimeException;

/**
 * Connection
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Connection implements ConnectionInterface
{
    private AutowireResolverInterface $autowireResolver;

    public function __construct(AutowireResolverInterface $autowireResolver)
    {
        $this->autowireResolver = $autowireResolver;
    }

    public function factory(string $className): EngineConnectionInterface
    {
        $connection = $this->autowireResolver->getObject($className);

        if (!$connection instanceof EngineConnectionInterface) {
            throw new RuntimeException('Connection ' . $className . ' must implement the Fusio\Engine\ConnectionInterface interface');
        }

        return $connection;
    }
}
