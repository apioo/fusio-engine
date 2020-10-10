<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Http\Environment\HttpContextInterface;
use PSX\Record\RecordInterface;

/**
 * Request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class HttpRequest implements HttpInterface
{
    /**
     * @var \PSX\Http\Environment\HttpContextInterface
     */
    protected $context;

    /**
     * @var \PSX\Record\RecordInterface
     */
    protected $body;

    /**
     * @param \PSX\Http\Environment\HttpContextInterface $context
     * @param \PSX\Record\RecordInterface $body
     */
    public function __construct(HttpContextInterface $context, RecordInterface $body)
    {
        $this->context = $context;
        $this->body    = $body;
    }

    /**
     * @inheritdoc
     */
    public function get($name)
    {
        return $this->getUriFragment($name) ?? ($this->getParameter($name) ?? $this->getBody()->getProperty($name));
    }

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return $this->context->getMethod();
    }

    /**
     * @inheritdoc
     */
    public function getHeader($name)
    {
        return $this->context->getHeader($name);
    }

    /**
     * @inheritdoc
     */
    public function getHeaders()
    {
        return $this->context->getHeaders();
    }

    /**
     * @inheritdoc
     */
    public function getUriFragment($name)
    {
        return $this->context->getUriFragment($name);
    }

    /**
     * @inheritdoc
     */
    public function getUriFragments()
    {
        return $this->context->getUriFragments();
    }

    /**
     * @inheritdoc
     */
    public function getParameter($name)
    {
        return $this->context->getParameter($name);
    }

    /**
     * @inheritdoc
     */
    public function getParameters()
    {
        return $this->context->getParameters();
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritdoc
     */
    public function withBody(RecordInterface $body)
    {
        $self = clone $this;
        $self->body = $body;

        return $self;
    }
}
