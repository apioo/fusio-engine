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

namespace Fusio\Engine\Record;

use PSX\Record\Record;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * This record is used if a route has specified the passthru schema that means that we redirect the result from the
 * reader to the action. I.e. in case of json this contains a stdClass and for xml a DOMDocument
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 * @extends Record<mixed>
 */
class PassthruRecord extends Record
{
    private mixed $payload;
    private PropertyAccessor $accessor;

    public function __construct(iterable $properties = [], mixed $payload = null)
    {
        parent::__construct($properties);

        $this->payload  = $payload;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }

    public function get(string $key): mixed
    {
        return $this->accessor->getValue($this->payload, $key);
    }

    public function has(string $key): bool
    {
        return $this->accessor->isReadable($this->payload, $key);
    }

    public function containsKey(string $key): bool
    {
        return $this->accessor->isReadable($this->payload, $key);
    }

    public static function fromPayload(mixed $payload): iterable
    {
        if ($payload instanceof \stdClass) {
            $properties = (array) $payload;
        } elseif (is_iterable($payload)) {
            $properties = $payload;
        } else {
            $properties = [];
        }

        return new self($properties, $payload);
    }
}
