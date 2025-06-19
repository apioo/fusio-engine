<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Fusio\Engine\Connection;

use Fusio\Engine\Exception\ConfigurationException;
use Fusio\Engine\ParametersInterface;

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
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface OAuth2Interface
{
    public const CONFIG_CLIENT_ID = 'client_id';
    public const CONFIG_CLIENT_SECRET = 'client_secret';
    public const CONFIG_SCOPES = 'scopes';
    public const CONFIG_ACCESS_TOKEN = 'access_token';
    public const CONFIG_EXPIRES_IN = 'expires_in';
    public const CONFIG_REFRESH_TOKEN = 'refresh_token';

    /**
     * Returns the authorization url for this connection. This must be a provider specific absolute url i.e.
     * https://github.com/login/oauth/authorize
     */
    public function getAuthorizationUrl(ParametersInterface $config): string;

    /**
     * Returns the token url for this connection. This must be a provider specific absolute url i.e.
     * https://github.com/login/oauth/access_token
     *
     * Then system then automatically uses the endpoint to obtain an access token, the access token will be then stored
     * at the connection config
     */
    public function getTokenUrl(ParametersInterface $config): string;

    /**
     * Allows the connection to adjust the redirect parameters in case there are vendor specific requirements
     *
     * @throws ConfigurationException
     */
    public function getRedirectUriParameters(string $redirectUri, string $state, ParametersInterface $config): array;

    /**
     * Allows the connection to adjust the authorization code parameters in case there are vendor specific requirements
     *
     * @throws ConfigurationException
     */
    public function getAuthorizationCodeParameters(string $code, string $redirectUri, ParametersInterface $config): array;

    /**
     * Allows the connection to adjust the refresh token parameters in case there are vendor specific requirements
     *
     * @throws ConfigurationException
     */
    public function getRefreshTokenParameters(ParametersInterface $config): array;
}
