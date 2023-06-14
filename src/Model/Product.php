<?php
/*
 * Fusio is an open source API management platform which helps to create innovative API solutions.
 * For the current version and information visit <https://www.fusio-project.org/>
 *
 * Copyright 2015-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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
    private float $price;
    private int $points;
    private int $interval;
    private ?string $externalId;

    public function __construct(int $id, string $name, float $price, int $points, int $interval, ?string $externalId = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->points = $points;
        $this->interval = $interval;
        $this->externalId = $externalId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
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
}
