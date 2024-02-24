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
 * Token
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Token implements TokenInterface
{
    private int $id;
    private int $appId;
    private int $userId;
    private array $scopes;
    private string $expire;
    private string $date;

    public function __construct(int $id, int $appId, int $userId, array $scopes, string $expire, string $date)
    {
        $this->id = $id;
        $this->appId = $appId;
        $this->userId = $userId;
        $this->scopes = $scopes;
        $this->expire = $expire;
        $this->date = $date;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAppId(): int
    {
        return $this->appId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function getExpire(): string
    {
        return $this->expire;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'appId' => $this->appId,
            'userId' => $this->userId,
            'scopes' => $this->scopes,
            'expire' => $this->expire,
            'date' => $this->date,
        ];
    }
}
