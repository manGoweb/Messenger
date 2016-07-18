Messenger interface
===================

### Installation

Use composer:

```bash
$ composer require mangoweb/messenger
```

### Tests

Add `tests/php.ini` (you may use the templates `php-unix.ini` or `php-win.ini`).

In `tests/local.php` you can define constants for testing real API calls (you may use the template `local.sample.php`)

```bash
$ ./vendor/bin/tester -c tests/php.ini tests
```

### License

MIT. See full [license](license.md).
