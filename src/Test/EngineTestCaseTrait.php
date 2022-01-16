<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Test;

use Fusio\Engine\Action\QueueInterface;
use Fusio\Engine\Context;
use Fusio\Engine\Dependency\EngineContainer;
use Fusio\Engine\Factory;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\Model\Action;
use Fusio\Engine\Model\App;
use Fusio\Engine\Model\User;
use Fusio\Engine\Parameters;
use Fusio\Engine\Repository;
use Fusio\Engine\Request\HttpInterface;
use Fusio\Engine\Request\HttpRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamInterface;
use PSX\Dependency\AutowireResolverInterface;
use PSX\Http\Environment\HttpContext;
use PSX\Http\Request;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Uri\Uri;

/**
 * EngineTestCaseTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
trait EngineTestCaseTrait
{
    private static ?ContainerInterface $container = null;

    protected function getRequest(?string $method = null, array $uriFragments = [], array $parameters = [], array $headers = [], ?RecordInterface $parsedBody = null, ?StreamInterface $rawBody = null): HttpInterface
    {
        $uri = new Uri('http://127.0.0.1/foo');
        $uri = $uri->withParameters($parameters);

        $request = new Request($uri, $method === null ? 'GET' : $method, $headers, $rawBody);
        $context = new HttpContext($request, $uriFragments);

        return new HttpRequest(
            $context,
            $parsedBody === null ? new Record() : $parsedBody
        );
    }

    protected function getParameters(array $parameters = array()): Parameters
    {
        return new Parameters($parameters);
    }

    protected function getContext(): Context
    {
        $app = new App(
            anonymous: false,
            id: 3,
            userId: 2,
            status: 1,
            name: 'Foo-App',
            url: 'http://google.com',
            appKey: '5347307d-d801-4075-9aaa-a21a29a448c5',
            parameters: ['foo' => 'bar'],
            scopes: ['foo', 'bar'],
        );

        $user = new User(
            anonymous: false,
            id: 2,
            roleId: 1,
            categoryId: 1,
            status: 0,
            name: 'Consumer',
            email: 'consumer@app.dev',
            points: 100,
        );

        $action = new Action(
            id: 1,
            name: 'foo',
            class: \stdClass::class,
            engine: \stdClass::class,
            async: false,
            config: [],
        );

        $context = new Context(34, 'http://127.0.0.1', $app, $user);
        return $context->withAction($action);
    }

    protected function getActionFactory(): Factory\ActionInterface
    {
        return $this->getContainer()->get('action_factory');
    }

    protected function getActionQueue(): QueueInterface
    {
        return $this->getContainer()->get('action_queue');
    }

    protected function getActionRepository(): Repository\ActionInterface
    {
        return $this->getContainer()->get('action_repository');
    }

    protected function getConnectionFactory(): Factory\ConnectionInterface
    {
        return $this->getContainer()->get('connection_factory');
    }

    protected function getConnectionRepository(): Repository\ConnectionInterface
    {
        return $this->getContainer()->get('connection_repository');
    }

    protected function getFormElementFactory(): ElementFactoryInterface
    {
        return $this->getContainer()->get('form_element_factory');
    }

    protected function getContainerAutowireResolver(): AutowireResolverInterface
    {
        return $this->getContainer()->get('container_autowire_resolver');
    }

    protected function getContainer(): ContainerInterface
    {
        if (self::$container === null) {
            self::$container = $this->newContainer();
        }

        return self::$container;
    }

    protected function newContainer(): ContainerInterface
    {
        return new EngineContainer();
    }
}
