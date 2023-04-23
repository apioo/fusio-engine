<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Parser;

use Fusio\Engine\Factory\FactoryInterface;
use Fusio\Engine\Form;

/**
 * Composite
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
