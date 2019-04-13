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

namespace Fusio\Engine\Test;

use Fusio\Engine\Context;
use Fusio\Engine\Dependency\EngineContainer;
use Fusio\Engine\Model\Action;
use Fusio\Engine\Model\App;
use Fusio\Engine\Model\User;
use Fusio\Engine\Parameters;
use Fusio\Engine\Request;
use Psr\Http\Message\StreamInterface;
use PSX\Http\Environment\HttpContext;
use PSX\Http\Request as HttpRequest;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Uri\Uri;

/**
 * EngineTestCaseTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
trait EngineTestCaseTrait
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected static $container;

    /**
     * @param string $method
     * @param array $uriFragments
     * @param array $parameters
     * @param array $headers
     * @param \PSX\Record\RecordInterface|null $parsedBody
     * @param \Psr\Http\Message\StreamInterface|null $rawBody
     * @return \Fusio\Engine\Request
     */
    protected function getRequest($method = null, array $uriFragments = [], array $parameters = [], array $headers = [], RecordInterface $parsedBody = null, StreamInterface $rawBody = null)
    {
        $uri = new Uri('http://127.0.0.1/foo');
        $uri = $uri->withParameters($parameters);

        $request = new HttpRequest($uri, $method === null ? 'GET' : $method, $headers, $rawBody);
        $context = new HttpContext($request, $uriFragments);

        return new Request(
            $context,
            $parsedBody === null ? new Record() : $parsedBody
        );
    }

    /**
     * @param array $parameters
     * @return \Fusio\Engine\Parameters
     */
    protected function getParameters(array $parameters = array())
    {
        return new Parameters($parameters);
    }

    /**
     * @return \Fusio\Engine\Context
     */
    protected function getContext()
    {
        $app = new App();
        $app->setAnonymous(false);
        $app->setId(3);
        $app->setUserId(2);
        $app->setStatus(1);
        $app->setName('Foo-App');
        $app->setUrl('http://google.com');
        $app->setParameters(['foo' => 'bar']);
        $app->setScopes(['foo', 'bar']);
        $app->setAppKey('5347307d-d801-4075-9aaa-a21a29a448c5');

        $user = new User();
        $user->setAnonymous(false);
        $user->setId(2);
        $user->setStatus(0);
        $user->setName('Consumer');

        $action = new Action();
        $action->setId(uniqid());
        $action->setName('foo');
        $action->setDate(date('Y-m-d H:i:s'));

        return new Context(34, 'http://127.0.0.1', $app, $user);
    }

    /**
     * @return \Fusio\Engine\Factory\ActionInterface
     */
    protected function getActionFactory()
    {
        return $this->getContainer()->get('action_factory');
    }

    /**
     * @return \Fusio\Engine\Repository\ActionInterface
     */
    protected function getActionRepository()
    {
        return $this->getContainer()->get('action_repository');
    }

    /**
     * @return \Fusio\Engine\Factory\ConnectionInterface
     */
    protected function getConnectionFactory()
    {
        return $this->getContainer()->get('connection_factory');
    }

    /**
     * @return \Fusio\Engine\Repository\ConnectionInterface
     */
    protected function getConnectionRepository()
    {
        return $this->getContainer()->get('connection_repository');
    }

    /**
     * @return \Fusio\Engine\Form\ElementFactoryInterface
     */
    protected function getFormElementFactory()
    {
        return $this->getContainer()->get('form_element_factory');
    }

    /**
     * @return \Psr\Container\ContainerInterface
     */
    protected function getContainer()
    {
        if (!self::$container) {
            self::$container = $this->newContainer();
        }

        return self::$container;
    }

    /**
     * @return \Psr\Container\ContainerInterface
     */
    protected function newContainer()
    {
        return new EngineContainer();
    }
}
