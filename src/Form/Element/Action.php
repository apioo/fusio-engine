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

namespace Fusio\Engine\Form\Element;

use Fusio\Engine\Repository;

/**
 * Action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Action extends Select
{
    private Repository\ActionInterface $repository;

    /**
     * @var list<string>|null
     */
    private ?array $allowedClasses;

    /**
     * @param list<string>|null $allowedClasses
     */
    public function __construct(string $name, string $title, Repository\ActionInterface $repository, ?string $help = null, ?array $allowedClasses = null)
    {
        parent::__construct($name, $title, [], $help);

        $this->repository     = $repository;
        $this->allowedClasses = $allowedClasses;

        $this->load();
    }

    protected function load(): void
    {
        $result = $this->repository->getAll();

        foreach ($result as $row) {
            if ($this->allowedClasses === null || in_array($row->getClass(), $this->allowedClasses)) {
                $this->addOption((string) $row->getId(), $row->getName());
            }
        }
    }
}
