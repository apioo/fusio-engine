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
 * App
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class App implements AppInterface
{
    private bool $anonymous;
    private int $id;
    private int $userId;
    private int $status;
    private string $name;
    private string $url;
    private string $appKey;
    /**
     * @var array<string, mixed>
     */
    private array $parameters;
    /**
     * @var list<string>
     */
    private array $scopes;
    private ?stdClass $metadata;

    /**
     * @param array<string, mixed> $parameters
     * @param list<string> $scopes
     */
    public function __construct(bool $anonymous, int $id, int $userId, int $status, string $name, string $url, string $appKey, array $parameters, array $scopes, ?stdClass $metadata = null)
    {
        $this->anonymous = $anonymous;
        $this->id = $id;
        $this->userId = $userId;
        $this->status = $status;
        $this->name = $name;
        $this->url = $url;
        $this->parameters = $parameters;
        $this->appKey = $appKey;
        $this->scopes = $scopes;
        $this->metadata = $metadata;
    }

    public function isAnonymous(): bool
    {
        return $this->anonymous;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getAppKey(): string
    {
        return $this->appKey;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function hasScope(string $name): bool
    {
        return in_array($name, $this->scopes);
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getParameter(string $name): mixed
    {
        return $this->parameters[$name] ?? null;
    }

    public function getMetadata(string $key): mixed
    {
        return $this->metadata?->{$key};
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'anonymous' => $this->anonymous,
            'id' => $this->id,
            'userId' => $this->userId,
            'status' => $this->status,
            'name' => $this->name,
            'url' => $this->url,
            'parameters' => $this->parameters,
            'appKey' => $this->appKey,
            'scopes' => $this->scopes,
            'metadata' => $this->metadata,
        ];
    }
}
