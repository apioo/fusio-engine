<?php

namespace Fusio\Engine\Tests\Parser\Foo\Bar\Baz;

use Fusio\Engine\ActionAbstract;
use Fusio\Engine\ContextInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\RequestInterface;

class Baz extends ActionAbstract
{
    public function handle(RequestInterface $request, ParametersInterface $configuration, ContextInterface $context)
    {
        // TODO: Implement handle() method.
    }
}

