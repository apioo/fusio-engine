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

namespace Fusio\Engine;

use Fusio\Engine\Record\PassthruRecord;
use Fusio\Engine\Request\RequestContextInterface;
use PSX\Record\RecordInterface;

/**
 * Request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class Request implements RequestInterface
{
    private RecordInterface $arguments;
    private ?RecordInterface $payload;
    private RequestContextInterface $context;

    public function __construct(RecordInterface $arguments, ?RecordInterface $payload, RequestContextInterface $context)
    {
        $this->arguments = $arguments;
        $this->payload = $payload;
        $this->context = $context;
    }

    public function get(string $name): mixed
    {
        return $this->arguments->get($name);
    }

    public function getPayload(): mixed
    {
        if ($this->payload instanceof PassthruRecord) {
            return $this->payload->getPayload();
        } else {
            return $this->payload;
        }
    }

    public function getContext(): RequestContextInterface
    {
        return $this->context;
    }
}
