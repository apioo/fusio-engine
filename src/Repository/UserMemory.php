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
 * UserMemory
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class UserMemory implements UserInterface
{
    /**
     * @var \Fusio\Engine\Model\UserInterface[]
     */
    protected $users;

    /**
     * @param array $users
     */
    public function __construct(array $users = array())
    {
        $this->users = $users;
    }

    /**
     * @param \Fusio\Engine\Model\UserInterface $user
     */
    public function add(Model\UserInterface $user)
    {
        $this->users[$user->getId()] = $user;
    }

    /**
     * @return \Fusio\Engine\Model\UserInterface[]
     */
    public function getAll()
    {
        return $this->users;
    }

    /**
     * @param integer|string $userId
     * @return \Fusio\Engine\Model\UserInterface|null
     */
    public function get($userId)
    {
        if (empty($this->users)) {
            return null;
        }

        if (isset($this->users[$userId])) {
            return $this->users[$userId];
        }

        return null;
    }
}
