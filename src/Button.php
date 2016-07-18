<?php

namespace Mangoweb\Messenger;

class Button {

	const TYPE_WEB_URL = 'web_url';
	const TYPE_POSTBACK = 'postback';
	const TYPE_PHONE_NUMBER = 'phone_number';

	public $type = self::TYPE_WEB_URL;
	public $title; // max 20 chars
	public $url;
	public $payload; // max 1000 chars

	public static function url($title, $url) {
		$button = new self;
		$button->type = self::TYPE_WEB_URL;
		$button->title = $title;
		$button->url = $url;
		return $button;
	}

	public static function postback($title, $payload) {
		$button = new self;
		$button->type = self::TYPE_POSTBACK;
		$button->title = $title;
		$button->payload = $payload;
		return $button;
	}

	public static function phone($title, $phone_number) {
		$button = new self;
		$button->type = self::TYPE_PHONE_NUMBER;
		$button->title = $title;
		$button->phone_number = $phone_number;
		return $button;
	}

	public function toSchema() {
		$schema = [
			'type' => $this->type,
			'title' => $this->title,
			'url' => $this->url,
			'payload' => Utils::serialize($this->payload),
		];
		$schema = array_filter($schema);
		return $schema;
	}

}
