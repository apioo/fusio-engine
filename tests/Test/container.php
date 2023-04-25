<?php

use Fusio\Engine\Adapter\ServiceBuilder;
use Fusio\Engine\Tests\Test\Impl\Action;
use Fusio\Engine\Tests\Test\Impl\Connection;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
    $services = ServiceBuilder::build($container);
    $services->set(Action::class);
    $services->set(Connection::class);
};
