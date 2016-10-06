<?php

namespace Mangoweb\Messenger;

class QuickReply {

	const TYPE_TEXT = 'text';
	const TYPE_LOCATION = 'location';

	private $contentType = self::TYPE_TEXT;
	private $title; // max 20 chars
	private $imageUrl;
	private $payload; // max 1000 chars

	public static function text($title, $payload = NULL) {
		$qr = new self;
		$qr->contentType = self::TYPE_TEXT;
		$qr->title = $title;
		$qr->payload = $payload;
		return $qr;
	}

	public static function image($title, $imageUrl, $payload = NULL) {
		$qr = self::text($title, $payload);
		$qr->imageUrl = $imageUrl;
		return $qr;
	}

	public static function location() {
		$qr = new self;
		$qr->contentType = self::TYPE_LOCATION;
		return $qr;
	}

	public function toSchema() {
		$schema = [
			'content_type' => $this->contentType,
			'title' => $this->title,
			'image_url' => $this->imageUrl,
			'payload' => Utils::serialize($this->payload),
		];
		$schema = array_filter($schema);
		if($this->contentType !== self::TYPE_LOCATION && !isset($schema['payload'])) {
			$schema['payload'] = '-'; // non-empty payload is required unless type is `location`
		}
		return $schema;
	}

}
