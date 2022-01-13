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

use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Factory;
use Fusio\Engine\Repository;
use PSX\Http\Environment\HttpResponse;
use RuntimeException;

/**
 * Processor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
