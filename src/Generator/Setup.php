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

namespace Fusio\Engine\Generator;

use Fusio\Model\Backend\ActionCreate;
use Fusio\Model\Backend\OperationCreate;
use Fusio\Model\Backend\SchemaCreate;

/**
 * Setup
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Setup implements SetupInterface
{
    /**
     * @var SchemaCreate[]
     */
    private array $schemas = [];

    /**
     * @var ActionCreate[]
     */
    private array $actions = [];

    /**
     * @var OperationCreate[]
     */
    private array $operations = [];

    public function addSchema(SchemaCreate $schema): void
    {
        $this->schemas[] = $schema;
    }

    public function addAction(ActionCreate $action): void
    {
        $this->actions[] = $action;
    }

    public function addOperation(OperationCreate $operation): void
    {
        $this->operations[] = $operation;
    }

    /**
     * @return SchemaCreate[]
     */
    public function getSchemas(): array
    {
        return $this->schemas;
    }

    /**
     * @return ActionCreate[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return OperationCreate[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }
}
