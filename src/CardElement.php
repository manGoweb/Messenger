<?php

namespace Mangoweb\Messenger;

use Mangoweb\Messenger\Utils;
use Nette\Utils\Validators;
use Nette\Utils\AssertionException;

class CardElement {

	const MAX_TITLE_CHARS = 80;
	const MAX_SUBTITLE_CHARS = 80;

	public $title; // max 80 chars
	public $subtitle; // max 80 chars
	public $itemUrl;
	public $imageUrl; // ratio 1.91:1
	public $buttons = []; // max 3

	public static function create($title, $subtitle = NULL, $itemUrl = NULL, $imageUrl = NULL, array $buttons = []) {
		$element = new self;
		$element->title = self::sanitizeTitle($title);
		$element->subtitle = self::sanitizeSubtitle($subtitle);
		$element->itemUrl = self::sanitizeItemUrl($itemUrl);
		$element->imageUrl = self::sanitizeImageUrl($imageUrl);
		$element->buttons = self::sanitizeButtons($buttons);
		return $element;
	}

	public static function sanitizeTitle($value) {
		Utils::maxLength($value, self::MAX_TITLE_CHARS, 'title');
		return $value;
	}

	public static function sanitizeSubtitle($value) {
		if(empty($value)) {
			return NULL;
		}
		Utils::maxLength($value, self::MAX_SUBTITLE_CHARS, 'subtitle');
		return $value;
	}

	public static function sanitizeItemUrl($value) {
		if(empty($value)) {
			return NULL;
		}
		Validators::assert($value, 'url', 'itemUrl');
		return $value;
	}

	public static function sanitizeImageUrl($value) {
		if(empty($value)) {
			return NULL;
		}
		Validators::assert($value, 'url', 'imageUrl');
		return $value;
	}

	public static function sanitizeButtons(array $value = []) {
		if(empty($value)) {
			return NULL;
		}
		if(count($value) > 3) {
			throw new AssertionException("The buttons count cannot be more than 3.");
		}
		return $value;
	}



	public function toSchema() {
		$schema = [
			'title' => $this->title,
			'subtitle' => $this->subtitle,
			'item_url' => $this->itemUrl,
			'image_url' => $this->imageUrl,
			'buttons' => Utils::mapSchema($this->buttons),
		];
		$schema = array_filter($schema);
		return $schema;
	}

}
