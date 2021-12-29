<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * Token
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
}
