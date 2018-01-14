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

namespace Fusio\Engine\Action;

use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Response;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * ServiceAwareInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ServiceAwareInterface
{
    /**
     * @param \Fusio\Engine\ConnectorInterface $connector
     */
    public function setConnector(ConnectorInterface $connector);

    /**
     * @param \Fusio\Engine\Response\FactoryInterface $response
     */
    public function setResponse(Response\FactoryInterface $response);

    /**
     * @param \Fusio\Engine\ProcessorInterface $processor
     */
    public function setProcessor(ProcessorInterface $processor);

    /**
     * @param \Psr\Log\LoggerInterface
     */
    public function setLogger(LoggerInterface $logger);

    /**
     * @param \Psr\SimpleCache\CacheInterface $cache
     */
    public function setCache(CacheInterface $cache);
}
