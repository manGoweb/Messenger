<?php

namespace Mangoweb\Messenger;

abstract class Sender {

	public function pack($recipient, ISendable $package) {
		$packed = [
			'recipient' => [ 'id' => $recipient ]
		];

		$packed[$package->getSendType()] = $package->toSchema();

		return $packed;
	}

}
