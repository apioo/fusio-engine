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
 * User
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class User implements UserInterface
{
    private bool $anonymous;
    private int $id;
    private int $roleId;
    private int $categoryId;
    private int $status;
    private string $name;
    private string $email;
    private int $points;
    private ?string $externalId;
    private ?string $planId;

    public function __construct(bool $anonymous, int $id, int $roleId, int $categoryId, int $status, string $name, string $email, int $points, ?string $externalId = null, ?string $planId = null)
    {
        $this->anonymous = $anonymous;
        $this->id = $id;
        $this->roleId = $roleId;
        $this->categoryId = $categoryId;
        $this->status = $status;
        $this->name = $name;
        $this->email = $email;
        $this->points = $points;
        $this->externalId = $externalId;
        $this->planId = $planId;
    }

    public function isAnonymous(): bool
    {
        return $this->anonymous;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getPlanId(): ?string
    {
        return $this->planId;
    }
}
