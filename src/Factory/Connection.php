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

use Fusio\Engine\ConnectionInterface as EngineConnectionInterface;
use Psr\Container\ContainerInterface;
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
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @var \PSX\Dependency\AutowireResolverInterface
     */
    private $autowireResolver;

    /**
     * @param \Psr\Container\ContainerInterface $container
     * @param \PSX\Dependency\AutowireResolverInterface $autowireResolver
     */
    public function __construct(ContainerInterface $container, AutowireResolverInterface $autowireResolver)
    {
        $this->container = $container;
        $this->autowireResolver = $autowireResolver;
    }

    /**
     * @inheritdoc
     */
    public function factory($className)
    {
        $connection = $this->autowireResolver->getObject($className);

        if (!$connection instanceof EngineConnectionInterface) {
            throw new RuntimeException('Connection ' . $className . ' must implement the Fusio\Engine\ConnectionInterface interface');
        }

        if ($connection instanceof ContainerAwareInterface) {
            $connection->setContainer($this->container);
        }

        return $connection;
    }
}
