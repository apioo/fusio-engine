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

namespace Fusio\Engine\Form;

/**
 * Element
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
            'element' => $this->getElement(),
            'name' => $this->name,
            'title' => $this->title,
            'help' => $this->help,
        ];
    }

    abstract protected function getElement(): string;
}
