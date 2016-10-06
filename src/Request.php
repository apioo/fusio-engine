<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Http\RequestInterface as HttpRequestInterface;
use PSX\Json\Pointer;
use PSX\Record\RecordInterface;

/**
 * Request
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Request implements RequestInterface
{
    /**
     * @var \PSX\Http\RequestInterface
     */
    protected $request;

    /**
     * @var \Fusio\Engine\Parameters
     */
    protected $uriFragments;

    /**
     * @var \Fusio\Engine\Parameters
     */
    protected $parameters;

    /**
     * @var \PSX\Record\RecordInterface
     */
    protected $body;

    /**
     * @param \PSX\Http\RequestInterface $request
     * @param array $uriFragments
     * @param array $parameters
     * @param \PSX\Record\RecordInterface $body
     */
    public function __construct(HttpRequestInterface $request, array $uriFragments, array $parameters, RecordInterface $body)
    {
        $this->request      = $request;
        $this->uriFragments = new Parameters($uriFragments);
        $this->parameters   = new Parameters($parameters);
        $this->body         = $body;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->request->getMethod();
    }

    /**
     * @param string $name
     * @return null|string
     */
    public function getHeader($name)
    {
        return $this->request->getHeader($name);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getUriFragment($name)
    {
        return $this->uriFragments->get($name);
    }

    /**
     * @return \Fusio\Engine\Parameters
     */
    public function getUriFragments()
    {
        return $this->uriFragments;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getParameter($name)
    {
        return $this->parameters->get($name);
    }

    /**
     * @return \Fusio\Engine\Parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return \PSX\Record\RecordInterface
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param \PSX\Record\RecordInterface $body
     * @return \Fusio\Engine\Request
     */
    public function withBody(RecordInterface $body)
    {
        $self = clone $this;
        $self->body = $body;

        return $self;
    }

    /**
     * Queries the request body with a json pointer selector and returns the 
     * response
     * 
     * @param string $pointer
     * @return mixed|null
     */
    public function queryPointer($pointer)
    {
        $pointer = new Pointer('/' . ltrim($pointer, '/'));
        $value   = $pointer->evaluate($this->body);

        return $value;
    }
}
