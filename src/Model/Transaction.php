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
 * Transaction
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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

    public function __construct(int $id, int $invoiceId, int $status, string $provider, string $transactionId, ?string $remoteId, float $amount, string $returnUrl, ?\DateTimeInterface $updateDate, \DateTimeInterface $createDate)
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'invoiceId' => $this->invoiceId,
            'status' => $this->status,
            'provider' => $this->provider,
            'transactionId' => $this->transactionId,
            'remoteId' => $this->remoteId,
            'amount' => $this->amount,
            'returnUrl' => $this->returnUrl,
            'updateDate' => $this->updateDate?->format(\DateTimeInterface::RFC3339),
            'createDate' => $this->createDate->format(\DateTimeInterface::RFC3339),
        ];
    }
}
