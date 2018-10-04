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

namespace Fusio\Engine\Model;

/**
 * TransactionInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface TransactionInterface
{
    const STATUS_CREATED  = 0;
    const STATUS_PENDING  = 1;
    const STATUS_APPROVED = 2;
    const STATUS_FAILED   = 3;
    const STATUS_UNKNOWN  = 4;

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getPlanId();

    /**
     * @param int $planId
     */
    public function setPlanId($planId);

    /**
     * @return int
     */
    public function getUserId();

    /**
     * @param int $userId
     */
    public function setUserId($userId);

    /**
     * @return int
     */
    public function getStatus();

    /**
     * @param int $status
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getProvider();

    /**
     * @param string $provider
     */
    public function setProvider($provider);

    /**
     * @return string
     */
    public function getTransactionId();

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId);

    /**
     * @return string
     */
    public function getRemoteId();

    /**
     * @param string $remoteId
     */
    public function setRemoteId($remoteId);

    /**
     * @return int
     */
    public function getAmount();

    /**
     * @param int $amount
     */
    public function setAmount($amount);

    /**
     * @return string
     */
    public function getReturnUrl();

    /**
     * @param string $returnUrl
     */
    public function setReturnUrl($returnUrl);

    /**
     * @return \DateTime
     */
    public function getUpdateDate();

    /**
     * @param \DateTime $updateDate
     */
    public function setUpdateDate(\DateTime $updateDate);

    /**
     * @return \DateTime
     */
    public function getCreateDate();

    /**
     * @param \DateTime $createDate
     */
    public function setCreateDate(\DateTime $createDate);
}
