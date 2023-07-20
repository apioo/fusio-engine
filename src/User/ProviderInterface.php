<?php
/*
 * Fusio is an open source API management platform which helps to create innovative API solutions.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\User;

use PSX\Uri\Uri;

/**
 * Describes an identity provider (IdP) which can be used to authorize a user through a remote system so that the
 * developer don`t need to register an account. By default we use OAuth2 or OpenID connect to get such information but
 * you can adjust this for a specific provider
 * 
 * - The user gets redirected to the authorization endpoint of the remote provider (i.e. Google)
 * - The user authenticates and returns via redirect to Fusio
 * - Fusio calls the API endpoint and obtains the fitting user info object
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface ProviderInterface
{
    /**
     * Returns the default authorization uri if available, otherwise the user can also configure this url
     */
    public function getAuthorizationUri(): ?string;

    /**
     * Returns the default token uri if available, otherwise the user can also configure this url
     */
    public function getTokenUri(): ?string;

    /**
     * Returns the default user info uri if available, otherwise the user can also configure this url
     */
    public function getUserInfoUri(): ?string;

    /**
     * Provides a way to modify the redirect url, by default we use the default OAuth2 parameters, if the provider needs
     * other parameters you can implement this method
     */
    public function getRedirectUri(Uri $uri): Uri;

    /**
     * Requests user information of the remote provider and returns a user info object
     */
    public function requestUserInfo(ConfigurationInterface $configuration, string $code, string $redirectUri): ?UserInfo;
}
