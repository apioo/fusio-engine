<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2016 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace Fusio\Engine\Template\Parser;

use Fusio\Engine\ContextInterface;
use Fusio\Engine\RequestInterface;
use Fusio\Engine\Template\Extension;
use Fusio\Engine\Template\ParserInterface;
use Fusio\Engine\Template\StackLoader;
use PSX\Data\Accessor;
use PSX\Validate\Validate;

/**
 * BaseAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
abstract class BaseAbstract implements ParserInterface
{
    /**
     * @var \Fusio\Engine\Template\StackLoader
     */
    protected $loader;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var null|string
     */
    protected $cacheKey;

    /**
     * @param boolean $debug
     * @param string|false|\Twig_CacheInterface $cache
     * @param string|null $cacheKey
     */
    public function __construct($debug, $cache, $cacheKey = null)
    {
        $this->loader = new StackLoader();
        $this->twig   = new \Twig_Environment($this->loader, [
            'debug'            => $debug,
            'cache'            => $cache,
            'autoescape'       => false,
            'strict_variables' => false,
        ]);

        $extensions = $this->twig->getExtensions();
        foreach ($extensions as $name => $extension) {
            $this->twig->removeExtension($name);
        }

        $this->twig->addExtension($this->getExtension());

        $this->cacheKey = $cacheKey;
    }

    /**
     * @param \Fusio\Engine\RequestInterface $request
     * @param \Fusio\Engine\ContextInterface $context
     * @param string $template
     * @return string
     * @throws \Exception
     * @throws \Twig_Error_Runtime
     */
    public function parse(RequestInterface $request, ContextInterface $context, $template)
    {
        $cacheKey     = $context->getAction()->getId();
        $lastModified = $context->getAction()->getDate();

        if ($this->cacheKey !== null) {
            $cacheKey.= '_' . $this->cacheKey;
        }

        $this->loader->set($template, $cacheKey, $lastModified);

        try {
            return $this->twig->render($cacheKey, [
                'request' => $request,
                'context' => $context,
                'body'    => new Accessor(new Validate(), $request->getBody()),
            ]);
        } catch (\Twig_Error_Runtime $e) {
            // throw the original exception if available
            if ($e->getPrevious() instanceof \Exception) {
                throw $e->getPrevious();
            } else {
                throw $e;
            }
        }
    }

    /**
     * Returns the used twig extension
     *
     * @return \Twig_Extension
     */
    abstract protected function getExtension();
}
