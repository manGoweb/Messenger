<?php

namespace Mangoweb\Messenger;

class TestSender {

	private $output = '';

	public function send($message) {
		$this->output .= (string) $message . "\n";
	}

	public function getOutput() {
		return $this->output;
	}

}
