<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$message = Message::file('path/to/file.pdf');
Assert::equal([
	'attachment' => [
		'type' => 'file',
		'payload' => [
			'url' => 'path/to/file.pdf'
		]
	]
], $message->toSchema());

$message = Message::image('path/to/image.jpg');
Assert::equal([
	'attachment' => [
		'type' => 'image',
		'payload' => [
			'url' => 'path/to/image.jpg'
		]
	]
], $message->toSchema());

$message = Message::audio('path/to/audio.mp3');
Assert::equal([
	'attachment' => [
		'type' => 'audio',
		'payload' => [
			'url' => 'path/to/audio.mp3'
		]
	]
], $message->toSchema());

$message = Message::video('path/to/video.mp4');
Assert::equal([
	'attachment' => [
		'type' => 'video',
		'payload' => [
			'url' => 'path/to/video.mp4'
		]
	]
], $message->toSchema());

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
