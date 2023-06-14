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

namespace Fusio\Engine\Payment;

/**
 * The webhook handler gets passed to the provider webhook method, the provider then calls the fitting methods on the
 * object to either activate or deactivate a payment
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface WebhookInterface
{
    /**
     * Method which needs to be called in case the checkout of a plan was successful. The customer and session id is
     * a remote id of the payment provider, the user and plan id are Fusio internal ids. Fusio then assigns the
     * customer id to the user
     */
    public function completed(int $userId, int $planId, string $customerId, int $amountTotal, string $sessionId): void;

    /**
     * Method which needs to be called in case a recurring payment was done. The customer and invoice id is an external
     * id of the payment provider
     */
    public function paid(string $customerId, int $amountPaid, string $invoiceId, \DateTimeImmutable $periodStart, \DateTimeImmutable $periodEnd): void;

    /**
     * Method which needs to be called in case a payment has failed
     */
    public function failed(string $customerId): void;
}
