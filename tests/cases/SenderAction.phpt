<?php

use Mangoweb\Messenger\SenderAction;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


Assert::equal('mark_seen', (SenderAction::seen())->toSchema());

Assert::equal('typing_on', (SenderAction::typing(TRUE))->toSchema());

Assert::equal('typing_off', (SenderAction::typing(FALSE))->toSchema());
