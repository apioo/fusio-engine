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
     * @var string
     */
    private $providerName;

    /**
     * @var string
     */
    private $providerRuntime;

    /**
     * @var array
     */
    private $plugins;

    /**
     * @var array
     */
    private $layers;

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return $this->providerName;
    }

    /**
     * @param string $providerName
     */
    public function setProviderName(string $providerName): void
    {
        $this->providerName = $providerName;
    }

    /**
     * @return string
     */
    public function getProviderRuntime(): string
    {
        return $this->providerRuntime;
    }

    /**
     * @param string $providerRuntime
     */
    public function setProviderRuntime(string $providerRuntime): void
    {
        $this->providerRuntime = $providerRuntime;
    }

    /**
     * @return array
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /**
     * @param array $plugins
     */
    public function setPlugins(array $plugins): void
    {
        $this->plugins = $plugins;
    }

    /**
     * @return array
     */
    public function getLayers(): array
    {
        return $this->layers;
    }

    /**
     * @param array $layers
     */
    public function setLayers(array $layers): void
    {
        $this->layers = $layers;
    }
}
