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

namespace Fusio\Engine\Processor;

use Fusio\Engine\ContextInterface;
use Fusio\Engine\RequestInterface;

/**
 * ExecutionStack
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://www.fusio-project.org
 */
class ExecutionStack implements ExecutionStackInterface, ExecutionStateInterface
{
    private const KEY_ACTION = 0;
    private const KEY_REQUEST = 1;
    private const KEY_CONTEXT = 2;

    private array $stack = [];

    public function push(string|int $actionId, RequestInterface $request, ContextInterface $context): void
    {
        $this->stack[] = [
            self::KEY_ACTION => $actionId,
            self::KEY_REQUEST => $request,
            self::KEY_CONTEXT => $context
        ];
    }

    public function pop(): void
    {
        array_pop($this->stack);
    }

    public function getCurrentAction(): string|int|null
    {
        return $this->getCurrent(self::KEY_ACTION);
    }

    public function getCurrentRequest(): ?RequestInterface
    {
        return $this->getCurrent(self::KEY_REQUEST);
    }

    public function getCurrentContext(): ?ContextInterface
    {
        return $this->getCurrent(self::KEY_CONTEXT);
    }

    private function getCurrent(int $index): mixed
    {
        $lastKey = array_key_last($this->stack);
        if ($lastKey === null) {
            return null;
        }

        return $this->stack[$lastKey][$index] ?? null;
    }
}
