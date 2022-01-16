<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class ActionMemory implements ActionInterface, \JsonSerializable, \Countable
{
    /**
     * @var Model\ActionInterface[]
     */
    private array $actions;

    public function __construct(array $actions = array())
    {
        $this->actions = $actions;
    }

    public function add(Model\ActionInterface $action): void
    {
        $this->actions[$action->getId()] = $action;
    }

    public function getAll(): array
    {
        return $this->actions;
    }

    public function get(string|int $id): ?Model\ActionInterface
    {
        if (empty($this->actions)) {
            return null;
        }

        if (isset($this->actions[$id])) {
            return $this->actions[$id];
        }

        foreach ($this->actions as $action) {
            if ($action->getName() == $id) {
                return $action;
            }
        }

        return null;
    }

    public function count(): int
    {
        return count($this->actions);
    }

    public function jsonSerialize(): array
    {
        $result = [];
        foreach ($this->actions as $action) {
            $result[] = [
                'id'     => $action->getId(),
                'name'   => $action->getName(),
                'class'  => $action->getClass(),
                'engine' => $action->getEngine(),
                'async'  => $action->isAsync(),
                'config' => $action->getConfig(),
            ];
        }

        return $result;
    }

    public static function fromJson(string $json): static
    {
        $data = json_decode($json, true);
        $repo = new static();

        if (is_array($data)) {
            foreach ($data as $row) {
                $repo->add(new Model\Action(
                    (int) $row['id'],
                    $row['name'],
                    $row['class'],
                    $row['engine'],
                    (bool) $row['async'],
                    $row['config']
                ));
            }
        }

        return $repo;
    }
}
