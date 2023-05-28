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

namespace Fusio\Engine\Generator;

use Fusio\Model\Backend\ActionCreate;
use Fusio\Model\Backend\OperationCreate;
use Fusio\Model\Backend\SchemaCreate;

/**
 * Setup
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
