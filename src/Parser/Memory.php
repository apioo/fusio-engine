<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * Memory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Memory extends ParserAbstract
{
    /**
     * @var array
     */
    protected $classes;

    /**
     * @param \Fusio\Engine\Factory\FactoryInterface $factory
     * @param \Fusio\Engine\Form\ElementFactoryInterface $elementFactory
     * @param array $classes
     */
    public function __construct(FactoryInterface $factory, Form\ElementFactoryInterface $elementFactory, array $classes)
    {
        parent::__construct($factory, $elementFactory);

        $this->classes = $classes;
    }

    /**
     * @param string $class
     * @param string $name
     */
    public function addClass($class, $name)
    {
        $this->classes[$class] = $name;
    }

    /**
     * @return array
     */
    public function getClasses()
    {
        $result = [];
        foreach ($this->classes as $class => $name) {
            $result[] = array(
                'name'  => $name,
                'class' => $class,
            );
        }

        return $result;
    }
}
