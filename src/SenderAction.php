<?php

namespace Mangoweb\Messenger;

class SenderAction {

	const TYPE_TYPING_ON = 'typing_on';
	const TYPE_TYPING_OFF = 'typing_off';
	const TYPE_MARK_SEEN = 'mark_seen';

	public $type = self::TYPE_TYPING_ON;

	public function toSchema() {
		$schema = $this->type;
		return $schema;
	}

}
