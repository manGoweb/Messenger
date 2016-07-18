<?php

namespace Mangoweb\Messenger;

class PageSender {

	public $page;

	public function send(Message $message) {

	}

	public function toSchema($recipient, Message $message) {
		$schema = [
			'recipient' => [ 'id' => $recipient ],
			'message' => $message->toSchema(),
		];

		return $schema;
	}

}
