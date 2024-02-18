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

namespace Fusio\Engine\Provider;

use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\Exception\NotFoundException;
use Fusio\Engine\Form;
use Fusio\Engine\Inflection\ClassName;

/**
 * ProviderAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
abstract class ProviderAbstract implements ProviderInterface
{
    private Form\ElementFactoryInterface $elementFactory;
    private iterable $objects;

    public function __construct(Form\ElementFactoryInterface $elementFactory, iterable $objects)
    {
        $this->elementFactory = $elementFactory;
        $this->objects = $objects;
    }

    public function getClasses(?array $excludeClasses = null): array
    {
        $result = [];
        foreach ($this->objects as $object) {
            if ($excludeClasses !== null && in_array($object::class, $excludeClasses)) {
                continue;
            }

            if ($object instanceof ConfigurableInterface) {
                $result[] = [
                    'name'  => $object->getName(),
                    'class' => ClassName::serialize($object::class),
                ];
            }
        }

        usort($result, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $result;
    }

    public function getForm(string $name): ?Form\Container
    {
        $object = $this->getInstance($name);

        if ($object instanceof ConfigurableInterface) {
            $builder = new Form\Builder();

            $object->configure($builder, $this->elementFactory);

            return $builder->getForm();
        }

        return null;
    }

    public function getInstance(string $name): ?object
    {
        foreach ($this->objects as $object) {
            if ($object::class === $name) {
                return $object;
            } elseif (ClassName::serialize($object::class) === $name) {
                return $object;
            } elseif (strcasecmp($this->shortName($object::class), $name) === 0) {
                return $object;
            }
        }

        throw new NotFoundException('Could not found provider: ' . $name);
    }

    /**
     * @param class-string $class
     */
    private function shortName(string $class): string
    {
        return (new \ReflectionClass($class))->getShortName();
    }
}
