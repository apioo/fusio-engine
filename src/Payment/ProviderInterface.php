<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use Fusio\Engine\Model\TransactionInterface;
use Fusio\Engine\ParametersInterface;

/**
 * Describes a payment provider which can be used to execute payments. Through
 * the developer app the user has the possibility to buy points which can be
 * used to call specific routes which cost points. To buy those points Fusio
 * uses these payment providers to execute a payment. Usually the flow is:
 * 
 * - App calls the API endpoint to prepare a specific product, it provides an
 *   plan and a return url. The call returns an approval url
 * - App redirects the user to the approval url. The user has to approve the
 *   payment at the payment provider
 * - User returns to the App, the url contains the id of the transaction so the
 *   app can call the API endpoint to get details about the transaction
 * - If everything is ok Fusio will credit the points to the user so that he can
 *   start calling specific endpoints
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ProviderInterface
{
    /**
     * Creates a transaction at the payment provider and updates the transaction
     * fields. The redirect urls contains the urls where the user should be
     * redirected after payment completion. The method returns an approval url
     * 
     * @param mixed $connection
     * @param \Fusio\Engine\Model\ProductInterface $product
     * @param \Fusio\Engine\Model\TransactionInterface $transaction
     * @param \Fusio\Engine\Payment\PrepareContext $context
     * @return string
     */
    public function prepare($connection, ProductInterface $product, TransactionInterface $transaction, PrepareContext $context);

    /**
     * Is called after the user has approved the transaction. The parameters
     * contains all query parameters from the callback call
     * 
     * @param mixed $connection
     * @param \Fusio\Engine\Model\ProductInterface $product
     * @param \Fusio\Engine\Model\TransactionInterface $transaction
     * @param \Fusio\Engine\ParametersInterface $parameters
     * @return void
     */
    public function execute($connection, ProductInterface $product, TransactionInterface $transaction, ParametersInterface $parameters);
}
