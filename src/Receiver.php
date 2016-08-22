<?php

namespace Mangoweb\Messenger;

use Nette\Object;

class Receiver extends Object {

	const MESSAGING_KEY_MESSAGE = 'message';
	const MESSAGING_KEY_POSTBACK = 'postback';
	const MESSAGING_KEY_OPTIN = 'optin';
	const MESSAGING_KEY_ACCOUNT_LINKING = 'account_linking';
	const MESSAGING_KEY_DELIVERY = 'delivery';
	const MESSAGING_KEY_READ = 'read';
	const MESSAGING_IS_ECHO_KEY = 'is_echo';
	
	// whole body
	public $onRequest = [];

	// single entry of body.entry[]
	public $onEntry = [];

	// single messaging item of entry.messaging[]
	public $onReceive = [];

	// single messaging of type 
	public $onMessage = [];
	public $onPostback = [];
	public $onOptin = [];
	public $onAccountLinking = [];
	public $onDelivery = [];
	public $onRead = [];
	public $onEcho = [];

	public function processBody($body) {
		if($body['object'] !== 'page') {
			throw new InvalidBodyException('Messenger Receiver cannot process this body.');
		}

		$this->onRequest($body);

		foreach($body['entry'] as $entry) {
			$this->onEntry($entry, $body);

			foreach($entry['messaging'] as $messaging) {
				$this->onReceive($messaging, $entry, $body);

				if(array_key_exists(self::MESSAGING_KEY_MESSAGE, $messaging)) {
					$message = $messaging[self::MESSAGING_KEY_MESSAGE];
					if(array_key_exists(self::MESSAGING_IS_ECHO_KEY, $message) && $message[self::MESSAGING_IS_ECHO_KEY] === TRUE) {
						$this->onEcho($message, $messaging, $entry, $body);
					} else {
						$this->onMessage($message, $messaging, $entry, $body);
					}
				} else if(array_key_exists(self::MESSAGING_KEY_POSTBACK, $messaging)) {
					$this->onPostback($messaging[self::MESSAGING_KEY_POSTBACK], $messaging, $entry, $body);
				} else if(array_key_exists(self::MESSAGING_KEY_OPTIN, $messaging)) {
					$this->onOptin($messaging[self::MESSAGING_KEY_OPTIN], $messaging, $entry, $body);
				} else if(array_key_exists(self::MESSAGING_KEY_ACCOUNT_LINKING, $messaging)) {
					$this->onAccountLinking($messaging[self::MESSAGING_KEY_ACCOUNT_LINKING], $messaging, $entry, $body);
				} else if(array_key_exists(self::MESSAGING_KEY_DELIVERY, $messaging)) {
					$this->onDelivery($messaging[self::MESSAGING_KEY_DELIVERY], $messaging, $entry, $body);
				} else if(array_key_exists(self::MESSAGING_KEY_READ, $messaging)) {
					$this->onRead($messaging[self::MESSAGING_KEY_READ], $messaging, $entry, $body);
				}

			}
		}
	}

}
