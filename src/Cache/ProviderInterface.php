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

namespace Fusio\Engine\Cache;

/**
 * Cache interface which is based on the doctrine dbal cache. It provides a 
 * cache mechanism for each action
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
interface ProviderInterface
{
    /**
     * Returns a cache entry for the provided id or false if the entry does not 
     * exist
     * 
     * @param string $id
     * @return mixed
     */
    public function fetch($id);

    /**
     * Returns whether a cache entry with the provided id exists
     *
     * @param string $id
     * @return boolean
     */
    public function contains($id);

    /**
     * Saves a cache entry with a specific id
     * 
     * @param string $id
     * @param mixed $data
     * @param integer $lifeTime
     */
    public function save($id, $data, $lifeTime = 0);

    /**
     * Removes cache entry by its id
     * 
     * @param string $id
     */
    public function delete($id);
}
