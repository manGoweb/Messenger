<?php

use Mangoweb\Messenger\Utils;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

Assert::true(Utils::inLength('abc', 10));
Assert::true(Utils::inLength('abc', 5));
Assert::true(Utils::inLength('abc', 3));

Assert::false(Utils::inLength('abc', 2));
Assert::false(Utils::inLength('abc', 1));
Assert::false(Utils::inLength('abc', 0));

Assert::true(Utils::inArray('abc', [ 'abc' ]));

Assert::true(Utils::inArray('abc', [ 'def', 'abc' ]));

Assert::false(Utils::inArray('abc', [ 'foo', 'bar' ]));

Assert::false(Utils::inArray('abc', []));

Assert::false(Utils::inArray('42', [ 42 ]));

Assert::true(Utils::inArray('42', [ 42 ], TRUE));
Assert::false(Utils::inArray('42', [ 43 ], TRUE));
