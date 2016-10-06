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

namespace Fusio\Engine\Json;

use PSX\Data\Reader;
use PSX\Data\ReaderInterface;
use PSX\Data\Writer;
use PSX\Data\WriterInterface;

/**
 * Processor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Processor implements ProcessorInterface
{
    /**
     * @var \PSX\Data\ReaderInterface
     */
    protected $reader;

    /**
     * @var \PSX\Data\WriterInterface
     */
    protected $writer;

    /**
     * @param \PSX\Data\ReaderInterface $reader
     * @param \PSX\Data\WriterInterface $writer
     */
    public function __construct(ReaderInterface $reader, WriterInterface $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * @param string $data
     * @param string $contentType
     * @return \stdClass
     */
    public function read($data)
    {
        return $this->reader->read($data);
    }

    /**
     * @param mixed $data
     * @param string $contentType
     * @return string
     */
    public function write($data)
    {
        return $this->writer->write($data);
    }
}
