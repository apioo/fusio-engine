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

namespace Fusio\Engine\Tests\Parser;

use Fusio\Engine\Action\Runtime;
use Fusio\Engine\ActionInterface;
use Fusio\Engine\Parser\Directory;
use Fusio\Engine\Test\EngineTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Container;

/**
 * DirectoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class DirectoryTest extends TestCase
{
    use EngineTestCaseTrait;

    protected function configure(Runtime $runtime, Container $container): void
    {
        $container->set(Foo\Bar\Bar::class, new Foo\Bar\Bar($runtime));
        $container->set(Foo\Bar\Baz\Baz::class, new Foo\Bar\Baz\Baz($runtime));
        $container->set(Foo\Foo::class, new Foo\Foo($runtime));
    }

    public function testGetClasses()
    {
        $parser  = new Directory($this->getActionFactory(), $this->getFormElementFactory(), __DIR__ . '/Foo', 'Fusio\Engine\Tests\Parser\Foo', ActionInterface::class);
        $classes = $parser->getClasses();

        $expect = [
            [
                'name'  => 'Bar',
                'class' => 'Fusio\Engine\Tests\Parser\Foo\Bar\Bar',
            ],
            [
                'name'  => 'Baz',
                'class' => 'Fusio\Engine\Tests\Parser\Foo\Bar\Baz\Baz',
            ],
            [
                'name'  => 'Foo',
                'class' => 'Fusio\Engine\Tests\Parser\Foo\Foo',
            ],
        ];

        $this->assertEquals($expect, $classes);
    }


}
