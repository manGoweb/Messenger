<?php

use Mangoweb\Messenger\Utils;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$customToken = '-correct-token-';

Assert::false(Utils::verifyWebhook($customToken, []));

Assert::false(Utils::verifyWebhook($customToken, [ 'foo' => 'bar' ]));

Assert::false(Utils::verifyWebhook($customToken, [ 'hub_verify_token' => '-incorrect-token-' ]));

Assert::false(Utils::verifyWebhook($customToken, [ 'hub_verify_token' => '-incorrect-token-', 'hub_challenge' => '-token-to-return-' ]));

Assert::equal('-token-to-return-', Utils::verifyWebhook($customToken, [ 'hub_verify_token' => '-correct-token-', 'hub_challenge' => '-token-to-return-' ]));
