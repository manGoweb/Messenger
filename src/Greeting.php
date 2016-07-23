<?php

namespace Mangoweb\Messenger;

use Nette\Utils\Validators;
use Nette\Utils\AssertionException;

class Greeting {

	const SETTING_TYPE_GREETING = 'greeting';

	const MAX_TEXT_CHARS = 160;

	public $settingType = self::SETTING_TYPE_GREETING;
	public $text;

	public static function sanitizeText($value) {
		Validators::assert($value, 'string:1..' . self::MAX_TEXT_CHARS, 'text');
		return $value;
	}

	public static function text(string $text) {
		$greeting = new self;
		$greeting->settingType = self::SETTING_TYPE_GREETING;
		$greeting->text = self::sanitizeText($text);
		return $greeting;
	}

	public function toSchema() {
		$schema = [
			'setting_type' => $this->settingType,
			'greeting' => [
				'text' => $this->text,
			],
		];
		$schema = array_filter($schema);
		return $schema;
	}

}
