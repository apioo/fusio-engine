<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Model;

/**
 * Product
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
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
