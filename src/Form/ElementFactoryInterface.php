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

namespace Fusio\Engine\Form;

/**
 * ElementFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
