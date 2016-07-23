<?php

use Mangoweb\Messenger\PersistentMenu;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$menu = PersistentMenu::empty();

Assert::equal([
	'setting_type' => 'call_to_actions',
	'thread_state' => 'existing_thread',
], $menu->toSchema());

$menu = PersistentMenu::buttons([
	Button::postback('Help', 'DEVELOPER_DEFINED_PAYLOAD_FOR_HELP')
]);

Assert::equal([
	'setting_type' => 'call_to_actions',
	'thread_state' => 'existing_thread',
	'call_to_actions' => [
		[
			'type' => 'postback',
			'title' => 'Help',
			'payload' => 'DEVELOPER_DEFINED_PAYLOAD_FOR_HELP',
		]
	],
], $menu->toSchema());

$menu = PersistentMenu::buttons([
	Button::postback('Help', 'DEVELOPER_DEFINED_PAYLOAD_FOR_HELP'),
	Button::url('Web', 'https://fb.com/'),
	Button::postback('Sign in', 'DEVELOPER_DEFINED_PAYLOAD_FOR_SIGN_IN'),
]);

Assert::equal([
	'setting_type' => 'call_to_actions',
	'thread_state' => 'existing_thread',
	'call_to_actions' => [
		[
			'type' => 'postback',
			'title' => 'Help',
			'payload' => 'DEVELOPER_DEFINED_PAYLOAD_FOR_HELP',
		],
		[
			'type' => 'web_url',
			'title' => 'Web',
			'url' => 'https://fb.com/',
		],
		[
			'type' => 'postback',
			'title' => 'Sign in',
			'payload' => 'DEVELOPER_DEFINED_PAYLOAD_FOR_SIGN_IN',
		],
	],
], $menu->toSchema());

Assert::exception(function() {
	$menu = PersistentMenu::buttons([
		Button::postback('1', '-'),
		Button::postback('2', '-'),
		Button::postback('3', '-'),
		Button::postback('4', '-')
	]);
}, 'Nette\Utils\AssertionException', "The buttons count cannot be more than 3.");
