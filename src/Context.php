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

namespace Fusio\Engine;

/**
 * Context
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Context implements ContextInterface
{
    private int $operationId;
    private string $baseUrl;
    private Model\AppInterface $app;
    private Model\UserInterface $user;
    private ?string $tenantId;
    private ?Model\ActionInterface $action = null;
    private mixed $connection;

    public function __construct(int $operationId, string $baseUrl, Model\AppInterface $app, Model\UserInterface $user, ?string $tenantId = null)
    {
        $this->operationId = $operationId;
        $this->baseUrl = $baseUrl;
        $this->app = $app;
        $this->user = $user;
        $this->tenantId = !empty($tenantId) ? $tenantId : null;
    }

    public function getOperationId(): int
    {
        return $this->operationId;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getApp(): Model\AppInterface
    {
        return $this->app;
    }

    public function getUser(): Model\UserInterface
    {
        return $this->user;
    }

    public function getTenantId(): ?string
    {
        return $this->tenantId;
    }

    public function getAction(): ?Model\ActionInterface
    {
        return $this->action;
    }

    public function withAction(Model\ActionInterface $action): self
    {
        $me = clone $this;
        $me->action = $action;

        return $me;
    }

    public function getConnection(): mixed
    {
        return $this->connection;
    }

    public function withConnection(mixed $connection): self
    {
        $me = clone $this;
        $me->connection = $connection;

        return $me;
    }
}
