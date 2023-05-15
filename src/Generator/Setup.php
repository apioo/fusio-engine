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

use Fusio\Model\Backend\Action;
use Fusio\Model\Backend\Operation;
use Fusio\Model\Backend\Schema;

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
     * @var Schema[]
     */
    private array $schemas = [];

    /**
     * @var Action[]
     */
    private array $actions = [];

    /**
     * @var Operation[]
     */
    private array $operations = [];

    private int $schemaIndex = -1;
    private int $actionIndex = -1;
    private int $operationIndex = -1;

    public function addSchema(Schema $schema): int
    {
        $this->schemaIndex++;
        $this->schemas[$this->schemaIndex] = $schema;

        return $this->schemaIndex;
    }

    public function addAction(Action $action): int
    {
        $this->actionIndex++;
        $this->actions[$this->actionIndex] = $action;

        return $this->actionIndex;
    }

    public function addOperation(Operation $operation): int
    {
        $this->operationIndex++;
        $this->operations[$this->operationIndex] = $operation;

        return $this->operationIndex;
    }

    /**
     * @return Schema[]
     */
    public function getSchemas(): array
    {
        return $this->schemas;
    }

    /**
     * @return Action[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return Operation[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }
}
