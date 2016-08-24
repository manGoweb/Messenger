<?php

use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::exception(function() {
	$longString = str_repeat('x', 100);
	CardElement::create($longString, 'subtitle', 'itemUrl', 'imageUrl', []);
}, 'Nette\Utils\AssertionException', "The title should be shorter than 80, is 100.");

Assert::exception(function() {
	$longString = str_repeat('x', 100);
	CardElement::create('title', $longString, 'itemUrl', 'imageUrl', []);
}, 'Nette\Utils\AssertionException', "The subtitle should be shorter than 80, is 100.");

Assert::exception(function() {
	$longString = str_repeat('x', 100);
	CardElement::create('title', 'subtitle', 'itemUrl', 'imageUrl', []);
}, 'Nette\Utils\AssertionException', "The itemUrl expects to be url, string 'itemUrl' given.");
