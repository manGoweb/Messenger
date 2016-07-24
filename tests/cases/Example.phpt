<?php
use Tester\Assert;

use Nette\Utils\Strings;

require __DIR__ . '/../bootstrap.php';

if(defined('TEST_PAGE_ACCESS_TOKEN')) {

	define('PAGE_ACCESS_TOKEN', TEST_PAGE_ACCESS_TOKEN);
	define('RECIPIENT_ID', TEST_RECIPIENT_ID);
	define('APP_ID', TEST_HOOKED_APP_ID);

	$readme = file_get_contents(__DIR__ . '/../../README.md');

	$phpParts = Strings::matchAll($readme, '~```php(.*?)```~is');

	ob_start();
	foreach($phpParts as $p) {
		$script = Strings::replace($p[1], '~((/\\*)|(\\*/))~', '');
		eval($script);
	}
	$actual = ob_get_contents();
	ob_end_clean();

	$expected = 'already hooked
' . TEST_PAGE_NAME . '
' . TEST_RECIPIENT_FIRST_NAME . ' ' . TEST_RECIPIENT_LAST_NAME . '
Someone sent us a message
array(3) {
  ["mid"]=>
  string(36) "mid.1458696618141:b4ef9d19ec21086067"
  ["seq"]=>
  int(51)
  ["attachments"]=>
  array(1) {
    [0]=>
    array(2) {
      ["type"]=>
      string(5) "image"
      ["payload"]=>
      array(1) {
        ["url"]=>
        string(9) "IMAGE_URL"
      }
    }
  }
}
';

	Assert::equal($actual, $expected);
} else {
	Tester\Environment::skip('Test requires defined constants `TEST_PAGE_ACCESS_TOKEN` and `TEST_RECIPIENT_ID`.');
}

