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

namespace Fusio\Engine\Model;

/**
 * Connection
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Connection implements ConnectionInterface
{
    private int $id;
    private string $name;
    private string $class;
    private array $config;
    private ?\stdClass $metadata;

    public function __construct(int $id, string $name, string $class, array $config, ?\stdClass $metadata = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->config = $config;
        $this->metadata = $metadata;
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

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getMetadata(string $key): mixed
    {
        return $this->metadata?->{$key} ?? null;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'class' => $this->class,
            'config' => $this->config,
            'metadata' => $this->metadata,
        ];
    }
}
