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
 * @license http://www.gnu.org/licenses/agpl-3.0
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
