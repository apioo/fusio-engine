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

namespace Fusio\Engine;

use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Factory;
use Fusio\Engine\Repository;
use PSX\Http\Environment\HttpResponse;
use RuntimeException;

/**
 * Processor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Processor implements ProcessorInterface
{
    /**
     * @var Repository\ActionInterface[]
     */
    private array $stack;
    private Factory\ActionInterface $factory;
    private Action\QueueInterface $queue;

    public function __construct(Repository\ActionInterface $repository, Factory\ActionInterface $factory, Action\QueueInterface $queue)
    {
        $this->stack   = [];
        $this->factory = $factory;
        $this->queue   = $queue;

        $this->push($repository);
    }

    public function execute(string|int $actionId, RequestInterface $request, ContextInterface $context): mixed
    {
        $repository = $this->getCurrentRepository();
        if (!$repository instanceof Repository\ActionInterface) {
            throw new \RuntimeException('Repository not configured');
        }

        $action = $repository->get($actionId);
        if (!$action instanceof Model\ActionInterface) {
            throw new ActionNotFoundException('Could not found action ' . $actionId);
        }

        $parameters = new Parameters($action->getConfig());

        if ($action->isAsync()) {
            $this->queue->push($actionId, $request, $context);

            return new HttpResponse(202, [], [
                'success' => true,
                'message' => 'Request was queued for execution',
            ]);
        } else {
            return $this->factory->factory($action->getClass(), $action->getEngine())->handle($request, $parameters, $context->withAction($action));
        }
    }

    /**
     * Pushes another repository to the processor stack. Through this it is possible to provide another action source
     */
    public function push(Repository\ActionInterface $repository): void
    {
        $this->stack[] = $repository;
    }

    /**
     * Removes the processor from the top of the stack
     */
    public function pop(): void
    {
        if (count($this->stack) === 1) {
            throw new RuntimeException('One repository must be at least available');
        }

        array_pop($this->stack);
    }

    protected function getCurrentRepository(): ?Repository\ActionInterface
    {
        return end($this->stack) ?: null;
    }
}
