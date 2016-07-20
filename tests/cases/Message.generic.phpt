<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$message = Message::generic([ CardElement::create('title', 'subtitle', 'https://fb.com/', 'https://unsplash.it/800/600', [ Button::url('Button', 'https://fb.com/')]) ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'generic',
			'elements' => [[
				'title' => 'title',
				'subtitle' => 'subtitle',
				'item_url' => 'https://fb.com/',
				'image_url' => 'https://unsplash.it/800/600',
				'buttons' => [[
					'type' => 'web_url',
					'title' => 'Button',
					'url' => 'https://fb.com/'
				]]
			]]
		]
	]
], $message->toSchema());

$message = Message::generic([ CardElement::create('Lorem', 'ipsum dolor', NULL, NULL, [ Button::postback('Button', 'test'), Button::url('Button', 'https://fb.com/') ]) ]);
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
					'url' => 'https://fb.com/'
				]]
			]]
		]
	]
], $message->toSchema());

