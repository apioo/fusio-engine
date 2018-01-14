<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Form\Element;

use Fusio\Engine\Repository;

/**
 * Action
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Action extends Select
{
    /**
     * @var \Fusio\Engine\Repository\ActionInterface
     */
    protected $_repository;

    /**
     * @var array
     */
    protected $_allowedClasses;

    public function __construct($name, $title, Repository\ActionInterface $repository, $help = null, array $allowedClasses = null)
    {
        parent::__construct($name, $title, array(), $help);

        $this->_repository     = $repository;
        $this->_allowedClasses = $allowedClasses;

        $this->load();
    }

    protected function load()
    {
        $result = $this->_repository->getAll();

        foreach ($result as $row) {
            if ($this->_allowedClasses === null || in_array($row->getClass(), $this->_allowedClasses)) {
                $this->addOption($row->getId(), $row->getName());
            }
        }
    }
}
