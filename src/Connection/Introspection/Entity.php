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

namespace Fusio\Engine\Connection\Introspection;

/**
 * Entity
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 * @deprecated
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
