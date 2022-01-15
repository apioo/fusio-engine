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
 * Transaction
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Transaction implements TransactionInterface
{
    private int $id;
    private int $invoiceId;
    private int $status;
    private string $provider;
    private string $transactionId;
    private ?string $remoteId;
    private float $amount;
    private string $returnUrl;
    private ?\DateTimeInterface $updateDate;
    private \DateTimeInterface $createDate;

    public function __construct(int $id, int $invoiceId, int $status, string $provider, string $transactionId, string $remoteId, float $amount, string $returnUrl, \DateTimeInterface $updateDate, \DateTimeInterface $createDate)
    {
        $this->id = $id;
        $this->invoiceId = $invoiceId;
        $this->status = $status;
        $this->provider = $provider;
        $this->transactionId = $transactionId;
        $this->remoteId = $remoteId;
        $this->amount = $amount;
        $this->returnUrl = $returnUrl;
        $this->updateDate = $updateDate;
        $this->createDate = $createDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getRemoteId(): ?string
    {
        return $this->remoteId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function getCreateDate(): \DateTimeInterface
    {
        return $this->createDate;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setRemoteId(string $remoteId): void
    {
        $this->remoteId = $remoteId;
    }
}
