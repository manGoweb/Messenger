<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$message = Message::text('hello friend!');
Assert::equal([
	'text' => 'hello friend!'
], $message->toSchema());
