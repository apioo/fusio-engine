<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Fusio\Engine\Repository;

/**
 * ElementFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ElementFactory implements ElementFactoryInterface
{
    /**
     * @var \Fusio\Engine\Repository\ActionInterface
     */
    protected $actionRepository;

    /**
     * @var \Fusio\Engine\Repository\ConnectionInterface
     */
    protected $connectionRepository;

    /**
     * @param \Fusio\Engine\Repository\ActionInterface $actionRepository
     * @param \Fusio\Engine\Repository\ConnectionInterface $connectionRepository
     */
    public function __construct(Repository\ActionInterface $actionRepository, Repository\ConnectionInterface $connectionRepository)
    {
        $this->actionRepository     = $actionRepository;
        $this->connectionRepository = $connectionRepository;
    }

    public function newAction($name, $title, $help = null, array $allowedClasses = null)
    {
        return new Element\Action($name, $title, $this->actionRepository, $help, $allowedClasses);
    }

    public function newConnection($name, $title, $help = null, array $allowedClasses = null)
    {
        return new Element\Connection($name, $title, $this->connectionRepository, $help, $allowedClasses);
    }

    public function newInput($name, $title, $type = 'text', $help = null)
    {
        return new Element\Input($name, $title, $type, $help);
    }

    public function newSelect($name, $title, array $options = array(), $help = null)
    {
        return new Element\Select($name, $title, $options, $help);
    }

    public function newTextArea($name, $title, $mode, $help = null)
    {
        return new Element\TextArea($name, $title, $mode, $help);
    }

    public function newTag($name, $title, $help = null)
    {
        return new Element\Tag($name, $title, $help);
    }
}
