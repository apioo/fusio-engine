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

namespace Fusio\Engine\Form\Element;

use Fusio\Engine\Form\Element;

/**
 * TextArea
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
