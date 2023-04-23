<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Connection;

/**
 * If a connection implements this interface it is possible that you can obtain an access token through OAuth2.
 * This means that the user does not need to manually configure the access token instead the user can start the OAuth2
 * authorization code flow through the backend. In the end the system writes the obtained access token to the config
 * which you can then use in your connection. The system also automatically renews the obtained token before it expires
 * so that you dont need take care of this process.
 *
 * Connections which implement this interface must use the following standard keys at the configure method:
 * - client_id
 * - client_secret
 *
 * Those keys are needed so that we can automatically start the OAuth2 flow. Please extend from the
 * OAuth2ConnectionAbstract abstract class which already contains the required configuration
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface OAuth2Interface
{
    public const CONFIG_CLIENT_ID = 'client_id';
    public const CONFIG_CLIENT_SECRET = 'client_secret';
    public const CONFIG_ACCESS_TOKEN = 'access_token';
    public const CONFIG_EXPIRES_IN = 'expires_in';
    public const CONFIG_REFRESH_TOKEN = 'refresh_token';

    /**
     * Returns the authorization url for this connection. This must be a provider specific absolute url i.e.
     * https://github.com/login/oauth/authorize
     *
     * The url can contain also query parameters, the system will then add automatically the required OAuth2 parameters
     *
     * @return string
     */
    public function getAuthorizationUrl(): string;

    /**
     * Returns the token url for this connection. This must be a provider specific absolute url i.e.
     * https://github.com/login/oauth/access_token
     *
     * Then system then automatically uses the endpoint to obtain an access token, the access token will be then stored
     * at the connection config
     *
     * @return string
     */
    public function getTokenUrl(): string;
}
