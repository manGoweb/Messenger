<?php

use Mangoweb\Messenger\CloseUrl;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$url = new CloseUrl('image.jpg', 'my message');
Assert::equal('https://www.messenger.com/closeWindow/?image_url=image.jpg&display_text=my%20message', (string)$url);

$url = new CloseUrl('foo', 'bar');
Assert::equal('https://www.messenger.com/closeWindow/?image_url=foo&display_text=bar', (string)$url);
