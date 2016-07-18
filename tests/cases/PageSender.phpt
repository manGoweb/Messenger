<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Mangoweb\Messenger\QuickReply;
use Mangoweb\Messenger\Page;
use Mangoweb\Messenger\PageSender;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

if(defined('TEST_PAGE_ACCESS_TOKEN')) {
	$page = new Page(TEST_PAGE_ACCESS_TOKEN);
	$sender = new PageSender($page);

	$res = $sender->send(TEST_RECIPIENT_ID, Message::image('https://unsplash.it/400/300?random'));
	Assert::true($res);

	$res = $sender->send(TEST_RECIPIENT_ID, Message::generic([
		CardElement::create('Lorem', 'ipsum dolor', 'https://github.com/manGoweb/Messenger', 'https://unsplash.it/400/300?random', [
			Button::url('Github', 'https://github.com/manGoweb/Messenger')
		]),
		CardElement::create('Foo', NULL, NULL, 'https://unsplash.it/400/300?random')
	]));
	Assert::true($res);

	$message = Message::text('Message with quick replies.');
	$message->quickReplies = [ QuickReply::text('first'), QuickReply::text('second') ];
	$res = $sender->send(TEST_RECIPIENT_ID, $message);
	Assert::true($res);
} else {
	Tester\Environment::skip('Test requires defined constants `TEST_PAGE_ACCESS_TOKEN` and `TEST_RECIPIENT_ID`.');
}

