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
 * UserAnonymous
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class UserAnonymous implements UserInterface
{
    public function isAnonymous(): bool
    {
        return true;
    }

    public function getId(): int
    {
        return 0;
    }

    public function getRoleId(): int
    {
        return 0;
    }

    public function getCategoryId(): int
    {
        return 0;
    }

    public function getStatus(): int
    {
        return 0;
    }

    public function getName(): string
    {
        return '';
    }

    public function getEmail(): string
    {
        return '';
    }

    public function getPoints(): int
    {
        return 0;
    }

    public function getExternalId(): ?string
    {
        return null;
    }

    public function getPlanId(): ?string
    {
        return null;
    }

    public function getMetadata(string $key): mixed
    {
        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'anonymous' => true,
        ];
    }
}
