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

namespace Fusio\Engine\Tests\Cache;

use Doctrine\Common\Cache\ArrayCache;
use Fusio\Engine\Cache\Provider;

/**
 * ProviderTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class ProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProvider()
    {
        $provider = new Provider(new ArrayCache());

        $this->assertFalse($provider->contains('foo'));
        $this->assertFalse($provider->fetch('foo'));

        $provider->save('foo', 'bar');

        $this->assertTrue($provider->contains('foo'));
        $this->assertSame('bar', $provider->fetch('foo'));

        $provider->delete('foo');

        $this->assertFalse($provider->contains('foo'));
        $this->assertFalse($provider->fetch('foo'));
    }
}
