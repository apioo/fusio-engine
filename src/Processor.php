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

use Fusio\Engine\Action\ResolverInterface;
use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Exception\FactoryResolveException;
use PSX\Http\Environment\HttpResponse;

/**
 * Processor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Processor implements ProcessorInterface
{
    private Factory\ActionInterface $factory;
    private Action\QueueInterface $queue;
    private Processor\ExecutionStackInterface $executionStack;

    /**
     * @var ResolverInterface[]
     */
    private array $resolvers = [];

    /**
     * @param iterable<ResolverInterface> $resolvers
     */
    public function __construct(iterable $resolvers, Factory\ActionInterface $factory, Action\QueueInterface $queue, ?Processor\ExecutionStackInterface $executionStack = null)
    {
        $this->factory = $factory;
        $this->queue = $queue;
        $this->executionStack = $executionStack ?? new Processor\ExecutionStack();

        foreach ($resolvers as $resolver) {
            $this->register($resolver->getScheme(), $resolver);
        }
    }

    public function execute(string|int $actionId, RequestInterface $request, ContextInterface $context, bool $allowAsync = true): mixed
    {
        $action = $this->getAction($actionId);
        $parameters = new Parameters($action->getConfig());

        if ($allowAsync && $action->isAsync()) {
            $this->queue->push($actionId, $request, $context);

            return new HttpResponse(202, [], [
                'success' => true,
                'message' => 'Request was queued for execution',
            ]);
        } else {
            $this->executionStack->push($actionId, $request, $context);

            try {
                $response = $this->factory->factory($action->getClass())->handle($request, $parameters, $context->withAction($action));
            } finally {
                $this->executionStack->pop();
            }

            return $response;
        }
    }

    public function register(string $scheme, ResolverInterface $resolver): void
    {
        $this->resolvers[$scheme] = $resolver;
    }

    public function getAction(string|int $actionId): Model\ActionInterface
    {
        if (is_int($actionId)) {
            $actionId = 'action://' . $actionId;
        } elseif (!str_contains($actionId, '://')) {
            $actionId = 'action://' . $actionId;
        }

        $pos = strpos($actionId, '://');
        if ($pos !== false) {
            $scheme = substr($actionId, 0, $pos);
            $value = substr($actionId, $pos + 3);
        } else {
            throw new ActionNotFoundException('Provided an invalid action ' . $actionId);
        }

        if (!isset($this->resolvers[$scheme])) {
            throw new FactoryResolveException('Provided scheme ' . $scheme . ' is not available');
        }

        return $this->resolvers[$scheme]->resolve($value);
    }
}
