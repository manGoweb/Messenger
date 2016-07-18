<?php

namespace Mangoweb\Messenger;

use Nette\Utils\Strings;

class CloseUrl {

	const URL_TEMPLATE = 'https://www.messenger.com/closeWindow/?image_url=IMAGE_URL&display_text=DISPLAY_TEXT';

	private $imageUrl;
	private $displayText;

	public function __construct($imageUrl, $displayText) {
		$this->imageUrl = $imageUrl;
		$this->displayText = $displayText;
	}

	public function __toString() {
		$url = $this::URL_TEMPLATE;
		$url = Strings::replace($url, '~IMAGE_URL~', rawurlencode($this->imageUrl));
		$url = Strings::replace($url, '~DISPLAY_TEXT~', rawurlencode($this->displayText));
		return $url;
	}

}
