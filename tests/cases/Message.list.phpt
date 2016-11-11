<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$message = Message::list([ CardElement::create('title', 'subtitle', 'https://fb.com/', 'https://unsplash.it/800/600', [ Button::url('Button', 'https://fb.com/') ]) ], [ Button::url('Global button', 'https://fb.com/') ], Message::TOP_ELEMENT_STYLE_LARGE);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'list',
			'top_element_style' => 'large',
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
			]],
			'buttons' => [[
				'type' => 'web_url',
				'title' => 'Global button',
				'url' => 'https://fb.com/'
			]]
		]
	]
], $message->toSchema());

$message = Message::list([ CardElement::create('Lorem', 'ipsum dolor', NULL, NULL, [ Button::postback('Button', 'test'), Button::url('Button', 'https://fb.com/') ]) ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'list',
			'top_element_style' => 'compact',
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

$message = Message::largeList([ CardElement::create('title', 'subtitle', 'https://fb.com/', 'https://unsplash.it/800/600', [ Button::url('Button', 'https://fb.com/') ]) ], [ Button::url('Global button', 'https://fb.com/') ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'list',
			'top_element_style' => 'large',
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
			]],
			'buttons' => [[
				'type' => 'web_url',
				'title' => 'Global button',
				'url' => 'https://fb.com/'
			]]
		]
	]
], $message->toSchema());

$message = Message::compactList([ CardElement::create('Lorem', 'ipsum dolor', NULL, NULL, [ Button::postback('Button', 'test'), Button::url('Button', 'https://fb.com/') ]) ]);
Assert::equal([
	'attachment' => [
		'type' => 'template',
		'payload' => [
			'template_type' => 'list',
			'top_element_style' => 'compact',
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

