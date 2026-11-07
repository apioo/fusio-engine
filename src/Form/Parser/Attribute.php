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

namespace Fusio\Engine\Form\Parser;

use Fusio\Engine\Form\Builder;
use Fusio\Engine\Form\Container;
use Fusio\Engine\Form\ElementFactoryInterface;
use Fusio\Engine\Form\Parser\Attribute\NodeVisitor;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use Throwable;

/**
 * Attribute
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
readonly class Attribute
{
    public function __construct(private ElementFactoryInterface $elementFactory)
    {
    }

    public function parse(string $code): ?Container
    {
        try {
            $parser = new ParserFactory()->createForNewestSupportedVersion();
            $ast = $parser->parse($code);
            if ($ast === null) {
                return null;
            }

            $builder = new Builder();

            $traverser = new NodeTraverser();
            $traverser->addVisitor(new NodeVisitor($builder, $this->elementFactory));
            $traverser->traverse($ast);

            $form = $builder->getForm();
            if (count($form->getElements()) === 0) {
                return null;
            }

            return $form;
        } catch (Throwable) {
            return null;
        }
    }
}
