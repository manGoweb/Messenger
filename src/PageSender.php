<?php

namespace Mangoweb\Messenger;

class PageSender extends Sender {

	public $page;

	public function __construct(Page $page) {
		$this->page = $page;
	}

	public function send($recipient, ISendable $package) {
		$packed = $this->pack($recipient, $package);
		return $this->page->sendMessage($packed);
	}

}
