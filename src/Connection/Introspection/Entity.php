<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Connection\Introspection;

/**
 * Entity
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Entity implements \JsonSerializable
{
    private string $name;
    private array $headers;
    private array $rows;

    public function __construct(string $name, array $headers)
    {
        $this->name = $name;
        $this->headers = $headers;
        $this->rows = [];
    }

    public function addRow(Row $row): void
    {
        if (count($row) !== count($this->headers)) {
            throw new \InvalidArgumentException('Row must match the headers count');
        }

        $this->rows[] = $row;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'headers' => $this->headers,
            'rows' => $this->rows,
        ];
    }
}
