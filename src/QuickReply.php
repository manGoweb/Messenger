<?php

namespace Mangoweb\Messenger;

class QuickReply {

	const TYPE_TEXT = 'text';

	private $contentType = self::TYPE_TEXT;
	private $title; // max 20 chars
	private $payload; // max 1000 chars

	public static function text($title, $payload = NULL) {
		$qr = new self;
		$qr->contentType = self::TYPE_TEXT;
		$qr->title = $title;
		$qr->payload = $payload;
		return $qr;
	}

	public function toSchema() {
		$schema = [
			'content_type' => $this->contentType,
			'title' => $this->title,
			'payload' => Utils::serialize($this->payload),
		];
		$schema = array_filter($schema);
		if(!isset($schema['payload'])) {
			$schema['payload'] = '-';
		}
		return $schema;
	}

}
