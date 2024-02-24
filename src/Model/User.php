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
 * User
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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

    public function jsonSerialize(): array
    {
        return [
            'anonymous' => $this->anonymous,
            'id' => $this->id,
            'roleId' => $this->roleId,
            'categoryId' => $this->categoryId,
            'status' => $this->status,
            'name' => $this->name,
            'email' => $this->email,
            'points' => $this->points,
            'externalId' => $this->externalId,
            'planId' => $this->planId,
        ];
    }
}
