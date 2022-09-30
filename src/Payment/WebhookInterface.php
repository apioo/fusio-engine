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

namespace Fusio\Engine\Payment;

/**
 * The webhook handler gets passed to the provider webhook method, the provider then calls the fitting methods on the
 * object to either activate or deactivate a payment
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
    public function paid(string $customerId, int $amountPaid, string $invoiceId, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate): void;

    /**
     * Method which needs to be called in case a payment has failed
     */
    public function failed(string $customerId): void;
}
