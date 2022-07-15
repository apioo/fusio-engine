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

use Fusio\Engine\Repository;

/**
 * ElementFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class ElementFactory implements ElementFactoryInterface
{
    private Repository\ActionInterface $actionRepository;
    private Repository\ConnectionInterface $connectionRepository;

    public function __construct(Repository\ActionInterface $actionRepository, Repository\ConnectionInterface $connectionRepository)
    {
        $this->actionRepository     = $actionRepository;
        $this->connectionRepository = $connectionRepository;
    }

    public function newAction(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): Element\Action
    {
        return new Element\Action($name, $title, $this->actionRepository, $help, $allowedClasses);
    }

    public function newConnection(string $name, string $title, ?string $help = null, ?array $allowedClasses = null): Element\Connection
    {
        return new Element\Connection($name, $title, $this->connectionRepository, $help, $allowedClasses);
    }

    public function newInput(string $name, string $title, string $type = 'text', ?string $help = null): Element\Input
    {
        return new Element\Input($name, $title, $type, $help);
    }

    public function newSelect(string $name, string $title, array $options = [], ?string $help = null): Element\Select
    {
        return new Element\Select($name, $title, $options, $help);
    }

    public function newTextArea(string $name, string $title, string $mode, ?string $help = null): Element\TextArea
    {
        return new Element\TextArea($name, $title, $mode, $help);
    }

    public function newTag(string $name, string $title, ?string $help = null): Element\Tag
    {
        return new Element\Tag($name, $title, $help);
    }

    public function newTypeSchema(string $name, string $title, ?string $help = null): Element\TypeSchema
    {
        return new Element\TypeSchema($name, $title, $help);
    }
}
