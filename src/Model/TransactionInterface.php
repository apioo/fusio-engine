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
 * TransactionInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface TransactionInterface
{
    public const STATUS_PREPARED = 0;
    public const STATUS_CREATED  = 1;
    public const STATUS_APPROVED = 2;
    public const STATUS_FAILED   = 3;
    public const STATUS_UNKNOWN  = 4;

    public function getId(): int;

    public function getInvoiceId(): int;

    public function getStatus(): int;

    public function getProvider(): string;

    public function getTransactionId(): string;

    public function getRemoteId(): ?string;

    public function getAmount(): float;

    public function getReturnUrl(): string;

    public function getUpdateDate(): ?\DateTimeInterface;

    public function getCreateDate(): \DateTimeInterface;
}
