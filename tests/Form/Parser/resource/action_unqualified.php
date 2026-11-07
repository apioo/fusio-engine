<?php

use Fusio\Worker;
use Fusio\Engine;
use Psr\Log\LoggerInterface;

return
#[Action('action', 'Action', 'Action description')]
#[Agent('agent', 'Agent', 'Agent description')]
#[Checkbox('checkbox', 'Checkbox', 'Checkbox description')]
#[Collection('collection', 'Collection', 'text', 'Collection description')]
#[Connection('connection', 'Connection', 'Connection description')]
#[Input('input', 'Input', 'text', 'Input description')]
#[Map('map', 'Map', 'text', 'Map description')]
#[Select('select', 'Select', ['foo' => 'Foo', 'bar' => 'Bar'], 'Select description')]
#[TextArea('textarea', 'TextArea', 'json', 'TextArea description')]
#[TypeAPI('typeapi', 'TypeAPI', 'TypeAPI description')]
#[TypeSchema('typeschema', 'TypeSchema', 'TypeSchema description')]
function(Worker\ExecuteRequest $request, Worker\ExecuteContext $context, Engine\ConnectorInterface $connector, Engine\Response\FactoryInterface $response, Engine\DispatcherInterface $dispatcher, LoggerInterface $logger) {

};
