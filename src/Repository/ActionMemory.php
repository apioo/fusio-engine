<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace Fusio\Engine\Repository;

use Fusio\Engine\Model;

/**
 * ActionMemory
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ActionMemory implements ActionInterface
{
    /**
     * @var \Fusio\Engine\Model\ActionInterface[]
     */
    protected $actions;

    /**
     * @param array $actions
     */
    public function __construct(array $actions = array())
    {
        $this->actions = $actions;
    }

    /**
     * @param \Fusio\Engine\Model\ActionInterface $action
     */
    public function add(Model\ActionInterface $action)
    {
        $this->actions[$action->getId()] = $action;
    }

    /**
     * @return \Fusio\Engine\Model\ActionInterface[]
     */
    public function getAll()
    {
        return $this->actions;
    }

    /**
     * @param integer|string $actionId
     * @return \Fusio\Engine\Model\ActionInterface|null
     */
    public function get($actionId)
    {
        if (empty($this->actions)) {
            return null;
        }

        if (isset($this->actions[$actionId])) {
            return $this->actions[$actionId];
        }

        foreach ($this->actions as $action) {
            if ($action->getName() == $actionId) {
                return $action;
            }
        }

        return null;
    }
}
