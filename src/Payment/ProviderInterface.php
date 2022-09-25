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

use Fusio\Engine\Model\ProductInterface;
use Fusio\Engine\Model\UserInterface;
use PSX\Http\RequestInterface;

/**
 * Describes a payment provider which can be used to execute payments. Through the developer app the user has the
 * possibility to purchase a specific plan the user is then assigned to this plans and all points of the plan are
 * assigned to the user. THose points can be used to call specific routes which cost points. The payment flow is:
 * 
 * - App calls the API endpoint to prepare a specific plan, it provides a plan and a return url. The call returns an
 *   approval url
 * - App redirects the user to the approval url. The user has to approve the payment at the payment provider
 * - User returns to the App
 * - The webhook endpoint receives an event if the payment was successful, then the points are credited to the user
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface ProviderInterface
{
    /**
     * Creates a transaction at the payment provider and updates the transaction fields. The redirect urls contains the
     * urls where the user should be redirected after payment completion. The method returns an approval url
     */
    public function checkout(mixed $connection, ProductInterface $product, UserInterface $user, CheckoutContext $context): string;

    /**
     * Method which gets called by the payment provider in case an invoice was i.e. payed. The provider needs to call
     * the fitting methods on the webhook handler
     */
    public function webhook(RequestInterface $request, WebhookInterface $handler, ?string $webhookSecret = null): void;

    /**
     * Returns an url which redirects the user to the payment provider portal where he can manage all subscriptions.
     * Can return null in case either the payment provider does not support such a portal or the user has no external
     * id assigned
     */
    public function portal(mixed $connection, UserInterface $user, string $returnUrl, ?string $configurationId = null): ?string;
}
