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

namespace Fusio\Engine\Model;

/**
 * Action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Action implements ActionInterface
{
    private int $id;
    private string $name;
    private string $class;
    private string $engine;
    private bool $async;
    private array $config;

    public function __construct(int $id, string $name, string $class, string $engine, bool $async, array $config)
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->engine = $engine;
        $this->async = $async;
        $this->config = $config;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getEngine(): string
    {
        return $this->engine;
    }

    public function isAsync(): bool
    {
        return $this->async;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
