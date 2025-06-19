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

namespace Fusio\Engine\Repository;

use Fusio\Engine\Model;

/**
 * ActionMemory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
                'async'  => $action->isAsync(),
                'config' => $action->getConfig(),
            ];
        }

        return $result;
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        $repo = new self();

        if (is_array($data)) {
            foreach ($data as $row) {
                $repo->add(new Model\Action(
                    (int) $row['id'],
                    $row['name'],
                    $row['class'],
                    (bool) $row['async'],
                    $row['config']
                ));
            }
        }

        return $repo;
    }
}
