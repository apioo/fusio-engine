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

namespace Fusio\Engine\Action\Resolver;

use Fusio\Engine\Action\ResolverInterface;
use Fusio\Engine\Exception\FactoryResolveException;
use Fusio\Engine\Model;
use Fusio\Engine\Repository;

/**
 * DatabaseAction
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class DatabaseAction implements ResolverInterface
{
    /**
     * @var Repository\ActionInterface[]
     */
    private array $stack;

    public function __construct(Repository\ActionInterface $repository)
    {
        $this->stack = [];
        $this->push($repository);
    }

    public function getScheme(): string
    {
        return 'action';
    }

    public function resolve(string $action): Model\ActionInterface
    {
        $model = $this->getCurrentRepository()->get($action);
        if (!$model instanceof Model\ActionInterface) {
            throw new FactoryResolveException('Could not resolve action ' . $action . ' from database');
        }

        return $model;
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
            throw new FactoryResolveException('One repository must be at least available');
        }

        array_pop($this->stack);
    }

    private function getCurrentRepository(): Repository\ActionInterface
    {
        return end($this->stack) ?: throw new FactoryResolveException('No repository available');
    }
}
