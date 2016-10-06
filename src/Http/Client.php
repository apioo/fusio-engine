<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Http;

use Fusio\Engine\Response;
use PSX\Http\Client as HttpClientInterface;
use PSX\Http\Request;
use PSX\Uri\Uri;

/**
 * Client
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Client implements ClientInterface
{
    /**
     * @var \PSX\Http\ClientInterface
     */
    protected $httpClient;

    /**
     * @param \PSX\Http\ClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param string $body
     * @return \Fusio\Engine\ResponseInterface
     */
    public function request($url, $method, array $headers, $body)
    {
        $response = $this->httpClient->request(new Request(new Uri($url), $method, $headers, $body));

        return new Response(
            $response->getStatusCode(),
            $this->transformHeaders($response->getHeaders()),
            $response->getBody()->getContents()
        );
    }

    /**
     * @param array $headers
     * @return array
     */
    protected function transformHeaders(array $headers)
    {
        $result = [];
        foreach ($headers as $key => $line) {
            $result[$key] = implode(', ', $line);
        }
        return $result;
    }
}
