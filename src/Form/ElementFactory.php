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

use Fusio\Engine\Model\ClassModelInterface;
use Fusio\Engine\Model\ModelInterface;
use Fusio\Engine\Repository;
use Fusio\Model\Common\FormElement;
use Fusio\Model\Common\FormElementAction;
use Fusio\Model\Common\FormElementAgent;
use Fusio\Model\Common\FormElementCheckbox;
use Fusio\Model\Common\FormElementCollection;
use Fusio\Model\Common\FormElementConnection;
use Fusio\Model\Common\FormElementInput;
use Fusio\Model\Common\FormElementMap;
use Fusio\Model\Common\FormElementSelect;
use Fusio\Model\Common\FormElementSelectOption;
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
readonly class ElementFactory implements ElementFactoryInterface
{
    public function __construct(
        private Repository\ActionInterface $actionRepository,
        private Repository\AgentInterface $agentRepository,
        private Repository\ConnectionInterface $connectionRepository
    ) {
    }

    public function newAction(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): FormElementAction
    {
        $element = $this->newElement(new FormElementAction(), 'select', $name, $title, $help);
        $element->setOptions($this->newOptionsFromRepository($this->actionRepository, $allowedClasses));

        return $element;
    }

    public function newAgent(string $name, string $title, ?string $help = null): FormElementAgent
    {
        $element = $this->newElement(new FormElementAgent(), 'select', $name, $title, $help);
        $element->setOptions($this->newOptionsFromRepository($this->agentRepository));

        return $element;
    }

    public function newCheckbox(string $name, string $title, ?string $help = null): FormElementCheckbox
    {
        return $this->newElement(new FormElementCheckbox(), 'checkbox', $name, $title, $help);
    }

    public function newCollection(string $name, string $title, string $type = 'text', ?string $help = null): FormElementCollection
    {
        $element = $this->newElement(new FormElementCollection(), 'collection', $name, $title, $help);
        $element->setType($type);

        return $element;
    }

    public function newConnection(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): FormElementConnection
    {
        $element = $this->newElement(new FormElementConnection(), 'select', $name, $title, $help);
        $element->setOptions($this->newOptionsFromRepository($this->connectionRepository, $allowedClasses));

        return $element;
    }

    public function newInput(string $name, string $title, string $type = 'text', ?string $help = null): FormElementInput
    {
        $element = $this->newElement(new FormElementInput(), 'input', $name, $title, $help);
        $element->setType($type);

        return $element;
    }

    public function newMap(string $name, string $title, string $type = 'text', ?string $help = null): FormElementMap
    {
        $element = $this->newElement(new FormElementMap(), 'map', $name, $title, $help);
        $element->setType($type);

        return $element;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function newSelect(string $name, string $title, array $options = [], ?string $help = null): FormElementSelect
    {
        $element = $this->newElement(new FormElementSelect(), 'select', $name, $title, $help);
        $element->setOptions($this->newOptions($options));

        return $element;
    }

    public function newTextArea(string $name, string $title, string $mode, ?string $help = null): FormElementTextArea
    {
        $element = $this->newElement(new FormElementTextArea(), 'textarea', $name, $title, $help);
        $element->setMode($mode);

        return $element;
    }

    public function newTypeAPI(string $name, string $title, ?string $help = null): FormElementTypeAPI
    {
        return $this->newElement(new FormElementTypeAPI(), 'typeapi', $name, $title, $help);
    }

    public function newTypeSchema(string $name, string $title, ?string $help = null): FormElementTypeSchema
    {
        return $this->newElement(new FormElementTypeSchema(), 'typeschema', $name, $title, $help);
    }

    /**
     * @template T of FormElement
     * @param T $object
     * @return T
     */
    private function newElement(FormElement $object, string $element, string $name, string $title, ?string $help = null): FormElement
    {
        $object->setElement($element);
        $object->setName($name);
        $object->setTitle($title);
        $object->setHelp($help);

        return $object;
    }

    /**
     * @template T of ModelInterface
     * @param Repository\RepositoryInterface<T> $repository
     * @param list<string> $allowedClasses
     * @return list<FormElementSelectOption>
     */
    private function newOptionsFromRepository(Repository\RepositoryInterface $repository, ?array $allowedClasses = null): array
    {
        $options = [];
        $result = $repository->getAll();
        foreach ($result as $row) {
            if ($allowedClasses !== null && $row instanceof ClassModelInterface && !in_array($row->getClass(), $allowedClasses)) {
                continue;
            }

            $options[$row->getId()] = $row->getName();
        }

        return $this->newOptions($options);
    }

    /**
     * @param array<int|string, string> $values
     * @return list<FormElementSelectOption>
     */
    private function newOptions(array $values): array
    {
        $options = [];
        foreach ($values as $key => $value) {
            $option = new FormElementSelectOption();
            $option->setKey((string) $key);
            $option->setValue((string) $value);

            $options[] = $option;
        }

        return $options;
    }
}
