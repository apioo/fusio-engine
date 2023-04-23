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

namespace Fusio\Engine\Form\Element;

use Fusio\Engine\Repository;

/**
 * Connection
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Connection extends Select
{
    private Repository\ConnectionInterface $repository;
    private ?array $allowedClasses;

    public function __construct(string $name, string $title, Repository\ConnectionInterface $repository, ?string $help = null, ?array $allowedClasses = null)
    {
        parent::__construct($name, $title, [], $help);

        $this->repository     = $repository;
        $this->allowedClasses = $allowedClasses;

        $this->load();
    }

    protected function load(): void
    {
        $result = $this->repository->getAll();

        foreach ($result as $row) {
            if ($this->allowedClasses === null || in_array($row->getClass(), $this->allowedClasses)) {
                $this->addOption((string) $row->getId(), $row->getName());
            }
        }
    }
}
