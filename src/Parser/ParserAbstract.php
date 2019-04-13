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

use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\Factory\FactoryInterface;
use Fusio\Engine\Form;

/**
 * ParserAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
abstract class ParserAbstract implements ParserInterface
{
    /**
     * @var \Fusio\Engine\Factory\FactoryInterface
     */
    protected $factory;

    /**
     * @var \Fusio\Engine\Form\ElementFactoryInterface
     */
    protected $elementFactory;

    /**
     * @param \Fusio\Engine\Factory\FactoryInterface $factory
     * @param \Fusio\Engine\Form\ElementFactoryInterface $elementFactory
     */
    public function __construct(FactoryInterface $factory, Form\ElementFactoryInterface $elementFactory)
    {
        $this->factory        = $factory;
        $this->elementFactory = $elementFactory;
    }

    /**
     * @param string $className
     * @return Form\Container
     */
    public function getForm($className)
    {
        $object = $this->getObject($className);

        if ($object instanceof ConfigurableInterface) {
            $builder = new Form\Builder();

            $object->configure($builder, $this->elementFactory);

            return $builder->getForm();
        }

        return null;
    }

    /**
     * @param string $className
     * @return mixed
     */
    protected function getObject($className)
    {
        if (empty($className) || !is_string($className)) {
            throw new \RuntimeException('Invalid class name');
        }

        if (!class_exists($className)) {
            return null;
        }

        return $this->factory->factory($className);
    }
}
