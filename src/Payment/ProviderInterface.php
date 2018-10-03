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
use PSX\Record\RecordInterface;

/**
 * Describes a payment provider which can be used to execute payments. Through
 * the developer app the user has the possibility to buy points which can be
 * used to call specific routes which cost points. To buy those points Fusio
 * these payment providers to execute the payment. Usually the flow is:
 * 
 * - App calls the API endpoint to prepare a product which returns an 
 *   redirect url
 * - App uses the url to redirect the user to the payment provider
 * - User returns to the App, the app calls the API endpoint to execute the
 *   transaction
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
     * Creates a transaction and returns it with the fitting parameter which can
     * i.e. include an approval url to authorize this transaction
     * 
     * @param mixed $connection
     * @param \Fusio\Engine\Model\ProductInterface $product
     * @param \Fusio\Engine\Payment\RedirectUrls $redirectUrls
     * @return \Fusio\Engine\Model\TransactionInterface
     */
    public function prepare($connection, ProductInterface $product, RedirectUrls $redirectUrls);

    /**
     * Is called after the user has approved the transaction. Checks whether the
     * transaction was successful and credits the points to the user
     * 
     * @param mixed $connection
     * @param \Fusio\Engine\Model\ProductInterface $product
     * @param \Fusio\Engine\Model\TransactionInterface $transaction
     * @param \PSX\Record\RecordInterface $parameters
     * @return \Fusio\Engine\Model\TransactionInterface
     */
    public function execute($connection, ProductInterface $product, TransactionInterface $transaction, RecordInterface $parameters);
}
