<?php

namespace Mangoweb\Messenger;

class ReceiptElement {

	public $title;
	public $subtitle;
	public $quantity;
	public $price;
	public $currency;
	public $imageUrl;

	public function toSchema() {
		$schema = [
			'title' => $this->title,
			'subtitle' => $this->subtitle,
			'quantity' => $this->quantity,
			'price' => $this->price,
			'currency' => $this->currency,
			'image_url' => $this->imageUrl,
		];
		$schema = array_filter($schema);
		return $schema;
	}

}
