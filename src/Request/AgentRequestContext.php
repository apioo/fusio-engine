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
use Fusio\Engine\Model;

/**
 * Indicates that an action was invoked by an agent call
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
readonly class AgentRequestContext implements RequestContextInterface
{
    public function __construct(private Model\AgentInterface $agent)
    {
    }

    public function getAgent(): Model\AgentInterface
    {
        return $this->agent;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => ClassName::serialize(self::class),
            'id' => $this->agent->getId(),
            'name' => $this->agent->getName(),
            'description' => $this->agent->getDescription(),
        ];
    }
}
