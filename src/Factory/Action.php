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

namespace Fusio\Engine\Factory;

use Fusio\Engine\ActionInterface as EngineActionInterface;
use Fusio\Engine\Exception\FactoryResolveException;
use Psr\Container\ContainerInterface;

/**
 * Action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Action implements ActionInterface
{
    private ContainerInterface $container;
    private array $resolvers;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->resolvers = [];
    }

    public function factory(string $className, ?string $engine = null): EngineActionInterface
    {
        if (!empty($engine) && isset($this->resolvers[$engine])) {
            $resolver = $this->resolvers[$engine];
        } else {
            $resolver = reset($this->resolvers);

            if (!$resolver instanceof ResolverInterface) {
                throw new FactoryResolveException('No resolver was configured');
            }
        }

        return $resolver->resolve($className);
    }

    public function addResolver(ResolverInterface $resolver): void
    {
        $this->resolvers[get_class($resolver)] = $resolver;
    }
}
