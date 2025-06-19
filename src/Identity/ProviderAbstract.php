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

namespace Fusio\Engine\Identity;

use Fusio\Engine\Exception\ConfigurationException;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\NameBuilder;
use Fusio\Engine\ParametersInterface;
use PSX\Http\Client\ClientInterface;
use PSX\Http\Client\GetRequest;
use PSX\Http\Client\PostRequest;
use PSX\Http\Exception as StatusCode;
use PSX\Uri\Uri;
use PSX\Uri\Url;

/**
 * ProviderAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
abstract class ProviderAbstract implements ProviderInterface
{
    private const USER_AGENT = 'Fusio-Engine (https://www.fusio-project.org/)';

    private ClientInterface $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function setHttpClient(ClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function getRedirectUri(ParametersInterface $configuration, string $state, string $redirectUri): Uri
    {
        $authorizationUri = $configuration->get('authorization_uri');
        if (empty($authorizationUri)) {
            $authorizationUri = $this->getAuthorizationUri() ?? throw new ConfigurationException('Provided no default authorization uri');
        }

        $uri = Url::parse($authorizationUri);
        $uri = $uri->withParameters([
            'response_type' => 'code',
            'client_id' => $configuration->get('client_id'),
            'state' => $state,
            'redirect_uri' => $redirectUri,
        ]);

        return $uri;
    }

    public function requestUserInfo(ParametersInterface $configuration, string $code, string $redirectUri): ?UserInfo
    {
        $tokenUri = $configuration->get('token_uri');
        if (empty($tokenUri)) {
            $tokenUri = $this->getTokenUri() ?? throw new ConfigurationException('Provided no default token uri');
        }

        $userInfoUri = $configuration->get('user_info_uri');
        if (empty($userInfoUri)) {
            $userInfoUri = $this->getUserInfoUri() ?? throw new ConfigurationException('Provided no default user info uri');
        }

        $accessToken = $this->obtainAccessToken($tokenUri, $this->getAccessTokenParameters($configuration, $code, $redirectUri));
        $data = $this->obtainUserInfo($userInfoUri, $accessToken, $this->getUserInfoParameters($configuration));

        $id = $this->getProperty($data, $configuration->get('id_property'), $this->getIdProperty());
        $name = $this->getProperty($data, $configuration->get('name_property'), $this->getNameProperty());
        $email = $this->getProperty($data, $configuration->get('email_property'), $this->getEmailProperty());

        if (!empty($id) && !empty($name)) {
            return new UserInfo($id, $name, $email);
        } else {
            return null;
        }
    }

    public function getName(): string
    {
        return NameBuilder::fromClass(static::class);
    }

    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory): void
    {
        $builder->add($elementFactory->newInput('client_id', 'Client-ID', 'text', 'Client-ID'));
        $builder->add($elementFactory->newInput('client_secret', 'Client-Secret', 'text', 'Client-Secret'));
        $builder->add($elementFactory->newInput('authorization_uri', 'Authorization-Uri', 'text', 'Client-Secret'));
        $builder->add($elementFactory->newInput('token_uri', 'Token-Uri', 'text', 'Client-Secret'));
        $builder->add($elementFactory->newInput('user_info_uri', 'User-Info-Uri', 'text', 'Client-Secret'));
        $builder->add($elementFactory->newInput('id_property', 'ID-Property', 'text', 'Optional name of the id property from the user-info response'));
        $builder->add($elementFactory->newInput('name_property', 'Name-Property', 'text', 'Optional name of the name property from the user-info response'));
        $builder->add($elementFactory->newInput('email_property', 'Email-Property', 'text', 'Optional name of the email property from the user-info response'));
    }

    protected function getAuthorizationUri(): ?string
    {
        return null;
    }

    protected function getTokenUri(): ?string
    {
        return null;
    }

    protected function getUserInfoUri(): ?string
    {
        return null;
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }

    protected function getNameProperty(): string
    {
        return 'name';
    }

    protected function getEmailProperty(): string
    {
        return 'email';
    }

    protected function getAccessTokenParameters(ParametersInterface $configuration, string $code, string $redirectUri): array
    {
        return [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => $configuration->get('client_id'),
            'client_secret' => $configuration->get('client_secret'),
            'redirect_uri'  => $redirectUri,
        ];
    }

    protected function getUserInfoParameters(ParametersInterface $configuration): array
    {
        return [];
    }

    protected function obtainUserInfo(string $userInfoUrl, string $accessToken, ?array $parameters = null): \stdClass
    {
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'User-Agent'    => self::USER_AGENT
        ];

        $url = Url::parse($userInfoUrl);
        if (!empty($parameters)) {
            $url = $url->withParameters($parameters);
        }

        $response = $this->httpClient->request(new GetRequest($url, $headers));
        if ($response->getStatusCode() !== 200) {
            throw new StatusCode\BadRequestException('Could not request user info, the server returned an invalid HTTP code: ' . $response->getStatusCode());
        }

        $data = \json_decode((string) $response->getBody());
        if (!$data instanceof \stdClass) {
            throw new StatusCode\BadRequestException('Could not request user info, the server returned an invalid JSON payload');
        }

        return $data;
    }

    protected function obtainAccessToken(string $tokenUrl, array $params, Method $method = Method::POST): string
    {
        $data = $this->requestAccessToken($tokenUrl, $params, $method);
        return $this->parseAccessToken($data);
    }

    protected function requestAccessToken(string $tokenUrl, array $params, Method $method = Method::POST): array
    {
        $headers = [
            'Accept'     => 'application/json',
            'User-Agent' => self::USER_AGENT
        ];

        if ($method === Method::POST) {
            $request = new PostRequest(Url::parse($tokenUrl), $headers, $params);
        } else {
            $url = Url::parse($tokenUrl);
            $url = $url->withParameters($params);
            $request = new GetRequest($url, $headers);
        }

        $response = $this->httpClient->request($request);
        if ($response->getStatusCode() !== 200) {
            throw new StatusCode\BadRequestException('Could not request access token, the server returned a wrong HTTP code: ' . $response->getStatusCode());
        }

        $data = \json_decode((string) $response->getBody(), true);
        if (!is_array($data)) {
            throw new StatusCode\BadRequestException('Could not request access token, the server returned an invalid JSON payload');
        }

        return $data;
    }

    private function parseAccessToken(array $data): string
    {
        if (isset($data['access_token']) && is_string($data['access_token'])) {
            return $data['access_token'];
        } elseif (isset($data['error']) && is_string($data['error'])) {
            $this->assertError($data);
        }

        throw new StatusCode\BadRequestException('Could not obtain access token');
    }

    private function assertError(array $data): void
    {
        $error = $data['error'] ?? null;
        $errorDescription = $data['error_description'] ?? null;
        $errorUri = $data['error_uri'] ?? null;

        throw new StatusCode\BadRequestException('Could not obtain token: ' . implode(' - ', array_filter([$error, $errorDescription, $errorUri])));
    }

    private function getProperty(\stdClass $data, ?string $propertyName, string $fallbackPropertyName): mixed
    {
        if (empty($propertyName)) {
            return $data->{$fallbackPropertyName} ?? null;
        }

        return $data->{$propertyName} ?? ($data->{$fallbackPropertyName} ?? null);
    }
}
