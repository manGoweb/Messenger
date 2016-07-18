<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\QuickReply;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$message = Message::text('foo');
$message->quickReplies = [ QuickReply::text('foo', 'bar') ];
Assert::equal([
	'text' => 'foo',
	'quick_replies' => [
		[ 'content_type' => 'text', 'title' => 'foo', 'payload' => 'bar' ]
	]
], $message->toSchema());

$message = Message::text('foo');
$message->quickReplies = [ QuickReply::text('foo', '456'), QuickReply::text('bar', '123') ];
Assert::equal([
	'text' => 'foo',
	'quick_replies' => [
		[ 'content_type' => 'text', 'title' => 'foo', 'payload' => '456' ],
		[ 'content_type' => 'text', 'title' => 'bar', 'payload' => '123' ],
	]
], $message->toSchema());
