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

namespace Fusio\Engine\Template;

/**
 * Factory
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Factory implements FactoryInterface
{
    /**
     * @var boolean
     */
    protected $debug;

    /**
     * @var boolean
     */
    protected $cache;

    /**
     * @param boolean $debug
     * @param string|false|\Twig_CacheInterface $cache
     */
    public function __construct($debug, $cache = false)
    {
        $this->debug = $debug;
        $this->cache = $cache;
    }

    /**
     * @param string|null $cacheKey
     * @return \Fusio\Engine\Template\Parser\SqlInterface
     */
    public function newSqlParser($cacheKey = null)
    {
        return new Parser\Sql($this->debug, $this->cache, $cacheKey);
    }

    /**
     * @param string|null $cacheKey
     * @return \Fusio\Engine\Template\Parser\TextInterface
     */
    public function newTextParser($cacheKey = null)
    {
        return new Parser\Text($this->debug, $this->cache, $cacheKey);
    }
}
