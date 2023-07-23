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

use PSX\Http\Client\ClientInterface;
use PSX\Http\Client\GetRequest;
use PSX\Http\Client\PostRequest;
use PSX\Http\Exception as StatusCode;
use PSX\Json\Parser;
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

    public function getAuthorizationUri(): ?string
    {
        return null;
    }

    public function getTokenUri(): ?string
    {
        return null;
    }

    public function getUserInfoUri(): ?string
    {
        return null;
    }

    public function getIdProperty(): string
    {
        return 'id';
    }

    public function getNameProperty(): string
    {
        return 'name';
    }

    public function getEmailProperty(): string
    {
        return 'email';
    }

    public function getRedirectUri(Uri $uri): Uri
    {
        return $uri;
    }

    public function requestUserInfo(ConfigurationInterface $configuration, string $code, string $redirectUri): ?UserInfo
    {
        $accessToken = $this->obtainAccessToken($configuration->getTokenUri(), $this->getAccessTokenParameters($configuration, $code, $redirectUri));
        $data = $this->obtainUserInfo($configuration->getUserInfoUri(), $accessToken, $this->getUserInfoParameters($configuration));

        $id = $data->{$configuration->getIdProperty()} ?? null;
        $name = $data->{$configuration->getNameProperty()} ?? null;
        $email = $data->{$configuration->getEmailProperty()} ?? null;

        if (!empty($id) && !empty($name)) {
            return new UserInfo($id, $name, $email);
        } else {
            return null;
        }
    }

    protected function getAccessTokenParameters(ConfigurationInterface $configuration, string $code, string $redirectUri): array
    {
        return [
            'grant_type'   => 'authorization_code',
            'code'         => $code,
            'client_id'    => $configuration->getClientId(),
            'redirect_uri' => $redirectUri,
        ];
    }

    protected function getUserInfoParameters(ConfigurationInterface $configuration): array
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

        $data = Parser::decode((string) $response->getBody());
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

    protected function obtainIDToken(string $tokenUrl, array $params, Method $method = Method::POST): string
    {
        $data = $this->requestAccessToken($tokenUrl, $params, $method);
        return $this->parseIDToken($data);
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

        $data = Parser::decode((string) $response->getBody(), true);
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

    private function parseIDToken(array $data): string
    {
        if (isset($data['id_token']) && is_string($data['id_token'])) {
            return $data['id_token'];
        } elseif (isset($data['error']) && is_string($data['error'])) {
            $this->assertError($data);
        }

        throw new StatusCode\BadRequestException('Could not obtain id token');
    }

    private function assertError(array $data): void
    {
        $error = $data['error'] ?? null;
        $errorDescription = $data['error_description'] ?? null;
        $errorUri = $data['error_uri'] ?? null;

        throw new StatusCode\BadRequestException('Could not obtain token: ' . implode(' - ', array_filter([$error, $errorDescription, $errorUri])));
    }
}
