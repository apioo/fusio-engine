<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * ProductInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface ProductInterface
{
    const INTERVAL_1MONTH = 1;
    const INTERVAL_3MONTH = 2;
    const INTERVAL_6MONTH = 3;
    const INTERVAL_12MONTH = 4;

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return float
     */
    public function getPrice();

    /**
     * @param float $price
     */
    public function setPrice($price);

    /**
     * @return integer
     */
    public function getPoints();

    /**
     * @param integer $points
     */
    public function setPoints($points);

    /**
     * @return integer
     */
    public function getInterval();

    /**
     * @param integer $interval
     */
    public function setInterval($interval);
}
