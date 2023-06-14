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
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
    public function webhook(RequestInterface $request, WebhookInterface $handler, ?string $webhookSecret = null, ?string $domain = null): void;

    /**
     * Returns an url which redirects the user to the payment provider portal where he can manage all subscriptions.
     * Can return null in case either the payment provider does not support such a portal or the user has no external
     * id assigned
     */
    public function portal(mixed $connection, UserInterface $user, string $returnUrl, ?string $configurationId = null): ?string;
}
