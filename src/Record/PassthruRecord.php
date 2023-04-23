<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Record;

use PSX\Record\Record;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * This record is used if a route has specified the passthru schema that means that we redirect the result from the
 * reader to the action. I.e. in case of json this contains a stdClass and for xml a DOMDocument
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
