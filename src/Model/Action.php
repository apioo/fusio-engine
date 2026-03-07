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

use stdClass;

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
    private bool $async;
    /**
     * @var array<string, mixed>
     */
    private array $config;
    private ?stdClass $metadata;
    private ?string $hash;

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(int $id, string $name, string $class, bool $async, array $config, ?stdClass $metadata = null, ?string $hash = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->class = $class;
        $this->async = $async;
        $this->config = $config;
        $this->metadata = $metadata;
        $this->hash = $hash;
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

    public function isAsync(): bool
    {
        return $this->async;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getMetadata(string $key): mixed
    {
        return $this->metadata?->{$key};
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'class' => $this->class,
            'async' => $this->async,
            'config' => $this->config,
            'metadata' => $this->metadata,
            'hash' => $this->hash,
        ], fn(mixed $value) => $value !== null);
    }
}
