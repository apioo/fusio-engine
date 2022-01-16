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

namespace Fusio\Engine\Model;

/**
 * App
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
    private array $parameters;
    private array $scopes;

    public function __construct(bool $anonymous, int $id, int $userId, int $status, string $name, string $url, string $appKey, array $parameters, array $scopes)
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
}
