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
 * AppInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface AppInterface extends \JsonSerializable
{
    public const STATUS_ACTIVE      = 1;
    public const STATUS_PENDING     = 2;
    public const STATUS_DEACTIVATED = 3;

    public function isAnonymous(): bool;

    public function getId(): int;

    public function getUserId(): int;

    public function getStatus(): int;

    public function getName(): string;

    public function getUrl(): string;

    public function getAppKey(): string;

    public function getScopes(): array;

    public function hasScope(string $name): bool;

    public function getParameters(): array;

    public function getParameter(string $name): mixed;

    public function getMetadata(string $key): mixed;
}
