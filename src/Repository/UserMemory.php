<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class UserMemory implements UserInterface
{
    /**
     * @var Model\UserInterface[]
     */
    private array $users;

    public function __construct(array $users = array())
    {
        $this->users = $users;
    }

    public function add(Model\UserInterface $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    /**
     * @return Model\UserInterface[]
     */
    public function getAll(): array
    {
        return $this->users;
    }

    public function get(string|int $id): ?Model\UserInterface
    {
        if (empty($this->users)) {
            return null;
        }

        if (isset($this->users[$id])) {
            return $this->users[$id];
        }

        return null;
    }
}
