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
 * AppMemory
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class AppMemory implements AppInterface
{
    /**
     * @var \Fusio\Engine\Model\AppInterface[]
     */
    protected $apps;

    /**
     * @param array $apps
     */
    public function __construct(array $apps = array())
    {
        $this->apps = $apps;
    }

    /**
     * @param \Fusio\Engine\Model\AppInterface $action
     */
    public function add(Model\AppInterface $app)
    {
        $this->apps[$app->getId()] = $app;
    }

    /**
     * @return \Fusio\Engine\Model\ActionInterface[]
     */
    public function getAll()
    {
        return $this->apps;
    }

    /**
     * @param integer|string $actionId
     * @return \Fusio\Engine\Model\ActionInterface|null
     */
    public function get($appId)
    {
        if (empty($this->apps)) {
            return null;
        }

        if (isset($this->apps[$appId])) {
            return $this->apps[$appId];
        }

        return null;
    }
}
