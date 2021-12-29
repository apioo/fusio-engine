<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Form;

/**
 * Element
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
abstract class Element implements \JsonSerializable
{
    private string $name;
    private string $title;
    private ?string $help;

    public function __construct(string $name, string $title, ?string $help = null)
    {
        $this->name  = $name;
        $this->title = $title;
        $this->help  = $help;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setHelp(string $help): void
    {
        $this->help = $help;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function jsonSerialize(): array
    {
        return [
            'element' => $this->getNamespace(),
            'name' => $this->name,
            'title' => $this->title,
            'help' => $this->help,
        ];
    }

    abstract protected function getNamespace(): string;
}
