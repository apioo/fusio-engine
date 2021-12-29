<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2021 Christoph Kappestein <christoph.kappestein@gmail.com>
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
    private ?string $providerName;
    private ?string $providerRuntime;
    private ?array $plugins;
    private ?array $layers;
    private ?\Closure $handlerGenerator;

    public function getProviderName(): ?string
    {
        return $this->providerName;
    }

    public function setProviderName(?string $providerName): void
    {
        $this->providerName = $providerName;
    }

    public function getProviderRuntime(): ?string
    {
        return $this->providerRuntime;
    }

    public function setProviderRuntime(?string $providerRuntime): void
    {
        $this->providerRuntime = $providerRuntime;
    }

    public function getPlugins(): ?array
    {
        return $this->plugins;
    }

    public function setPlugins(?array $plugins): void
    {
        $this->plugins = $plugins;
    }

    public function getLayers(): ?array
    {
        return $this->layers;
    }

    public function setLayers(?array $layers): void
    {
        $this->layers = $layers;
    }

    public function getHandlerGenerator(): ?\Closure
    {
        return $this->handlerGenerator;
    }

    /**
     * Provides an option to customize the value which is inserted as handler at the serverless.yaml file. By default we
     * simply use the path to the handler file. The closure has the following signature (basePath, actionName)
     */
    public function setHandlerGenerator(?\Closure $handlerGenerator): void
    {
        $this->handlerGenerator = $handlerGenerator;
    }
}
