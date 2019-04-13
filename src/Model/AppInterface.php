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
 * AppInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface AppInterface
{
    const STATUS_ACTIVE      = 1;
    const STATUS_PENDING     = 2;
    const STATUS_DEACTIVATED = 3;

    /**
     * @return boolean
     */
    public function isAnonymous();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return integer
     */
    public function getUserId();

    /**
     * @return integer
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getAppKey();

    /**
     * @return array
     */
    public function getScopes();

    /**
     * @param string $name
     * @return boolean
     */
    public function hasScope($name);

    /**
     * @return array
     */
    public function getParameters();

    /**
     * @param string $name
     * @return string
     */
    public function getParameter($name);
}
