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
 * AppInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface AppInterface
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
}
