<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

/**
 * Helper script to generate the API documentation which is used at the website
 * to describe the existing API
 */

require_once __DIR__ . '/../vendor/autoload.php';

use PhpParser\ParserFactory;

$env = [
    'request' => \Fusio\Engine\RequestInterface::class,
    'parameters' => \Fusio\Engine\ParametersInterface::class,
    'context' => \Fusio\Engine\ContextInterface::class,
    'connector' => \Fusio\Engine\ConnectorInterface::class,
    'response' => \Fusio\Engine\Response\FactoryInterface::class,
    'processor' => \Fusio\Engine\ProcessorInterface::class,
    'dispatcher' => \Fusio\Engine\DispatcherInterface::class,
    'logger' => \Psr\Log\LoggerInterface::class,
    'cache' => \Psr\SimpleCache\CacheInterface::class,
];

$yaml = [
    'api' => [],
];

foreach ($env as $name => $class) {

    $ast = parseClass($class);
    $doc = getDoc($name, $class, $ast);

    $methods = $doc->getMethods();
    $result = [];
    
    foreach ($methods as $method) {
        $params = $method->getDoc()->getParams();

        $row = [
            'description' => $method->getDoc()->getText(),
        ];

        if (isset($params['@return'])) {
            $row['return'] = parseReturn($params['@return']);
        }

        if (isset($params['@param'])) {
            $row['arguments'] = parseArguments($params['@param']);
        }

        $result[$method->getName()] = $row;
    }

    $yaml['api']['$' . $name] = [
        'description' => $doc->getDoc()->getText(),
        'visible' => true,
        'methods' => $result,
    ];
}

$data = \Symfony\Component\Yaml\Yaml::dump($yaml, 16);

file_put_contents(__DIR__ . '/php_v1.yaml', $data);


function parseReturn(array $params)
{
    $return = array_shift($params);

    if (strpos($return, ' ') !== false) {
        $type = strstr($return, ' ', true);
        $desc = trim(strstr($return, ' '));
    } else {
        $type = $return;
        $desc = null;
    }

    $result = [
        'type' => $type,
    ];

    if (!empty($desc)) {
        $result['description'] = $desc;
    }

    return $result;
}

function parseArguments(array $params)
{
    $result = [];

    foreach ($params as $param) {

        $parts = array_values(array_filter(explode(' ', $param)));

        $type = array_shift($parts);
        $name = array_shift($parts);
        $desc = implode(' ', $parts);

        $argument = [
            'name' => $name,
        ];

        if (!empty($type)) {
            $argument['type'] = $type;
        }
        
        if (!empty($desc)) {
            $argument['description'] = $desc;
        }

        $result[] = $argument;
    }

    return $result;
}

function parseClass($class)
{
    $reflection = new ReflectionClass($class);
    $code = file_get_contents($reflection->getFileName());

    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    return $parser->parse($code);
}

/**
 * @param array $ast
 * @return ClassDoc
 */
function getDoc($name, $class, $ast)
{
    /** @var \PhpParser\Node\Stmt\Namespace_ $namespace */
    $namespace = $ast[0];

    /** @var \PhpParser\Node\Stmt\Interface_ $interface */
    $interface = null;
    foreach ($namespace->stmts as $stmt) {
        if ($stmt instanceof \PhpParser\Node\Stmt\Interface_) {
            $interface = $stmt;
            break;
        }
    }

    if (empty($interface)) {
        throw new \RuntimeException('Could not find interface');
    }

    $doc = new ClassDoc($name, $class, getDocComment($interface));

    /** @var PhpParser\Node\Stmt\ClassMethod[] $methods */
    $methods = $interface->stmts;
    
    foreach ($methods as $method) {
        $doc->addMethod(new MethodsDoc($method->name, getDocComment($method)));
    }

    return $doc;
}

function getDocComment(\PhpParser\Node $node)
{
    $comments = $node->getAttribute('comments');
    /** @var \PhpParser\Comment\Doc $comment */
    $comment = $comments[0];

    if ($comment instanceof \PhpParser\Comment\Doc) {
        return parseDoc($comment->getText());
    }

    return new DocBlock("", []);
}

function parseDoc($doc)
{
    $doc = str_replace(["\r\n", "\n", "\r"], "\n", $doc);
    $lines = explode("\n", $doc);
    
    // remove first and last line
    array_pop($lines);
    array_shift($lines);

    $text = [];
    $params = [];
    foreach ($lines as $line) {
        $line = substr(trim($line), 2);
        
        if (empty($line)) {
            continue;
        }

        if ($line[0] == '@') {
            $key = strstr($line, ' ', true);
            $value = trim(strstr($line, ' '));

            if (!isset($params[$key])) {
                $params[$key] = [];
            }

            $params[$key][] = $value;
        } else {
            $text[] = $line;
        }
    }

    return new DocBlock(implode("\n", $text), $params);
}

class ClassDoc
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var DocBlock
     */
    protected $doc;

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @param string $class
     * @param DocBlock $doc
     */
    public function __construct($name, $class, DocBlock $doc)
    {
        $this->name = $name;
        $this->class = $class;
        $this->doc = $doc;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return DocBlock
     */
    public function getDoc(): DocBlock
    {
        return $this->doc;
    }

    /**
     * @return MethodsDoc[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param MethodsDoc $method
     */
    public function addMethod(MethodsDoc $method)
    {
        $this->methods[] = $method;
    }
}

class MethodsDoc
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var DocBlock
     */
    protected $doc;

    /**
     * @param string $name
     * @param DocBlock $doc
     */
    public function __construct($name, DocBlock $doc)
    {
        $this->name = $name;
        $this->doc = $doc;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DocBlock
     */
    public function getDoc(): DocBlock
    {
        return $this->doc;
    }
}

class DocBlock
{
    protected $text;
    protected $params;
    
    public function __construct($text, array $params)
    {
        $this->text = $text;
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}


