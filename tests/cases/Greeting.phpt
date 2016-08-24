<?php

use Mangoweb\Messenger\Greeting;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$greeting = Greeting::text('Hello world');

Assert::equal([
	'setting_type' => 'greeting',
	'greeting' => [
		'text' => 'Hello world',
	],
], $greeting->toSchema());

Assert::exception(function() {
	$tooLongString = str_repeat('x', 200);
	Greeting::text($tooLongString);
}, 'Nette\Utils\AssertionException', "The text should be shorter than 160, is 200.");
