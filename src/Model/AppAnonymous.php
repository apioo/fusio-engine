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
 * AppAnonymous
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class AppAnonymous implements AppInterface
{
    public function isAnonymous(): bool
    {
        return true;
    }

    public function getId(): int
    {
        return 0;
    }

    public function getUserId(): int
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

    public function getUrl(): string
    {
        return '';
    }

    public function getAppKey(): string
    {
        return '';
    }

    public function getScopes(): array
    {
        return [];
    }

    public function hasScope(string $name): bool
    {
        return false;
    }

    public function getParameters(): array
    {
        return [];
    }

    public function getParameter(string $name): mixed
    {
        return null;
    }

    public function getMetadata(string $key): mixed
    {
        return null;
    }

    public function jsonSerialize(): array
    {
        return [
            'anonymous' => true,
        ];
    }
}
