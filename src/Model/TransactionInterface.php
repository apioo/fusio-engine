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
 * TransactionInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface TransactionInterface extends \JsonSerializable
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
