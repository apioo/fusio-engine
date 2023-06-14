<?php
/*
 * Fusio is an open source API management platform which helps to create innovative API solutions.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
abstract class OAuth2ConnectionAbstract implements ConnectionInterface, OAuth2Interface
{
    public function configure(BuilderInterface $builder, ElementFactoryInterface $elementFactory): void
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
