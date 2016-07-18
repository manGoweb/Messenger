<?php

namespace Mangoweb\Messenger;

class Message implements ISendable {

	const MESSAGE_TYPE_TEXT = 'text';
	const MESSAGE_TYPE_ATTACHMENT = 'attachment';

	const ATTACHMENT_TYPE_IMAGE = 'image';
	const ATTACHMENT_TYPE_AUDIO = 'audio';
	const ATTACHMENT_TYPE_VIDEO = 'video';
	const ATTACHMENT_TYPE_FILE = 'file';
	const ATTACHMENT_TYPE_TEMPLATE = 'template';

	const TEMPLATE_TYPE_GENERIC = 'generic';
	const TEMPLATE_TYPE_BUTTON = 'button';
	const TEMPLATE_TYPE_RECEIPT = 'receipt';

	public $text = '';
	public $type = self::MESSAGE_TYPE_TEXT;
	public $attachmentType;
	public $attachmentUrl;
	public $templateType;
	public $payload;
	// Array<QuickReply>
	public $quickReplies = [];
	// Array<Button>
	public $buttons = [];
	// Array<CardElement>
	public $cardElements = [];
	// Array<ReceiptElement>
	public $receiptElements = [];

	public static function text($text) {
		$message = new self;
		$message->text = $text;
		$message->type = self::MESSAGE_TYPE_TEXT;
		return $message;
	}

	public static function attachment($url, $type = self::ATTACHMENT_TYPE_FILE) {
		$message = new self;
		$message->attachmentUrl = $url;
		$message->type = self::MESSAGE_TYPE_ATTACHMENT;
		$message->attachmentType = $type;
		return $message;
	}

	public static function image($url) {
		return self::attachment($url, self::ATTACHMENT_TYPE_IMAGE);
	}

	public static function audio($url) {
		return self::attachment($url, self::ATTACHMENT_TYPE_AUDIO);
	}

	public static function video($url) {
		return self::attachment($url, self::ATTACHMENT_TYPE_VIDEO);
	}

	public static function file($url) {
		return self::attachment($url, self::ATTACHMENT_TYPE_FILE);
	}

	public static function receipt($recipient_name, $order_number, $currency, $payment_method, $order_url, $timestamp, $elements, $address, $summary, $adjustments) {
		// @TODO
	}

	public static function buttons($text, $buttons) {
		$message = new self;
		$message->text = $text;
		$message->type = self::MESSAGE_TYPE_ATTACHMENT;
		$message->attachmentType = self::ATTACHMENT_TYPE_TEMPLATE;
		$message->templateType = self::TEMPLATE_TYPE_BUTTON;
		if($buttons instanceof Button) {
			$buttons = [ $buttons ];
		}
		$message->buttons = $buttons;
		return $message;
	}

	public static function generic($elements) {
		$message = new self;
		$message->type = self::MESSAGE_TYPE_ATTACHMENT;
		$message->attachmentType = self::ATTACHMENT_TYPE_TEMPLATE;
		$message->templateType = self::TEMPLATE_TYPE_GENERIC;
		$message->cardElements = $elements;
		return $message;
	}

	public function attachmentToSchema() {
		$schema = [
			'type' => $this->attachmentType,
		];
		switch($this->attachmentType) {
			case self::ATTACHMENT_TYPE_TEMPLATE:
				$schema['payload'] = $this->templateToSchema();
				break;
			case self::ATTACHMENT_TYPE_IMAGE:
			case self::ATTACHMENT_TYPE_AUDIO:
			case self::ATTACHMENT_TYPE_VIDEO:
			case self::ATTACHMENT_TYPE_FILE:
				$schema['payload'] = [ 'url' => $this->attachmentUrl ];
				break;
			default:
				return 'UNKNOWN_ATTACHMENT_TYPE';
		}
		$schema = array_filter($schema);
		return $schema;
	}

	public function templateToSchema() {
		$schema = [
			'template_type' => $this->templateType,
		];
		switch($this->templateType) {
			case self::TEMPLATE_TYPE_BUTTON:
				$schema['text'] = $this->text;
				$schema['buttons'] = Utils::mapSchema($this->buttons);
				break;
			case self::TEMPLATE_TYPE_GENERIC:
				$schema['buttons'] = Utils::mapSchema($this->buttons);
				$schema['elements'] = Utils::mapSchema($this->cardElements);
				break;
			case self::TEMPLATE_TYPE_RECEIPT:
				// @TODO: implement
				$schema['recipient_name'] = 'Stephane Crozatier';
				$schema['order_number'] = '12345678902';
				$schema['currency'] = 'USD';
				$schema['payment_method'] = 'Visa 2345';
				$schema['order_url'] = 'http://petersapparel.parseapp.com/order?order_id=123456';
				$schema['timestamp'] = '1428444852';
				$schema['elements'] = Utils::mapSchema($this->receiptElements);
				$schema['address'] = [
					'street_1' => "1 Hacker Way",
					'street_2' => "",
					'city' => "Menlo Park",
					'postal_code' => "94025",
					'state' => "CA",
					'country' => "US",
				];
				$schema['summary'] = [
					'subtotal' => 1,
					'shipping_cost' => 2,
					'total_tax' => 3,
					'total_cost' => 4,
				];
				$schema['adjustments'] = [
					[ 'name' => '$10 Off Coupon', 'amount' => 10 ]
				];
				break;
			default:
				return 'UNKNOWN_TEMPLATE_TYPE';
		}
		$schema = array_filter($schema);
		return $schema;
	}

	public function getSendType() {
		return 'message';
	}

	public function toSchema() {
		$schema = [
			'quick_replies' => Utils::mapSchema($this->quickReplies),
		];

		switch($this->type) {
			case self::MESSAGE_TYPE_TEXT:
				$schema['text'] = $this->text;
				break;
			case self::MESSAGE_TYPE_ATTACHMENT:
				$schema['attachment'] = $this->attachmentToSchema();
				break;
			default:
				return 'UNKNOWN_MESSAGE_TYPE';
		}

		$schema = array_filter($schema);
		return $schema;
	}

	public function __toString() {
		return json_encode($this->toSchema(), JSON_PRETTY_PRINT);
	}

}
