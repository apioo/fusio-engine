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

namespace Fusio\Engine\Connection;

use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\ParametersInterface;

/**
 * OAuth2ConnectionAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
abstract class OAuth2ConnectionAbstract implements ConnectionInterface, OAuth2Interface
{
    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory)
    {
        $builder->add($elementFactory->newInput(OAuth2Interface::CONFIG_CLIENT_ID, 'Client-Id', 'text', 'The client id'));
        $builder->add($elementFactory->newInput(OAuth2Interface::CONFIG_CLIENT_SECRET, 'Client-Secret', 'text', 'The client secret'));
        $builder->add($elementFactory->newInput(OAuth2Interface::CONFIG_ACCESS_TOKEN, 'Access-Token', 'password', 'Optional an access token'));
    }

    protected function getClientId(ParametersInterface $config): string
    {
        return $config->get(OAuth2Interface::CONFIG_CLIENT_ID);
    }

    protected function getClientSecret(ParametersInterface $config): string
    {
        return $config->get(OAuth2Interface::CONFIG_CLIENT_SECRET);
    }

    protected function getAccessToken(ParametersInterface $config): string
    {
        return $config->get(OAuth2Interface::CONFIG_ACCESS_TOKEN);
    }
}
