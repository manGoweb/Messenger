<?php

use Mangoweb\Messenger\Message;
use Mangoweb\Messenger\SenderAction;
use Mangoweb\Messenger\TestSender;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$sender = new TestSender();

$sender->send(123, Message::text('foo'));

$old = '';

Assert::equal($old .=
'{
    "recipient": {
        "id": 123
    },
    "message": {
        "text": "foo"
    }
}
', $sender->getOutput());

$sender->send(123, SenderAction::seen());

Assert::equal($old .=
'{
    "recipient": {
        "id": 123
    },
    "sender_action": "mark_seen"
}
', $sender->getOutput());

$sender->send(123, Message::text('bar'));

Assert::equal($old .=
'{
    "recipient": {
        "id": 123
    },
    "message": {
        "text": "bar"
    }
}
', $sender->getOutput());
