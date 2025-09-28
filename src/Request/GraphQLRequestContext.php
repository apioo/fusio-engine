<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Request;

use Fusio\Engine\Inflection\ClassName;

/**
 * Indicates that an action was invoked by GraphQL
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class GraphQLRequestContext implements RequestContextInterface
{
    private mixed $rootValue;
    private mixed $context;
    private array $fieldSelection;

    public function __construct(mixed $rootValue, mixed $context, array $fieldSelection)
    {
        $this->rootValue = $rootValue;
        $this->context = $context;
        $this->fieldSelection = $fieldSelection;
    }

    public function getRootValue(): mixed
    {
        return $this->rootValue;
    }

    public function getContext(): mixed
    {
        return $this->context;
    }

    /**
     * @return array<string, bool>
     */
    public function getFieldSelection(): array
    {
        return $this->fieldSelection;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => ClassName::serialize(self::class),
            'rootValue' => $this->rootValue,
            'context' => $this->context,
            'fieldSelection' => $this->fieldSelection,
        ];
    }
}
