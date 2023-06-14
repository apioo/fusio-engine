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
 * ElementFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
interface ElementFactoryInterface
{
    /**
     * Creates a select which contains all available actions
     */
    public function newAction(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): Element\Action;

    /**
     * Creates a select which contains all available connections
     */
    public function newConnection(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): Element\Connection;

    /**
     * Creates a new input field. The type must be a valid html input type
     *
     * @see http://www.w3.org/TR/html5/forms.html#attr-input-type
     */
    public function newInput(string $name, string $title, string $type = 'text', ?string $help = null): Element\Input;

    /**
     * Creates a new select
     */
    public function newSelect(string $name, string $title, array $options = [], ?string $help = null): Element\Select;

    /**
     * Creates a new textarea. The mode indicates the syntax highlighting
     */
    public function newTextArea(string $name, string $title, string $mode, ?string $help = null): Element\TextArea;

    /**
     * Creates a new checkbox input, this results in a JSON boolean type
     */
    public function newCheckbox(string $name, string $title, ?string $help = null): Element\Checkbox;

    /**
     * Creates a new collection of inputs of a specific type, this results in an JSON array in the config
     */
    public function newCollection(string $name, string $title, string $type = 'text', ?string $help = null): Element\Collection;

    /**
     * Creates a map of inputs of a specific type, this results in an JSON object in the config
     */
    public function newMap(string $name, string $title, string $type = 'text', ?string $help = null): Element\Map;

    /**
     * Creates a new type schema designer
     */
    public function newTypeSchema(string $name, string $title, ?string $help = null): Element\TypeSchema;
}
