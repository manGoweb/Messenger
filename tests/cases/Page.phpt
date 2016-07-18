<?php

use Mangoweb\Messenger\Page;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

if(defined('TEST_PAGE_ACCESS_TOKEN')) {
	$page = new Page(TEST_PAGE_ACCESS_TOKEN);

	Assert::true($page->isHookedToApp(TEST_HOOKED_APP_ID));

	$info = $page->loadInfo();
	Assert::equal(TEST_PAGE_NAME, $info['name']);

	$profile = $page->loadProfile(TEST_RECIPIENT_ID);
	Assert::equal(TEST_RECIPIENT_FIRST_NAME, $profile['first_name']);
	Assert::equal(TEST_RECIPIENT_LAST_NAME, $profile['last_name']);
} else {
	Tester\Environment::skip('Test requires defined constants `TEST_PAGE_ACCESS_TOKEN`.');
}

