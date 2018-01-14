<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Fusio\Engine\Factory;
use RuntimeException;

/**
 * Processor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Processor implements ProcessorInterface
{
    /**
     * @var array
     */
    protected $stack;

    /**
     * @var \Fusio\Engine\Factory\ActionInterface
     */
    protected $factory;

    /**
     * @param \Fusio\Engine\Repository\ActionInterface $repository
     * @param \Fusio\Engine\Factory\ActionInterface $factory
     */
    public function __construct(Repository\ActionInterface $repository, Factory\ActionInterface $factory)
    {
        $this->stack   = [];
        $this->factory = $factory;

        $this->push($repository);
    }

    /**
     * @param integer $actionId
     * @param \Fusio\Engine\RequestInterface $request
     * @param \Fusio\Engine\ContextInterface $context
     * @return \Fusio\Engine\ResponseInterface
     */
    public function execute($actionId, RequestInterface $request, ContextInterface $context)
    {
        $repository = $this->getCurrentRepository();
        $action     = $repository->get($actionId);

        if ($action instanceof Model\ActionInterface) {
            $parameters = new Parameters($action->getConfig());

            return $this->factory->factory($action->getClass(), $action->getEngine())->handle($request, $parameters, $context->withAction($action));
        } else {
            throw new RuntimeException('Could not found action ' . $actionId);
        }
    }

    /**
     * Pushes another repository to the processor stack. Through this it is
     * possible to provide another action source
     *
     * @param \Fusio\Engine\Repository\ActionInterface
     */
    public function push(Repository\ActionInterface $repository)
    {
        array_push($this->stack, $repository);
    }

    /**
     * Removes the processor from the top of the stack
     */
    public function pop()
    {
        if (count($this->stack) === 1) {
            throw new RuntimeException('One repository must be at least available');
        }

        array_pop($this->stack);
    }

    /**
     * @return \Fusio\Engine\Repository\ActionInterface
     */
    protected function getCurrentRepository()
    {
        return end($this->stack);
    }
}
