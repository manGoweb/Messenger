<?php

use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$button = Button::url('title', 'https://fb.com/');

Assert::equal([
	'type' => 'web_url',
	'title' => 'title',
	'url' => 'https://fb.com/'
], $button->toSchema());

Assert::exception(function() {
	Button::url('title', 'invalid url');
}, 'Nette\Utils\AssertionException', "The url expects to be url, string 'invalid url' given.");

$button = Button::postback('title', 'xxxxxxxxxx');

Assert::equal([
	'type' => 'postback',
	'title' => 'title',
	'payload' => 'xxxxxxxxxx'
], $button->toSchema());

Assert::exception(function() {
	$longString = str_repeat('x', 1100);
	Button::postback('title', $longString);
}, 'Nette\Utils\AssertionException', "The payload should be shorter than 1000, is 1100.");

$button = Button::accountLink('title', 'https://fb.com/');

Assert::equal([
	'type' => 'account_link',
	'title' => 'title',
	'url' => 'https://fb.com/'
], $button->toSchema());

Assert::exception(function() {
	Button::accountLink('title', 'invalid url');
}, 'Nette\Utils\AssertionException', "The url expects to be url, string 'invalid url' given.");

$button = Button::accountUnlink('title');

Assert::equal([
	'type' => 'account_unlink',
	'title' => 'title',
], $button->toSchema());

$button = Button::postback('title', 'xxxxxxxxxx');

$button = Button::phone('title', '+420739123456');

Assert::equal([
	'type' => 'phone_number',
	'title' => 'title',
	'payload' => '+420739123456'
], $button->toSchema());

Assert::exception(function() {
	Button::phone('title', '123456789');
}, 'Nette\Utils\AssertionException', "The phoneNumber expects to be pattern in range \+[0-9]{6,15}, string '123456789' given.");

Assert::exception(function() {
	Button::phone('title', '+1');
}, 'Nette\Utils\AssertionException', "The phoneNumber expects to be pattern in range \+[0-9]{6,15}, string '+1' given.");

Assert::exception(function() {
	Button::phone('title', '+abcdefghi');
}, 'Nette\Utils\AssertionException', "The phoneNumber expects to be pattern in range \+[0-9]{6,15}, string '+abcdefghi' given.");
