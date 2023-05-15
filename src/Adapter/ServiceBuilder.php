<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Adapter;

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
 * @license http://www.gnu.org/licenses/agpl-3.0
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
