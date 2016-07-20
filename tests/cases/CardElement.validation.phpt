<?php

use Mangoweb\Messenger\CardElement;
use Mangoweb\Messenger\Button;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::exception(function() {
	$longString = str_repeat('x', 100);
	CardElement::create($longString, 'subtitle', 'itemUrl', 'imageUrl', []);
}, 'Nette\Utils\AssertionException', "The title expects to be string in range 1..80, string given.");

Assert::exception(function() {
	$longString = str_repeat('x', 100);
	CardElement::create('title', $longString, 'itemUrl', 'imageUrl', []);
}, 'Nette\Utils\AssertionException', "The subtitle expects to be string in range 1..80, string given.");

Assert::exception(function() {
	$longString = str_repeat('x', 100);
	CardElement::create('title', 'subtitle', 'itemUrl', 'imageUrl', []);
}, 'Nette\Utils\AssertionException', "The itemUrl expects to be url, string 'itemUrl' given.");
