<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$message = Message::generic([ CardElement::create('title', 'subtitle', 'itemUrl', 'imageUrl', [ Button::url('Button', 'url')]) ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'generic',
			'elements' => [[
				'title' => 'title',
				'subtitle' => 'subtitle',
				'item_url' => 'itemUrl',
				'image_url' => 'imageUrl',
				'buttons' => [[
					'type' => 'web_url',
					'title' => 'Button',
					'url' => 'url'
				]]
			]]
		]
	]
], $message->toSchema());

$message = Message::generic([ CardElement::create('Lorem', 'ipsum dolor', NULL, NULL, [ Button::postback('Button', 'test'), Button::url('Button', 'url') ]) ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'generic',
			'elements' => [[
				'title' => 'Lorem',
				'subtitle' => 'ipsum dolor',
				'buttons' => [[
					'type' => 'postback',
					'title' => 'Button',
					'payload' => 'test'
				],
				[
					'type' => 'web_url',
					'title' => 'Button',
					'url' => 'url'
				]]
			]]
		]
	]
], $message->toSchema());

