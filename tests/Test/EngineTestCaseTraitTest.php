<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace Fusio\Engine\Tests\Test;

use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\Factory;
use Fusio\Engine\Form;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\Parser;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\RequestInterface;
use Fusio\Engine\Response;
use Fusio\Engine\Schema;
use Fusio\Engine\Template;
use Fusio\Engine\Test\EngineTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * EngineTestCaseTraitTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class EngineTestCaseTraitTest extends EngineTestCase
{
    public function testGetRequest()
    {
        $this->assertInstanceOf(RequestInterface::class, $this->getRequest());
    }

    public function testGetParameters()
    {
        $this->assertInstanceOf(ParametersInterface::class, $this->getParameters());
    }

    public function testGetContext()
    {
        $this->assertInstanceOf(ContextInterface::class, $this->getContext());
    }

    public function testContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
        $this->assertInstanceOf(Parser\ParserInterface::class, $this->container->get('action_parser'));
        $this->assertInstanceOf(Factory\ActionInterface::class, $this->container->get('action_factory'));
        $this->assertInstanceOf(Repository\ActionInterface::class, $this->container->get('action_repository'));
        $this->assertInstanceOf(ProcessorInterface::class, $this->container->get('processor'));
        $this->assertInstanceOf(Parser\ParserInterface::class, $this->container->get('connection_parser'));
        $this->assertInstanceOf(Factory\ConnectionInterface::class, $this->container->get('connection_factory'));
        $this->assertInstanceOf(Repository\ConnectionInterface::class, $this->container->get('connection_repository'));
        $this->assertInstanceOf(ConnectorInterface::class, $this->container->get('connector'));
        $this->assertInstanceOf(Schema\ParserInterface::class, $this->container->get('schema_parser'));
        $this->assertInstanceOf(Schema\LoaderInterface::class, $this->container->get('schema_loader'));
        $this->assertInstanceOf(Repository\AppInterface::class, $this->container->get('app_repository'));
        $this->assertInstanceOf(Repository\UserInterface::class, $this->container->get('user_repository'));
        $this->assertInstanceOf(Template\FactoryInterface::class, $this->container->get('template_factory'));
        $this->assertInstanceOf(Form\ElementFactoryInterface::class, $this->container->get('form_element_factory'));
        $this->assertInstanceOf(Response\FactoryInterface::class, $this->container->get('response'));
    }
}
