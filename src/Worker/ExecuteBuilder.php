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

namespace Fusio\Engine\Worker;

use Fusio\Engine\ContextInterface;
use Fusio\Engine\Inflection\ClassName;
use Fusio\Engine\Model\AppInterface;
use Fusio\Engine\Model\UserInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\Request\HttpRequestContext;
use Fusio\Engine\Request\RequestContextInterface;
use Fusio\Engine\RequestInterface;
use Fusio\Worker\Execute;
use Fusio\Worker\ExecuteConnection;
use Fusio\Worker\ExecuteContext;
use Fusio\Worker\ExecuteContextApp;
use Fusio\Worker\ExecuteContextUser;
use Fusio\Worker\ExecuteRequest;
use Fusio\Worker\ExecuteRequestContext;
use PSX\Record\Record;

/**
 * ExecuteBuilder
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ExecuteBuilder implements ExecuteBuilderInterface
{
    private Repository\ConnectionInterface $connectionRepository;

    public function __construct(Repository\ConnectionInterface $connectionRepository)
    {
        $this->connectionRepository = $connectionRepository;
    }

    public function build(RequestInterface $request, ContextInterface $context): Execute
    {
        $execute = new Execute();
        $execute->setConnections($this->getConnections());
        $execute->setRequest($this->getRequest($request));
        $execute->setContext($this->getContext($context));

        return $execute;
    }

    private function getConnections(): Record
    {
        /** @var Record<ExecuteConnection> $result */
        $result = new Record();

        $connections = $this->connectionRepository->getAll();
        foreach ($connections as $connection) {
            $con = new ExecuteConnection();
            $con->setType(ClassName::serialize($connection->getClass()));
            $con->setConfig(\base64_encode(\json_encode((object) $connection->getConfig())));

            $result->put($connection->getName(), $con);
        }

        return $result;
    }

    private function getRequest(RequestInterface $request): ExecuteRequest
    {
        $return = new ExecuteRequest();
        $return->setArguments(Record::fromArray($request->getArguments()));
        $return->setPayload($request->getPayload());
        $return->setContext($this->getRequestContext($request->getContext()));

        return $return;
    }

    private function getRequestContext(RequestContextInterface $requestContext): ExecuteRequestContext
    {
        $return = new ExecuteRequestContext();
        $return->setType(ClassName::serialize($requestContext::class));
        if ($requestContext instanceof HttpRequestContext) {
            $return->setUriFragments(Record::fromArray($requestContext->getParameters()));
            $return->setMethod($requestContext->getRequest()->getMethod());
            $return->setPath($requestContext->getRequest()->getUri()->getPath());
            $return->setQueryParameters(Record::fromArray($requestContext->getRequest()->getUri()->getParameters()));
            $return->setHeaders($this->getRequestHeaders($requestContext->getRequest()));
        }

        return $return;
    }

    private function getRequestHeaders(\PSX\Http\RequestInterface $request): Record
    {
        /** @var Record<string> $headers */
        $headers = new Record();
        foreach ($request->getHeaders() as $key => $values) {
            $headers->put($key, implode(', ', $values));
        }

        return $headers;
    }

    private function getContext(ContextInterface $context): ExecuteContext
    {
        $return = new ExecuteContext();
        $return->setOperationId($context->getOperationId());
        $return->setBaseUrl($context->getBaseUrl());
        $return->setTenantId($context->getTenantId());
        $return->setAction($context->getAction()?->getName());
        $return->setApp($this->getApp($context->getApp()));
        $return->setUser($this->getUser($context->getUser()));

        return $return;
    }

    private function getApp(AppInterface $app): ExecuteContextApp
    {
        $return = new ExecuteContextApp();
        $return->setAnonymous($app->isAnonymous());
        $return->setId($app->getId());
        $return->setName($app->getName());

        return $return;
    }

    private function getUser(UserInterface $user): ExecuteContextUser
    {
        $return = new ExecuteContextUser();
        $return->setAnonymous($user->isAnonymous());
        $return->setId($user->getId());
        $return->setPlanId($user->getPlanId());
        $return->setName($user->getName());
        $return->setEmail($user->getEmail());
        $return->setPoints($user->getPoints());

        return $return;
    }
}
