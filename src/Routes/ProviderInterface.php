<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Routes;

use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\ParametersInterface;

/**
 * Preconfigured route provider which helps to create automatically schemas,
 * actions and routes for the user. This can be used to create complete
 * applications
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
interface ProviderInterface extends ConfigurableInterface
{
    /**
     * The provider needs to add the schemas, actions and routes to the setup
     * using the provided configuration. The system then automatically creates
     * and validates all provided data. The base path is path which was chosen
     * by the user, all routes are automatically registered under the base path
     * so there is no need to add it manually, it is there to build schema and
     * action names based on the base path
     * 
     * @param \Fusio\Engine\Routes\SetupInterface $setup
     * @param string $basePath
     * @param \Fusio\Engine\ParametersInterface $configuration
     * @return void
     */
    public function setup(SetupInterface $setup, string $basePath, ParametersInterface $configuration);
}
