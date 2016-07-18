<?php

namespace Mangoweb\Messenger;

class QuickReply {

	const TYPE_TEXT = 'text';

	private $contentType = self::TYPE_TEXT;
	private $title; // max 20 chars
	private $payload; // max 1000 chars

	public function toSchema() {
		$schema = [];
		return $schema;
	}

}
