<?php

use Fusio\Worker;
use Fusio\Engine;
use Fusio\Form\Attribute as Form;
use Psr\Log\LoggerInterface;

return
#[Form\Action('action', 'Action', 'Action description')]
#[Form\Agent('agent', 'Agent', 'Agent description')]
#[Form\Checkbox('checkbox', 'Checkbox', 'Checkbox description')]
#[Form\Collection('collection', 'Collection', 'text', 'Collection description')]
#[Form\Connection('connection', 'Connection', 'Connection description')]
#[Form\Input('input', 'Input', 'text', 'Input description')]
#[Form\Map('map', 'Map', 'text', 'Map description')]
#[Form\Select('select', 'Select', ['foo' => 'Foo', 'bar' => 'Bar'], 'Select description')]
#[Form\TextArea('textarea', 'TextArea', 'json', 'TextArea description')]
#[Form\TypeAPI('typeapi', 'TypeAPI', 'TypeAPI description')]
#[Form\TypeSchema('typeschema', 'TypeSchema', 'TypeSchema description')]
function(Worker\ExecuteRequest $request, Worker\ExecuteContext $context, Engine\ConnectorInterface $connector, Engine\Response\FactoryInterface $response, Engine\DispatcherInterface $dispatcher, LoggerInterface $logger) {

};
