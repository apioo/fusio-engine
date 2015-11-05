<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace Fusio\Engine;

use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;

/**
 * ConfigurableInterface
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ConfigurableInterface
{
    /**
     * Returns a human readable string which represents this resource
     *
     * @return string
     */
    public function getName();

    /**
     * Builds a form which the user can configure before. The entered values get 
     * then passed as configuration to the handle method
     *
     * @param \Fusio\Engine\Form\BuilderInterface $builder
     * @param \Fusio\Engine\Form\ElementFactoryInterface $elementFactory
     */
    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory);
}
