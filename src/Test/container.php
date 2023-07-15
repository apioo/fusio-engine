<?php

use Fusio\Engine\Adapter\ServiceBuilder;
use Fusio\Engine\Test\CallbackAction;
use Fusio\Engine\Test\CallbackConnection;
use Fusio\Engine\Test\EngineContainer;
use Fusio\Engine\Test\ProviderCollection;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $container) {
    $services = ServiceBuilder::build($container);
    $services->set('connections', ProviderCollection::class)
        ->arg('$services', tagged_iterator('fusio.connection'))
        ->public();
    $services->set('actions', ProviderCollection::class)
        ->arg('$services', tagged_iterator('fusio.action'))
        ->public();
    $services->set('users', ProviderCollection::class)
        ->arg('$services', tagged_iterator('fusio.user'))
        ->public();
    $services->set('payments', ProviderCollection::class)
        ->arg('$services', tagged_iterator('fusio.payment'))
        ->public();
    $services->set('generators', ProviderCollection::class)
        ->arg('$services', tagged_iterator('fusio.generator'))
        ->public();

    $services->set(NullHandler::class);
    $services->set(Logger::class)
        ->arg('$name', 'Fusio-Engine')
        ->arg('$handlers', [service(NullHandler::class)]);
    $services->alias(LoggerInterface::class, Logger::class);

    $services->set(ArrayAdapter::class);
    $services->set(Psr16Cache::class)
        ->arg('$pool', service(ArrayAdapter::class));
    $services->alias(CacheInterface::class, Psr16Cache::class);

    $services->set(EngineContainer::class)
        ->public();

    $services->set(CallbackConnection::class);
    $services->set(CallbackAction::class);
};
