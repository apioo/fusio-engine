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

namespace Fusio\Engine\Schema;

use Fusio\Model\Backend\OperationParameters;
use Fusio\Model\Backend\OperationSchema;
use Fusio\Model\Backend\SchemaSource;
use PSX\Schema\Type;

/**
 * SchemaBuilder
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    https://www.fusio-project.org
 */
class SchemaBuilder
{
    /**
     * Returns the default collection parameters
     */
    public static function makeCollectionParameters(): OperationParameters
    {
        $startIndexSchema = new OperationSchema();
        $startIndexSchema->setType('integer');

        $countSchema = new OperationSchema();
        $countSchema->setType('integer');

        $sortBySchema = new OperationSchema();
        $sortBySchema->setType('string');

        $sortOrderSchema = new OperationSchema();
        $sortOrderSchema->setType('string');

        $filterBySchema = new OperationSchema();
        $filterBySchema->setType('string');

        $filterOpSchema = new OperationSchema();
        $filterOpSchema->setType('string');

        $filterValueSchema = new OperationSchema();
        $filterValueSchema->setType('string');

        $parameters = new OperationParameters();
        $parameters->put('startIndex', $startIndexSchema);
        $parameters->put('count', $countSchema);
        $parameters->put('sortBy', $sortBySchema);
        $parameters->put('sortOrder', $sortOrderSchema);
        $parameters->put('filterBy', $filterBySchema);
        $parameters->put('filterOp', $filterOpSchema);
        $parameters->put('filterValue', $filterValueSchema);
        return $parameters;
    }

    public static function makeCollectionResponse(string $name, ?object $type): SchemaSource
    {
        $data = new \stdClass();
        $data->definitions = (object) [
            $name => (object) [
                'type' => 'object',
                'properties' => (object) [
                    'totalResults' => (object) [
                        'type' => Type::INTEGER,
                    ],
                    'itemsPerPage' => (object) [
                        'type' => Type::INTEGER,
                    ],
                    'startIndex' => (object) [
                        'type' => Type::INTEGER,
                    ],
                    'entry' => (object) [
                        'type' => Type::ARRAY,
                        'items' => (object) [
                            '$ref' => $name . '_Entry'
                        ],
                    ],

                ],
            ],
            $name . '_Entry' => $type,
        ];
        $data->{'$ref'} = $name;

        if ($type === null) {
            unset($data->definitions->{$name . '_Entry'});

            $data->definitions->{$name}->properties->entry->items = (object) [
                'type' => 'any'
            ];
        }

        return SchemaSource::from($data);
    }
}
