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

namespace Fusio\Engine\Form\Parser;

use Fusio\Engine\Form\Builder;
use Fusio\Engine\Form\Container;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Model\Common\FormElement;
use PSX\Json\Parser;
use stdClass;

/**
 * Json
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
readonly class Json
{
    public function __construct(private ElementFactoryInterface $elementFactory)
    {
    }

    public function parse(string $json): ?Container
    {
        $container = Parser::decode($json);
        if ($container instanceof stdClass) {
            $elements = $this->extractElements($container) ?? [];
        } elseif (is_array($container)) {
            $elements = $container;
        } else {
            return null;
        }

        $builder = new Builder();
        foreach ($elements as $rawElement) {
            if (!$rawElement instanceof stdClass) {
                continue;
            }

            $name = $rawElement->name ?? null;
            if (empty($name) || !is_string($name)) {
                continue;
            }

            $title = $rawElement->title ?? null;
            if (empty($title) || !is_string($title)) {
                continue;
            }

            $help = $rawElement->help ?? null;

            $object = match ($rawElement->element ?? null) {
                'action' => $this->elementFactory->newAction($name, $title, $help),
                'agent' => $this->elementFactory->newAgent($name, $title, $help),
                'checkbox' => $this->elementFactory->newCheckbox($name, $title, $help),
                'collection' => $this->elementFactory->newCollection($name, $title, $this->parseType($rawElement), $help),
                'connection' => $this->elementFactory->newConnection($name, $title, $help),
                'input' => $this->elementFactory->newInput($name, $title, $this->parseType($rawElement), $help),
                'map' => $this->elementFactory->newMap($name, $title, $this->parseType($rawElement), $help),
                'select' => $this->elementFactory->newSelect($name, $title, $this->parseOptions($rawElement), $help),
                'textarea' => $this->elementFactory->newTextArea($name, $title, $this->parseMode($rawElement), $help),
                'typeapi' => $this->elementFactory->newTypeAPI($name, $title, $help),
                'typeschema' => $this->elementFactory->newTypeSchema($name, $title, $help),
                default => null,
            };

            if ($object instanceof FormElement) {
                $builder->add($object);
            }
        }

        $form = $builder->getForm();
        if (count($form->getElements()) === 0) {
            return null;
        }

        return $form;
    }

    private function parseType(stdClass $rawElement): string
    {
        return $rawElement->type ?? 'text';
    }

    /**
     * @param stdClass $rawElement
     * @return array<string, scalar>
     */
    private function parseOptions(stdClass $rawElement): array
    {
        $options = [];

        $rawOptions = $rawElement->options ?? null;
        if (!is_array($rawOptions)) {
            return $options;
        }

        foreach ($rawOptions as $rawOption) {
            if (!$rawOption instanceof stdClass) {
                continue;
            }

            $key = $rawOption->key ?? null;
            if ($key === null || $key === '') {
                continue;
            }

            $value = $rawOption->value ?? null;
            if ($value === null || $value === '') {
                continue;
            }

            $options[$key] = $value;
        }

        return $options;
    }

    private function parseMode(stdClass $rawElement): string
    {
        return $rawElement->mode ?? 'json';
    }

    /**
     * @return array<mixed>|null
     */
    private function extractElements(stdClass $container): ?array
    {
        $keywords = ['form', 'element', 'elements'];
        foreach ($keywords as $keyword) {
            if (isset($container->$keyword) && is_array($container->$keyword)) {
                return $container->$keyword;
            }
        }

        return null;
    }
}
