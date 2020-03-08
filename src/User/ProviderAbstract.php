<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\User;

use Fusio\Engine\Factory\ContainerAwareInterface;
use Psr\Container\ContainerInterface;

/**
 * ProviderAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
abstract class ProviderAbstract implements ProviderInterface, ContainerAwareInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \PSX\Http\Client\ClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $ua = 'Fusio-Consumer (http://www.fusio-project.org/)';

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param \Psr\Container\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->httpClient = $container->get('http_client');
        $this->secret     = $container->get('config_service')->getValue('provider_' . $this->name . '_secret');
    }

    /**
     * @inheritdoc
     */
    abstract public function requestUser($code, $clientId, $redirectUri);
}
