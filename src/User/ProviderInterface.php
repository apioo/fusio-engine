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

namespace Fusio\Engine\User;

/**
 * Describes a remote identity provider which can be used to authorize an user
 * through a remote system so that the developer dont need to create an account.
 * Usually this is done through OAuth2, which has the following flow:
 * 
 * - The App redirects the user to the authorization endpoint of the remote
 *   provider (i.e. Google)
 * - The user authenticates and returns via redirect to the App
 * - The App calls the API endpoint and provides the fitting data to Fusio
 * - If everything is ok Fusio will get additional information and create a new
 *   account
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ProviderInterface
{
    const PROVIDER_SYSTEM   = 0x1;
    const PROVIDER_FACEBOOK = 0x2;
    const PROVIDER_GOOGLE   = 0x3;
    const PROVIDER_GITHUB   = 0x4;

    /**
     * Returns an id to identify the provider. This identifier is used in the
     * user table
     *
     * @return integer
     */
    public function getId();

    /**
     * Requests user information of an remote provider
     *
     * @param string $code
     * @param string $clientId
     * @param string $redirectUri
     * @return \Fusio\Engine\Model\User
     */
    public function requestUser($code, $clientId, $redirectUri);
}
