<?php
/*
 * Fusio is an open source API management platform which helps to create innovative API solutions.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Factory;

use Fusio\Engine\ActionInterface as EngineActionInterface;
use Fusio\Engine\Exception\FactoryResolveException;
use Psr\Container\ContainerInterface;

/**
 * Action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
