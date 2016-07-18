<?php

namespace Mangoweb\Messenger;

use Nette\Utils\Strings;

class Utils {

	static function normalize($str) {
		return Strings::normalize($str);
	}

	static function inLength($str, $length) {
		return Strings::length($str) <= $length;
	}

	static function truncate($str, $length) {
		return Strings::truncate($str, $length);
	}

	static function inArray($needle, $haystack, $asStrings = FALSE) {
		return in_array($needle, $haystack, !$asStrings);
	}

	static function map($array, $method, $params = []) {
		return array_map(function($item) use ($method, $params) {
			return call_user_func_array([ $item, $method ], (array) $params);
		}, $array);
	}

	static function mapSchema(array $array = []) {
		return self::map($array, 'toSchema');
	}

	static function serialize($payload, $readable = FALSE) {
		if(is_string($payload)) {
			return $payload;
		}
		if(is_numeric($payload)) {
			return $payload;
		}
		return $payload ? json_encode($payload, $readable ? JSON_PRETTY_PRINT : NULL) : NULL;
	}

	static function unserialize($str, $asObjects = FALSE) {
		return $str ? json_decode($str, !$asObjects) : NULL;
	}

	static function readable($payload) {
		return self::serialize($payload, TRUE) . "\n";
	}

	static function dump($el) {
		echo self::readable(is_array($el) ? $el : $el->toSchema());
	}

	static function verifyWebhook($verifyToken, $parameters) {
		if(!empty($parameters['hub_verify_token'])) {
			if($parameters['hub_verify_token'] === $verifyToken) {
				return $parameters['hub_challenge'];
			}
		}
		return FALSE;
	}

}
