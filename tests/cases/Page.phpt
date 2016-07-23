<?php

use Mangoweb\Messenger\Page;
use Mangoweb\Messenger\Greeting;
use Mangoweb\Messenger\GetStartedButton;
use Mangoweb\Messenger\PersistentMenu;
use Mangoweb\Messenger\Button;
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

	$res = $page->setGreeting(Greeting::text('Hello world'));
	Assert::true($res);

	$res = $page->setGetStartedButton(GetStartedButton::payload('1'));
	Assert::true($res);

	$res = $page->setPersistentMenu(PersistentMenu::buttons([
		Button::postback('Help', 'help'),
		Button::postback('Sign in', 'sign-in'),
	]));
	Assert::true($res);

} else {
	Tester\Environment::skip('Test requires defined constants `TEST_PAGE_ACCESS_TOKEN`.');
}

