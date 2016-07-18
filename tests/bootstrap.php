<?php

namespace NextrasTests\Orm;

use Nette\Configurator;
use Tester\Environment;


if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo "Install Nette Tester using `composer update`\n";
	exit(1);
}

date_default_timezone_set('Europe/Prague');

Environment::setup();

$configurator = new Configurator();

$configurator->setTempDirectory(__DIR__ . '/temp');

return $configurator->createContainer();
