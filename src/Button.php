<?php

namespace Mangoweb\Messenger;

use Mangoweb\Messenger\Utils;
use Nette\Utils\Validators;
use Nette\Utils\AssertionException;

class Button {

	const TYPE_WEB_URL = 'web_url';
	const TYPE_POSTBACK = 'postback';
	const TYPE_PHONE_NUMBER = 'phone_number';
	const TYPE_ACCOUNT_LINK = 'account_link';
	const TYPE_ACCOUNT_UNLINK = 'account_unlink';

	const MAX_TITLE_CHARS = 20;
	const MAX_PAYLOAD_CHARS = 1000;

	public $type = self::TYPE_WEB_URL;
	public $title; // max 20 chars
	public $url;
	public $payload; // max 1000 chars

	public static function sanitizeType($value) {
		if(!Utils::inArray($value, [ self::TYPE_WEB_URL, self::TYPE_POSTBACK, self::TYPE_PHONE_NUMBER, self::TYPE_ACCOUNT_LINK, self::TYPE_ACCOUNT_UNLINK ])) {
			throw new AssertionException("The type is out of valid range.");
		}
		return $value;
	}

	public static function sanitizeTitle($value) {
		Utils::maxLength($value, self::MAX_TITLE_CHARS, 'title');
		return $value;
	}

	public static function sanitizeUrl($value) {
		Validators::assert($value, 'url', 'url');
		return $value;
	}

	public static function sanitizePayload($value) {
		Utils::maxLength($value, self::MAX_PAYLOAD_CHARS, 'payload');
		return $value;
	}

	public static function sanitizePhoneNumber($value) {
		Validators::assert($value, 'pattern:\\+[0-9]{6,15}', 'phoneNumber');
		return $value;
	}

	public static function url($title, $url) {
		$button = new self;
		$button->type = self::TYPE_WEB_URL;
		$button->title = self::sanitizeTitle($title);
		$button->url = self::sanitizeUrl($url);
		return $button;
	}

	public static function postback($title, $payload) {
		$button = new self;
		$button->type = self::TYPE_POSTBACK;
		$button->title = self::sanitizeTitle($title);
		$button->payload = self::sanitizePayload(Utils::serialize($payload));
		return $button;
	}

	public static function phone($title, $phone_number) {
		$button = new self;
		$button->type = self::TYPE_PHONE_NUMBER;
		$button->title = self::sanitizeTitle($title);
		$button->phone_number = self::sanitizePhoneNumber($phone_number);
		return $button;
	}

	public static function accountLink($title, $url) {
		$button = new self;
		$button->type = self::TYPE_ACCOUNT_LINK;
		$button->title = self::sanitizeTitle($title);
		$button->url = self::sanitizeUrl($url);
		return $button;
	}

	public static function accountUnlink($title) {
		$button = new self;
		$button->type = self::TYPE_ACCOUNT_UNLINK;
		$button->title = self::sanitizeTitle($title);
		return $button;
	}

	public function toSchema() {
		$schema = [
			'type' => self::sanitizeType($this->type),
			'title' => $this->title,
			'url' => $this->url,
			'payload' => $this->type === self::TYPE_PHONE_NUMBER ? $this->phone_number : Utils::serialize($this->payload),
		];
		$schema = array_filter($schema);
		return $schema;
	}

}
