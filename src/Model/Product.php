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

namespace Fusio\Engine\Model;

/**
 * Product
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class Product implements ProductInterface
{
    private int $id;
    private string $name;
    private int $price;
    private int $points;
    private int $interval;
    private ?string $externalId;
    private ?\stdClass $metadata;

    public function __construct(int $id, string $name, int $price, int $points, int $interval, ?string $externalId = null, ?\stdClass $metadata = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->points = $points;
        $this->interval = $interval;
        $this->externalId = $externalId;
        $this->metadata = $metadata;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function getMetadata(string $key): mixed
    {
        return $this->metadata?->{$key} ?? null;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'points' => $this->points,
            'interval' => $this->interval,
            'externalId' => $this->externalId,
            'metadata' => $this->metadata,
        ];
    }
}
