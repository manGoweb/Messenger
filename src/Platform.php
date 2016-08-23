<?php

namespace Mangoweb\Messenger;

use GuzzleHttp;

class Platform {

	public function hook($pageAccessToken) {
		$client = new GuzzleHttp\Client();
		$payload = [
			'query' => [ 'access_token' => $pageAccessToken ],
		];

		$res = $client->request('POST', 'https://graph.facebook.com/v2.6/me/subscribed_apps', $payload);

		$status = $res->getStatusCode();

		return $status === 200;
	}

}
