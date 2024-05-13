<?php

use Fusio\Engine\Action;
use Fusio\Engine\Adapter\ServiceBuilder;
use Fusio\Engine\Connector;
use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\Dispatcher;
use Fusio\Engine\DispatcherInterface;
use Fusio\Engine\Factory;
use Fusio\Engine\Form;
use Fusio\Engine\Processor;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\Response;
use Fusio\Engine\Worker\ExecuteBuilder;
use Fusio\Engine\Worker\ExecuteBuilderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_locator;

return static function (ContainerConfigurator $container) {
    $services = ServiceBuilder::build($container);

    $services->set(Repository\ActionMemory::class);
    $services->alias(Repository\ActionInterface::class, Repository\ActionMemory::class);

    $services->set(Repository\ConnectionMemory::class);
    $services->alias(Repository\ConnectionInterface::class, Repository\ConnectionMemory::class);

    $services->set(Repository\AppMemory::class);
    $services->alias(Repository\AppInterface::class, Repository\AppMemory::class);

    $services->set(Repository\UserMemory::class);
    $services->alias(Repository\UserInterface::class, Repository\UserMemory::class);

    $services->set(Form\ElementFactory::class);
    $services->alias(Form\ElementFactoryInterface::class, Form\ElementFactory::class);

    $services->set(Factory\Action::class)
        ->arg('$actions', tagged_locator('fusio.action'));
    $services->alias(Factory\ActionInterface::class, Factory\Action::class);

    $services->set(Factory\Connection::class)
        ->arg('$connections', tagged_locator('fusio.connection'));
    $services->alias(Factory\ConnectionInterface::class, Factory\Connection::class);

    $services->set(Action\MemoryQueue::class);
    $services->alias(Action\QueueInterface::class, Action\MemoryQueue::class);

    $services->set(Action\Resolver\DatabaseAction::class);
    $services->set(Action\Resolver\PhpClass::class);

    $services->set(Processor::class)
        ->arg('$resolvers', tagged_iterator('fusio.action.resolver'));
    $services->alias(ProcessorInterface::class, Processor::class);

    $services->set(Dispatcher::class);
    $services->alias(DispatcherInterface::class, Dispatcher::class);

    $services->set(Connector::class);
    $services->alias(ConnectorInterface::class, Connector::class);

    $services->set(Response\Factory::class);
    $services->alias(Response\FactoryInterface::class, Response\Factory::class);

    $services->set(Action\Runtime::class);
    $services->alias(Action\RuntimeInterface::class, Action\Runtime::class);

    $services->set(ExecuteBuilder::class);
    $services->alias(ExecuteBuilderInterface::class, ExecuteBuilder::class);
};
