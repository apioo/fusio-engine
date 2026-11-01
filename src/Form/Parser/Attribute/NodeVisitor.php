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

namespace Fusio\Engine\Form\Parser\Attribute;

use Fusio\Engine\Form\BuilderInterface;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Model\Common\FormElement;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * NodeVisitor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 * @internal
 */
class NodeVisitor extends NodeVisitorAbstract
{
    public function __construct(private BuilderInterface $builder, private ElementFactoryInterface $elementFactory)
    {
    }

    public function enterNode(Node $node): void
    {
        if (!$node instanceof Node\AttributeGroup) {
            return;
        }

        foreach ($node->attrs as $attr) {
            $name = $attr->name->toString();
            if (str_contains($name, '\\')) {
                $name = substr(strstr($name, '\\'), 1);
            }

            $arguments = [];
            foreach ($attr->args as $arg) {
                $arguments[] = $this->parseNodeValue($arg->value);
            }

            $methodName = 'new' . $name;
            $callable = [$this->elementFactory, $methodName];
            if (!is_callable($callable)) {
                continue;
            }

            $element = call_user_func_array($callable, $arguments);
            if (!$element instanceof FormElement) {
                continue;
            }

            $this->builder->add($element);
        }
    }

    private function parseNodeValue(Node $node): mixed
    {
        if ($node instanceof Node\Scalar\String_ || $node instanceof Node\Scalar\Int_ || $node instanceof Node\Scalar\Float_) {
            return $node->value;
        } elseif ($node instanceof Node\Expr\Array_) {
            $array = [];
            foreach ($node->items as $item) {
                if ($item === null) {
                    continue;
                }

                $value = $this->parseNodeValue($item->value);
                if ($item->key !== null) {
                    $key = $this->parseNodeValue($item->key);
                    $array[$key] = $value;
                } else {
                    $array[] = $value;
                }
            }
            return $array;
        } elseif ($node instanceof Node\Expr\ConstFetch) {
            $name = strtolower($node->name->toString());
            return match ($name) {
                'null' => null,
                'true' => true,
                'false' => false,
                default => $name,
            };
        }

        return null;
    }
}