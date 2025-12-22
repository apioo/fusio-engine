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
 * AppMemory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class AppMemory implements AppInterface
{
    /**
     * @var Model\AppInterface[]
     */
    private array $apps;

    /**
     * @param Model\AppInterface[] $apps
     */
    public function __construct(array $apps = [])
    {
        $this->apps = $apps;
    }

    public function add(Model\AppInterface $app): void
    {
        $this->apps[$app->getId()] = $app;
    }

    /**
     * @return Model\AppInterface[]
     */
    public function getAll(): array
    {
        return $this->apps;
    }

    public function get(string|int $id): ?Model\AppInterface
    {
        if (empty($this->apps)) {
            return null;
        }

        if (isset($this->apps[$id])) {
            return $this->apps[$id];
        }

        return null;
    }
}
