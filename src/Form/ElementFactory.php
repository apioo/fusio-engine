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

namespace Fusio\Engine\Form;

use Fusio\Engine\Repository;

/**
 * ElementFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ElementFactory implements ElementFactoryInterface
{
    private Repository\ActionInterface $actionRepository;
    private Repository\ConnectionInterface $connectionRepository;

    public function __construct(Repository\ActionInterface $actionRepository, Repository\ConnectionInterface $connectionRepository)
    {
        $this->actionRepository     = $actionRepository;
        $this->connectionRepository = $connectionRepository;
    }

    public function newAction(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): Element\Action
    {
        return new Element\Action($name, $title, $this->actionRepository, $help, $allowedClasses);
    }

    public function newConnection(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): Element\Connection
    {
        return new Element\Connection($name, $title, $this->connectionRepository, $help, $allowedClasses);
    }

    public function newInput(string $name, string $title, string $type = 'text', ?string $help = null): Element\Input
    {
        return new Element\Input($name, $title, $type, $help);
    }

    public function newSelect(string $name, string $title, array $options = [], ?string $help = null): Element\Select
    {
        return new Element\Select($name, $title, $options, $help);
    }

    public function newTextArea(string $name, string $title, string $mode, ?string $help = null): Element\TextArea
    {
        return new Element\TextArea($name, $title, $mode, $help);
    }

    public function newCheckbox(string $name, string $title, ?string $help = null): Element\Checkbox
    {
        return new Element\Checkbox($name, $title, $help);
    }

    /**
     * @deprecated - use newCollection instead
     */
    public function newTag(string $name, string $title, ?string $help = null): Element\Collection
    {
        return $this->newCollection($name, $title, 'text', $help);
    }

    public function newCollection(string $name, string $title, string $type = 'text', ?string $help = null): Element\Collection
    {
        return new Element\Collection($name, $title, $type, $help);
    }

    public function newMap(string $name, string $title, string $type = 'text', ?string $help = null): Element\Map
    {
        return new Element\Map($name, $title, $type, $help);
    }

    public function newTypeSchema(string $name, string $title, ?string $help = null): Element\TypeSchema
    {
        return new Element\TypeSchema($name, $title, $help);
    }

    public function newTypeAPI(string $name, string $title, ?string $help = null): Element\TypeAPI
    {
        return new Element\TypeAPI($name, $title, $help);
    }
}
