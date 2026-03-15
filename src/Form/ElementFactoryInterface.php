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

use Fusio\Model\Common\FormElementAction;
use Fusio\Model\Common\FormElementAgent;
use Fusio\Model\Common\FormElementCheckbox;
use Fusio\Model\Common\FormElementCollection;
use Fusio\Model\Common\FormElementConnection;
use Fusio\Model\Common\FormElementInput;
use Fusio\Model\Common\FormElementMap;
use Fusio\Model\Common\FormElementSelect;
use Fusio\Model\Common\FormElementTextArea;
use Fusio\Model\Common\FormElementTypeAPI;
use Fusio\Model\Common\FormElementTypeSchema;

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
     *
     * @param list<string> $allowedClasses
     */
    public function newAction(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): FormElementAction;

    /**
     * Creates a select which contains all available agents
     */
    public function newAgent(string $name, string $title, ?string $help = null): FormElementAgent;

    /**
     * Creates a new checkbox input, this results in a JSON boolean type
     */
    public function newCheckbox(string $name, string $title, ?string $help = null): FormElementCheckbox;

    /**
     * Creates a new collection of inputs of a specific type, this results in an JSON array in the config
     */
    public function newCollection(string $name, string $title, string $type = 'text', ?string $help = null): FormElementCollection;

    /**
     * Creates a select which contains all available connections
     *
     * @param list<string> $allowedClasses
     */
    public function newConnection(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): FormElementConnection;

    /**
     * Creates a new input field. The type must be a valid html input type
     *
     * @see http://www.w3.org/TR/html5/forms.html#attr-input-type
     */
    public function newInput(string $name, string $title, string $type = 'text', ?string $help = null): FormElementInput;

    /**
     * Creates a map of inputs of a specific type, this results in an JSON object in the config
     */
    public function newMap(string $name, string $title, string $type = 'text', ?string $help = null): FormElementMap;

    /**
     * Creates a new select
     *
     * @param array<string, mixed> $options
     */
    public function newSelect(string $name, string $title, array $options = [], ?string $help = null): FormElementSelect;

    /**
     * Creates a new textarea. The mode indicates the syntax highlighting
     */
    public function newTextArea(string $name, string $title, string $mode, ?string $help = null): FormElementTextArea;

    /**
     * Creates a new type api designer
     */
    public function newTypeAPI(string $name, string $title, ?string $help = null): FormElementTypeAPI;

    /**
     * Creates a new type schema designer
     */
    public function newTypeSchema(string $name, string $title, ?string $help = null): FormElementTypeSchema;
}
