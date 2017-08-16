<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine;

use PSX\Record\RecordInterface;

/**
 * RequestInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface RequestInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @param string $name
     * @return string
     */
    public function getHeader($name);

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @param string $name
     * @return string
     */
    public function getUriFragment($name);

    /**
     * @return \Fusio\Engine\Parameters
     */
    public function getUriFragments();

    /**
     * @param string $name
     * @return string
     */
    public function getParameter($name);

    /**
     * @return \Fusio\Engine\Parameters
     */
    public function getParameters();

    /**
     * @return \PSX\Record\RecordInterface
     */
    public function getBody();

    /**
     * @param \PSX\Record\RecordInterface $body
     */
    public function withBody(RecordInterface $body);
}
