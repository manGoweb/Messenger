<?php

use Mangoweb\Messenger\GetStartedButton;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$getStartedButton = GetStartedButton::payload('-custom-payload-');

Assert::equal([
	'setting_type' => 'call_to_actions',
	'thread_state' => 'new_thread',
	'call_to_actions' => [
		[ 'payload' => '-custom-payload-' ],
	],
], $getStartedButton->toSchema());

$getStartedButton = GetStartedButton::empty();

Assert::equal([
	'setting_type' => 'call_to_actions',
	'thread_state' => 'new_thread',
], $getStartedButton->toSchema());
