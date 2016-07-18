<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$message = Message::buttons('choose a button', [ Button::url('Facebook', 'https://fb.com/') ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'button',
			'text' => 'choose a button',
			'buttons' => [[
				'type' => 'web_url',
				'title' => 'Facebook',
				'url' => 'https://fb.com/'
			]]
		]
	]
], $message->toSchema());

$message = Message::buttons('choose from more buttons', [ Button::url('First', 'https://fb.com/'), Button::url('Second', 'https://fb.com/') ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'button',
			'text' => 'choose from more buttons',
			'buttons' => [[
				'type' => 'web_url',
				'title' => 'First',
				'url' => 'https://fb.com/'
			],
			[
				'type' => 'web_url',
				'title' => 'Second',
				'url' => 'https://fb.com/'
			]]
		]
	]
], $message->toSchema());

$message = Message::buttons('choose an action', [ Button::postback('Postback', 'test') ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'button',
			'text' => 'choose an action',
			'buttons' => [[
				'type' => 'postback',
				'title' => 'Postback',
				'payload' => 'test'
			]]
		]
	]
], $message->toSchema());

$message = Message::buttons('choose a complex action', [ Button::postback('Postback', [ 'id' => 42, 'secret' => 'the cake is a like' ]) ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'button',
			'text' => 'choose a complex action',
			'buttons' => [[
				'type' => 'postback',
				'title' => 'Postback',
				'payload' => '{"id":42,"secret":"the cake is a like"}'
			]]
		]
	]
], $message->toSchema());
