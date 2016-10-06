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

namespace Fusio\Engine\Template;

use Twig_LoaderInterface;

/**
 * StackLoader
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class StackLoader implements Twig_LoaderInterface
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @var string
     */
    protected $lastModified;

    /**
     * @param string $source
     * @param string $cacheKey
     * @param string $lastModified
     */
    public function set($source, $cacheKey, $lastModified)
    {
        $this->source       = $source;
        $this->cacheKey     = $cacheKey;
        $this->lastModified = $lastModified;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getSource($name)
    {
        return $this->source;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getCacheKey($name)
    {
        return $this->cacheKey;
    }

    /**
     * @param string $name
     * @param integer $time
     * @return boolean
     */
    public function isFresh($name, $time)
    {
        return strtotime($this->lastModified) <= $time;
    }
}
