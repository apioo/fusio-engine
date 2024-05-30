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

namespace Fusio\Engine\Connection;

use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Exception\ConfigurationException;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;

/**
 * OAuth2ConnectionAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
abstract class OAuth2ConnectionAbstract implements ConnectionInterface, OAuth2Interface
{
    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory): void
    {
        $builder->add($elementFactory->newInput(OAuth2Interface::CONFIG_CLIENT_ID, 'Client-Id', 'text', 'The client id'));
        $builder->add($elementFactory->newInput(OAuth2Interface::CONFIG_CLIENT_SECRET, 'Client-Secret', 'text', 'The client secret'));
        $builder->add($elementFactory->newCollection(OAuth2Interface::CONFIG_SCOPES, 'Scopes', 'text', 'List of needed scopes, it is recommended to include only the needed scopes for your operation. You can find a current documentation of all available scopes at the documentation of the provider.'));
        $builder->add($elementFactory->newInput(OAuth2Interface::CONFIG_ACCESS_TOKEN, 'Access-Token', 'password', 'Optional an access token, note the system automatically sets this value if you authorize a connection'));
    }

    public function getRedirectUriParameters(string $redirectUri, string $state, ParametersInterface $config): array
    {
        $parameters = [
            'response_type' => 'code',
            'client_id' => $this->getClientId($config),
            'redirect_uri' => $redirectUri,
            'state' => $state,
        ];

        $scopes = $this->getScopes($config);
        if (count($scopes) > 0) {
            $parameters['scope'] = implode(' ', $scopes);
        }

        return $parameters;
    }

    public function getAuthorizationCodeParameters(string $code, string $redirectUri, ParametersInterface $config): array
    {
        return [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'client_id' => $this->getClientId($config),
            'client_secret' => $this->getClientSecret($config),
        ];
    }

    public function getRefreshTokenParameters(ParametersInterface $config): array
    {
        $parameters = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->getRefreshToken($config),
        ];

        $scopes = $this->getScopes($config);
        if (count($scopes) > 0) {
            $parameters['scope'] = implode(' ', $scopes);
        }

        return $parameters;
    }

    protected function getClientId(ParametersInterface $config): string
    {
        $clientId = $config->get(OAuth2Interface::CONFIG_CLIENT_ID);
        if (empty($clientId)) {
            throw new ConfigurationException('No client id was provided');
        }

        return $clientId;
    }

    protected function getClientSecret(ParametersInterface $config): string
    {
        $clientSecret = $config->get(OAuth2Interface::CONFIG_CLIENT_SECRET);
        if (empty($clientSecret)) {
            throw new ConfigurationException('No client secret was provided');
        }

        return $clientSecret;
    }

    protected function getScopes(ParametersInterface $config): array
    {
        $scopes = $config->get(OAuth2Interface::CONFIG_SCOPES);
        if (!is_array($scopes)) {
            return [];
        }

        return $scopes;
    }

    protected function getRefreshToken(ParametersInterface $config): string
    {
        $refreshToken = $config->get(OAuth2Interface::CONFIG_REFRESH_TOKEN);
        if (empty($refreshToken)) {
            throw new ConfigurationException('No refresh token is available');
        }

        return $refreshToken;
    }

    protected function getAccessToken(ParametersInterface $config): string
    {
        return $config->get(OAuth2Interface::CONFIG_ACCESS_TOKEN);
    }
}
