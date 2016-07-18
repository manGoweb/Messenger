<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\TestSender;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$sender = new TestSender();
$message = new Message();

$sender->send($message);

Assert::equal("[]\n", $sender->getOutput());

$sender->send($message);

Assert::equal("[]\n[]\n", $sender->getOutput());
