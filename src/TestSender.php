<?php

namespace Mangoweb\Messenger;

class TestSender extends Sender {

	private $output = '';

	public function send($recipient, ISendable $package) {
		$this->output .= Utils::readable($this->pack($recipient, $package));
	}

	public function getOutput() {
		return $this->output;
	}

}
