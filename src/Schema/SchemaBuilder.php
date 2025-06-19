<?php
/*
 * Fusio - Self-Hosted API Management for Builders.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Schema;

use Fusio\Model\Backend\OperationParameters;
use Fusio\Model\Backend\OperationSchema;
use Fusio\Model\Backend\SchemaSource;

/**
 * SchemaBuilder
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
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
                        'type' => 'integer',
                    ],
                    'itemsPerPage' => (object) [
                        'type' => 'integer',
                    ],
                    'startIndex' => (object) [
                        'type' => 'integer',
                    ],
                    'entry' => (object) [
                        'type' => 'array',
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
