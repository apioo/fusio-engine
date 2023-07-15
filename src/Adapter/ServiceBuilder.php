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

namespace Fusio\Engine\Adapter;

use Fusio\Engine\Action\ResolverInterface;
use Fusio\Engine\ActionInterface;
use Fusio\Engine\ConnectionInterface;
use Fusio\Engine\Generator\ProviderInterface as GeneratorProviderInterface;
use Fusio\Engine\Payment\ProviderInterface as PaymentProviderInterface;
use Fusio\Engine\User\ProviderInterface as UserProviderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;

/**
 * ServiceBuilder
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ServiceBuilder
{
    public static function build(ContainerConfigurator $container): ServicesConfigurator
    {
        $services = $container->services();
        $services->defaults()
            ->autowire()
            ->autoconfigure();

        $services
            ->instanceof(ConnectionInterface::class)
            ->tag('fusio.connection')
            ->public();

        $services
            ->instanceof(ActionInterface::class)
            ->tag('fusio.action')
            ->public();

        $services
            ->instanceof(ResolverInterface::class)
            ->tag('fusio.action.resolver');

        $services
            ->instanceof(UserProviderInterface::class)
            ->tag('fusio.user');

        $services
            ->instanceof(PaymentProviderInterface::class)
            ->tag('fusio.payment');

        $services
            ->instanceof(GeneratorProviderInterface::class)
            ->tag('fusio.generator');

        return $services;
    }
}
