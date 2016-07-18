<?php

namespace Mangoweb\Messenger;

class CardElement {

	public $title; // max 80 chars
	public $subtitle; // max 80 chars
	public $itemUrl;
	public $imageUrl; // ratio 1.91:1
	public $buttons = []; // max 3

	public static function create($title, $subtitle, $itemUrl, $imageUrl, $buttons) {
		$element = new self;
		$element->title = $title;
		$element->subtitle = $subtitle;
		$element->itemUrl = $itemUrl;
		$element->imageUrl = $imageUrl;
		$element->buttons = $buttons;
		return $element;
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
