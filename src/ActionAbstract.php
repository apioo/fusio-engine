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

use Fusio\Engine\Action\ServiceAwareInterface;

/**
 * ActionAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
abstract class ActionAbstract implements ActionInterface, ServiceAwareInterface
{
    /**
     * @var \Fusio\Engine\ConnectorInterface
     */
    protected $connector;

    /**
     * @var \Fusio\Engine\Response\FactoryInterface
     */
    protected $response;

    /**
     * @var \Fusio\Engine\ProcessorInterface
     */
    protected $processor;

    /**
     * @var \Fusio\Engine\Template\FactoryInterface
     */
    protected $templateFactory;

    /**
     * @var \Fusio\Engine\Http\ClientInterface
     */
    protected $httpClient;

    /**
     * @var \Fusio\Engine\Json\ProcessorInterface
     */
    protected $jsonProcessor;

    /**
     * @var \Fusio\Engine\Cache\ProviderInterface
     */
    protected $cacheProvider;

    /**
     * @param \Fusio\Engine\ConnectorInterface $connector
     */
    public function setConnector(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param \Fusio\Engine\Response\FactoryInterface $response
     */
    public function setResponse(Response\FactoryInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @param \Fusio\Engine\ProcessorInterface $processor
     */
    public function setProcessor(ProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    /**
     * @param \Fusio\Engine\Template\FactoryInterface $templateFactory
     */
    public function setTemplateFactory(Template\FactoryInterface $templateFactory)
    {
        $this->templateFactory = $templateFactory;
    }

    /**
     * @param \Fusio\Engine\Http\ClientInterface $httpClient
     */
    public function setHttpClient(Http\ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param \Fusio\Engine\Json\ProcessorInterface $jsonProcessor
     */
    public function setJsonProcessor(Json\ProcessorInterface $jsonProcessor)
    {
        $this->jsonProcessor = $jsonProcessor;
    }

    /**
     * @param \Fusio\Engine\Cache\ProviderInterface $cacheProvider
     */
    public function setCacheProvider(Cache\ProviderInterface $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }
}
