<?php

namespace Mangoweb\Messenger;

class SenderAction {

	const TYPE_TYPING_ON = 'typing_on';
	const TYPE_TYPING_OFF = 'typing_off';
	const TYPE_MARK_SEEN = 'mark_seen';

	public $type = self::TYPE_TYPING_ON;

	public static function typing($typingOn = TRUE) {
		$sa = new self;
		$sa->type = $typingOn ? self::TYPE_TYPING_ON : self::TYPE_TYPING_OFF;
		return $sa;
	}

	public static function seen() {
		$sa = new self;
		$sa->type = self::TYPE_MARK_SEEN;
		return $sa;
	}

	public function toSchema() {
		$schema = $this->type;
		return $schema;
	}

}
