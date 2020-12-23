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

namespace Fusio\Engine\Serverless;

/**
 * Contains config options for the serverless.yaml file
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 * @see     https://www.serverless.com/
 */
class Config
{
    /**
     * @var string|null
     */
    private $providerName;

    /**
     * @var string|null
     */
    private $providerRuntime;

    /**
     * @var array|null
     */
    private $plugins;

    /**
     * @var array|null
     */
    private $layers;

    /**
     * @var \Closure|null
     */
    private $handlerGenerator;

    /**
     * @return string|null
     */
    public function getProviderName(): ?string
    {
        return $this->providerName;
    }

    /**
     * @param string|null $providerName
     */
    public function setProviderName(?string $providerName): void
    {
        $this->providerName = $providerName;
    }

    /**
     * @return string|null
     */
    public function getProviderRuntime(): ?string
    {
        return $this->providerRuntime;
    }

    /**
     * @param string|null $providerRuntime
     */
    public function setProviderRuntime(?string $providerRuntime): void
    {
        $this->providerRuntime = $providerRuntime;
    }

    /**
     * @return array|null
     */
    public function getPlugins(): ?array
    {
        return $this->plugins;
    }

    /**
     * @param array|null $plugins
     */
    public function setPlugins(?array $plugins): void
    {
        $this->plugins = $plugins;
    }

    /**
     * @return array|null
     */
    public function getLayers(): ?array
    {
        return $this->layers;
    }

    /**
     * @param array|null $layers
     */
    public function setLayers(?array $layers): void
    {
        $this->layers = $layers;
    }

    /**
     * @return \Closure|null
     */
    public function getHandlerGenerator(): ?\Closure
    {
        return $this->handlerGenerator;
    }

    /**
     * Provides an option to customize the value which is inserted as handler
     * at the serverless.yaml file. By default we simply use the path to the
     * handler file. The closure has the following signature (basePath, actionName)
     * 
     * @param \Closure|null $handlerGenerator
     */
    public function setHandlerGenerator(?\Closure $handlerGenerator): void
    {
        $this->handlerGenerator = $handlerGenerator;
    }
}
