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

namespace Fusio\Engine\Provider;

use Fusio\Engine\ConfigurableInterface;
use Fusio\Engine\Exception\NotFoundException;
use Fusio\Engine\ExcludedInterface;
use Fusio\Engine\Form;
use Fusio\Engine\Form\Parser\Json;
use Fusio\Engine\Inflection\ClassName;
use Fusio\Engine\Inflection\ClassShape;
use Fusio\Engine\Model\ClassModelInterface;
use Fusio\Engine\Model\ConfigModelInterface;
use Fusio\Engine\Model\ModelInterface;
use Fusio\Engine\Parameters;
use Fusio\Engine\Repository\RepositoryInterface;
use PSX\Http\Client\ClientInterface;
use PSX\Http\Client\GetRequest;
use ReflectionClass;

/**
 * ProviderAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 *
 * @template T of ModelInterface
 */
abstract class ProviderAbstract implements ProviderInterface
{
    private Form\ElementFactoryInterface $elementFactory;

    /**
     * @var iterable<object>
     */
    private iterable $objects;

    /**
     * @var RepositoryInterface<T>|null
     */
    private ?RepositoryInterface $repository;

    private ?ClientInterface $httpClient;

    /**
     * @param iterable<object> $objects
     * @param RepositoryInterface<T>|null $repository
     */
    public function __construct(Form\ElementFactoryInterface $elementFactory, iterable $objects, ?RepositoryInterface $repository = null, ?ClientInterface $httpClient = null)
    {
        $this->elementFactory = $elementFactory;
        $this->objects = $objects;
        $this->repository = $repository;
        $this->httpClient = $httpClient;
    }

    /**
     * @param list<string>|null $excludeClasses
     * @return list<array{name: string, class: string}>
     */
    public function getClasses(?array $excludeClasses = null): array
    {
        $result = [];
        foreach ($this->objects as $object) {
            if ($excludeClasses !== null && in_array($object::class, $excludeClasses)) {
                continue;
            }

            if (!$object instanceof ConfigurableInterface || $object instanceof ExcludedInterface) {
                continue;
            }

            $result[] = [
                'name'  => $object->getName(),
                'class' => ClassName::serialize($object::class),
            ];
        }

        usort($result, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $result;
    }

    public function getForm(string $name): ?Form\Container
    {
        $shape = ClassShape::fromString($name);

        return match ($shape) {
            ClassShape::PHP_CLASS => $this->resolveByClass($name),
            ClassShape::ENTITY_NAME => $this->resolveBySource($name),
            ClassShape::MARKETPLACE_ENTITY => $this->resolveByMarketplace($name),
        };
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

        throw new NotFoundException('Could not find provider: ' . $name);
    }

    /**
     * @param class-string $class
     */
    private function shortName(string $class): string
    {
        return (new ReflectionClass($class))->getShortName();
    }

    private function resolveByClass(string $name): ?Form\Container
    {
        $object = $this->getInstance($name);
        if (!$object instanceof ConfigurableInterface) {
            return null;
        }

        $builder = new Form\Builder();

        $object->configure($builder, $this->elementFactory);

        return $builder->getForm();
    }

    private function resolveBySource(string $name): ?Form\Container
    {
        if (!$this->repository instanceof RepositoryInterface) {
            return null;
        }

        $model = $this->repository->get($name);
        if (!($model instanceof ClassModelInterface && $model instanceof ConfigModelInterface)) {
            return null;
        }

        $object = $this->getInstance($model->getClass());
        if (!$object instanceof Form\SourceResolverInterface) {
            return null;
        }

        $source = $object->resolveFormSource(new Parameters($model->getConfig()));
        if (!$source instanceof Form\SourceInterface) {
            return null;
        }

        if ($source instanceof Form\Source\PhpCode) {
            return (new Form\Parser\Attribute($this->elementFactory))->parse($source->code);
        } elseif ($source instanceof Form\Source\Json) {
            return (new Form\Parser\Json($this->elementFactory))->parse($source->json);
        } elseif ($source instanceof Form\Source\Instance) {
            return $source->container;
        }

        return null;
    }

    private function resolveByMarketplace(string $name): ?Form\Container
    {
        $parts = explode('/', $name);
        $user = $parts[0] ?? null;
        $name = $parts[1] ?? null;

        if (empty($user) || !preg_match('/^[a-zA-Z0-9\\-\\_\\.]{3,255}$/', $user)) {
            return null;
        }

        if (empty($name) || !preg_match('/^[a-zA-Z0-9\\-\\_]{3,255}$/', $name)) {
            return null;
        }

        if (!$this->httpClient instanceof ClientInterface) {
            return null;
        }

        $response = $this->httpClient->request(new GetRequest(sprintf('https://api.fusio-project.org/marketplace/directory/action/%s/%s', $user, $name)));
        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $body = (string) $response->getBody();

        return (new Json($this->elementFactory))->parse($body);
    }
}
