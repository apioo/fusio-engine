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

namespace Fusio\Engine\Parser;

use Fusio\Engine\Factory\FactoryInterface;
use Fusio\Engine\Form;

/**
 * Composite
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Composite extends ParserAbstract
{
    private array $parsers;

    public function __construct(FactoryInterface $factory, Form\ElementFactoryInterface $elementFactory, array $parsers)
    {
        parent::__construct($factory, $elementFactory);

        $this->parsers = $parsers;
    }

    public function getClasses(): array
    {
        $classes = array();
        foreach ($this->parsers as $parser) {
            $classes = array_merge($classes, $parser->getClasses());
        }

        return $classes;
    }
}
