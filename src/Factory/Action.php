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

use Fusio\Engine\Action\ServiceAwareInterface;
use Fusio\Engine\ActionInterface as EngineActionInterface;
use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\DispatcherInterface;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Response;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use PSX\Dependency\TypeResolverInterface;
use RuntimeException;

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
    private TypeResolverInterface $typeResolver;
    private array $resolvers;

    public function __construct(ContainerInterface $container, TypeResolverInterface $typeResolver)
    {
        $this->container    = $container;
        $this->typeResolver = $typeResolver;
        $this->resolvers    = [];
    }

    public function factory(string $className, ?string $engine = null): EngineActionInterface
    {
        if (!empty($engine) && isset($this->resolvers[$engine])) {
            $resolver = $this->resolvers[$engine];
        } else {
            $resolver = reset($this->resolvers);

            if (!$resolver instanceof ResolverInterface) {
                throw new RuntimeException('No resolver was configured');
            }
        }

        $action = $resolver->resolve($className);

        if ($action instanceof ServiceAwareInterface) {
            $action->setConnector($this->typeResolver->getServiceByType(ConnectorInterface::class));
            $action->setResponse($this->typeResolver->getServiceByType(Response\FactoryInterface::class));
            $action->setProcessor($this->typeResolver->getServiceByType(ProcessorInterface::class));
            $action->setDispatcher($this->typeResolver->getServiceByType(DispatcherInterface::class));
            $action->setLogger($this->typeResolver->getServiceByType(LoggerInterface::class));
            $action->setCache($this->typeResolver->getServiceByType(CacheInterface::class));
        }

        return $action;
    }

    public function addResolver(ResolverInterface $resolver): void
    {
        $this->resolvers[get_class($resolver)] = $resolver;
    }
}
