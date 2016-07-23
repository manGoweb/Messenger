<?php

namespace Mangoweb\Messenger;

use Nette\Utils\Validators;
use Nette\Utils\AssertionException;

class GetStartedButton {

	const SETTING_TYPE_CALL_TO_ACTIONS = 'call_to_actions';
	const THREAD_STATE_NEW_THREAD = 'new_thread';

	public $settingType = self::SETTING_TYPE_CALL_TO_ACTIONS;
	public $threadState = self::THREAD_STATE_NEW_THREAD;
	public $payload;

	public static function payload($payload) {
		$button = new self;
		$button->settingType = self::SETTING_TYPE_CALL_TO_ACTIONS;
		$button->threadState = self::THREAD_STATE_NEW_THREAD;
		$button->payload = Utils::serialize($payload);
		return $button;
	}

	public static function empty() {
		$button = new self;
		$button->settingType = self::SETTING_TYPE_CALL_TO_ACTIONS;
		$button->threadState = self::THREAD_STATE_NEW_THREAD;
		return $button;
	}

	public function toSchema() {
		$schema = [
			'setting_type' => $this->settingType,
			'thread_state' => $this->threadState,
			'call_to_actions' => $this->payload ? [
				[ 'payload' => $this->payload ],
			] : NULL,
		];
		$schema = array_filter($schema);
		return $schema;
	}

}
