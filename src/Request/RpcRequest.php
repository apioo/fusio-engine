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

namespace Fusio\Engine\Request;

use Fusio\Engine\Record\PassthruRecord;
use PSX\Record\RecordInterface;

/**
 * RpcRequest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class RpcRequest implements RpcInterface
{
    private string $method;
    private RecordInterface $arguments;

    public function __construct(string $method, RecordInterface $arguments)
    {
        $this->method    = $method;
        $this->arguments = $arguments;
    }

    public function get(string $name): mixed
    {
        return $this->arguments->get($name);
    }

    public function getPayload(): mixed
    {
        $body = $this->arguments->get('payload');
        if ($body instanceof PassthruRecord) {
            return $body->getPayload();
        } else {
            return $body;
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getArgument(string $name): mixed
    {
        return $this->arguments->get($name);
    }

    public function getArguments(): RecordInterface
    {
        return $this->arguments;
    }

    public function withArguments(RecordInterface $arguments): self
    {
        $self = clone $this;
        $self->arguments = $arguments;

        return $self;
    }
}
