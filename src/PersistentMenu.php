<?php

namespace Mangoweb\Messenger;

use Nette\Utils\AssertionException;

class PersistentMenu {

	const SETTING_TYPE_CALL_TO_ACTIONS = 'call_to_actions';
	const THREAD_STATE_EXISTING_THREAD = 'existing_thread';

	public $settingType = self::SETTING_TYPE_CALL_TO_ACTIONS;
	public $threadState = self::THREAD_STATE_EXISTING_THREAD;
	public $buttons;

	public static function buttons($buttons) {
		$menu = new self;
		$menu->settingType = self::SETTING_TYPE_CALL_TO_ACTIONS;
		$menu->threadState = self::THREAD_STATE_EXISTING_THREAD;
		$menu->buttons = self::sanitizeButtons($buttons);
		return $menu;
	}

	public static function empty() {
		$menu = new self;
		$menu->settingType = self::SETTING_TYPE_CALL_TO_ACTIONS;
		$menu->threadState = self::THREAD_STATE_EXISTING_THREAD;
		$menu->buttons = NULL;
		return $menu;
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
			'setting_type' => $this->settingType,
			'thread_state' => $this->threadState,
		];
		if($this->buttons) {
			$schema['call_to_actions'] = Utils::mapSchema($this->buttons);
		}
		$schema = array_filter($schema);
		return $schema;
	}

}
