<?php

use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$card = new CardElement;

$card->title = 'foobar';

Assert::equal([ 'title' => 'foobar' ], $card->toSchema());

$card->imageUrl = 'foobar.jpg';

Assert::equal([ 'title' => 'foobar', 'image_url' => 'foobar.jpg' ], $card->toSchema());

$withButtons = new CardElement;

$urlButton = new Button;
$urlButton->type = Button::TYPE_WEB_URL;
$urlButton->title = 'Website';
$urlButton->url = 'https://fb.com/';
$withButtons->buttons[] = $urlButton;

Assert::equal([ 'buttons' => [
	[ 'type' => 'web_url', 'title' => 'Website', 'url' => 'https://fb.com/' ]
] ], $withButtons->toSchema());

$postbackButton = new Button;
$postbackButton->type = Button::TYPE_POSTBACK;
$postbackButton->title = 'Postback';
$postbackButton->payload = [ 'foo' => 'bar' ];
$withButtons->buttons[] = $postbackButton;

Assert::equal([ 'buttons' => [
	[ 'type' => 'web_url', 'title' => 'Website', 'url' => 'https://fb.com/' ],
	[ 'type' => 'postback', 'title' => 'Postback', 'payload' => '{"foo":"bar"}' ],
] ], $withButtons->toSchema());
