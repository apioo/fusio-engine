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

namespace Fusio\Engine\Tests;

use Fusio\Engine\Action\MemoryQueue;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\Exception\ActionNotFoundException;
use Fusio\Engine\Model\Action;
use Fusio\Engine\NameBuilder;
use Fusio\Engine\Processor;
use Fusio\Engine\ProcessorInterface;
use Fusio\Engine\Repository;
use Fusio\Engine\RequestInterface;
use Fusio\Engine\Response\FactoryInterface;
use Fusio\Engine\Test\CallbackAction;
use Fusio\Engine\Test\EngineTestCaseTrait;
use PHPUnit\Framework\TestCase;
use PSX\Http\Environment\HttpResponseInterface;

/**
 * NameBuilderTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class NameBuilderTest extends TestCase
{
    /**
     * @dataProvider providerNames
     */
    public function testFromClass(string $action, string $expect)
    {
        $this->assertSame($expect, NameBuilder::fromClass($action));
    }

    public function providerNames(): array
    {
        return [
            ['Foo', 'Foo'],
            ['FooBar', 'Foo-Bar'],
            ['Bar\\Foo', 'Foo'],
            ['Bar\\FooBar', 'Foo-Bar'],
        ];
    }
}