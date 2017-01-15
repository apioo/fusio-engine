<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Dependency;

use Doctrine\Common\Annotations;
use Doctrine\Common\Cache as DoctrineCache;
use Fusio\Engine\Connector;
use Fusio\Engine\ConnectorInterface;
use Fusio\Engine\Factory;
use Fusio\Engine\Form;
use Fusio\Engine\Parser;
use Fusio\Engine\Processor;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\Response;
use Fusio\Engine\Schema;
use PSX\Framework\Dependency\ObjectBuilder;

/**
 * EngineTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
trait EngineTrait
{
    /**
     * @return \Fusio\Engine\Parser\ParserInterface
     */
    public function getActionParser()
    {
        return new Parser\Memory(
            $this->get('action_factory'),
            $this->get('form_element_factory'),
            []
        );
    }

    /**
     * @return \Fusio\Engine\Factory\ActionInterface
     */
    public function getActionFactory()
    {
        return new Factory\Action($this, [
            ConnectorInterface::class => 'connector',
            Response\FactoryInterface::class => 'response',
            ProcessorInterface::class => 'processor',
        ]);
    }

    /**
     * @return \Fusio\Engine\Repository\ActionInterface
     */
    public function getActionRepository()
    {
        return new Repository\ActionMemory();
    }

    /**
     * @return \Fusio\Engine\ProcessorInterface
     */
    public function getProcessor()
    {
        return new Processor(
            $this->get('action_repository'),
            $this->get('action_factory')
        );
    }

    /**
     * @return \Fusio\Engine\Parser\ParserInterface
     */
    public function getConnectionParser()
    {
        return new Parser\Memory(
            $this->get('connection_factory'),
            $this->get('form_element_factory'),
            []
        );
    }

    /**
     * @return \Fusio\Engine\Factory\ConnectionInterface
     */
    public function getConnectionFactory()
    {
        return new Factory\Connection($this);
    }

    /**
     * @return \Fusio\Engine\Repository\ConnectionInterface
     */
    public function getConnectionRepository()
    {
        return new Repository\ConnectionMemory();
    }

    /**
     * @return \Fusio\Engine\ConnectorInterface
     */
    public function getConnector()
    {
        return new Connector(
            $this->get('connection_repository'),
            $this->get('connection_factory')
        );
    }

    /**
     * @return \Fusio\Engine\Schema\ParserInterface
     */
    public function getSchemaParser()
    {
        return new Schema\Parser();
    }

    /**
     * @return \Fusio\Engine\Schema\LoaderInterface
     */
    public function getSchemaLoader()
    {
        return new Schema\Loader();
    }

    /**
     * @return \Fusio\Engine\Repository\AppInterface
     */
    public function getAppRepository()
    {
        return new Repository\AppMemory();
    }

    /**
     * @return \Fusio\Engine\Repository\UserInterface
     */
    public function getUserRepository()
    {
        return new Repository\UserMemory();
    }

    /**
     * @return \Fusio\Engine\Form\ElementFactoryInterface
     */
    public function getFormElementFactory()
    {
        return new Form\ElementFactory(
            $this->get('action_repository'),
            $this->get('connection_repository')
        );
    }

    /**
     * @return \Fusio\Engine\Response\FactoryInterface
     */
    public function getResponse()
    {
        return new Response\Factory();
    }

    /**
     * @return \PSX\Framework\Dependency\ObjectBuilderInterface
     */
    public function getObjectBuilder()
    {
        return new ObjectBuilder(
            $this,
            $this->get('annotation_reader')
        );
    }

    /**
     * @return \Doctrine\Common\Annotations\Reader
     */
    public function getAnnotationReader()
    {
        return $this->newDoctrineAnnotationImpl([
            'PSX\Framework\Annotation',
        ]);
    }

    /**
     * @param array $namespaces
     * @return \Doctrine\Common\Annotations\Reader
     */
    protected function newDoctrineAnnotationImpl(array $namespaces)
    {
        $this->registerAnnotationLoader($namespaces);

        $reader = new Annotations\SimpleAnnotationReader();
        foreach ($namespaces as $namespace) {
            $reader->addNamespace($namespace);
        }

        return $reader;
    }

    /**
     * @param array $namespaces
     */
    protected function registerAnnotationLoader(array $namespaces)
    {
        Annotations\AnnotationRegistry::reset();
        Annotations\AnnotationRegistry::registerLoader(function ($class) use ($namespaces) {
            foreach ($namespaces as $namespace) {
                if (strpos($class, $namespace) === 0) {
                    spl_autoload_call($class);

                    return class_exists($class, false);
                }
            }
        });
    }
}
