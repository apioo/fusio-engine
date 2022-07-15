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

namespace Fusio\Engine\Form\Element;

use Fusio\Engine\Form\Element;

/**
 * TextArea
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class TextArea extends Element
{
    private string $mode;

    public function __construct(string $name, string $title, string $mode, ?string $help = null)
    {
        parent::__construct($name, $title, $help);

        $this->mode = $mode;
    }

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }
    
    public function getMode(): string
    {
        return $this->mode;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'mode' => $this->mode,
        ]);
    }

    protected function getElement(): string
    {
        return 'textarea';
    }
}
