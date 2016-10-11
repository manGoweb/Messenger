<?php

namespace Mangoweb\Messenger;

use Tracy\Debugger;
use GuzzleHttp;

class Page {

	const BASE_URL = 'https://graph.facebook.com/v2.8';

	private $token;

	public function __construct($token) {
		$this->token = $token;
	}

	public function getToken() {
		return $this->token;
	}

	public function request($type, $path, $params) {
		$client = new GuzzleHttp\Client();
		return $client->request($type, self::BASE_URL . $path, $params);
	}

	public function hook() {
		$token = $this->getToken();

		$params = [
			'query' => [ 'access_token' => $token ],
		];

		try {
			$res = $this->request('POST', '/me/subscribed_apps', $params);
		} catch(Exception $e) {
			Debugger::log($e);
			return FALSE;
		}

		$status = $res->getStatusCode();

		return $status === 200;
	}

	public function loadInfo() {
		$token = $this->getToken();

		$params = [
			'query' => [
				'access_token' => $token,
				'fields' => 'about,name'
			],
		];

		try {
			$res = $this->request('GET', '/me', $params);
		} catch(Exception $e) {
			Debugger::log($e);
			return FALSE;
		}

		return json_decode((string) $res->getBody(), TRUE);
	}

	public function loadProfile($id) {
		$token = $this->getToken();

		$params = [
			'query' => [
				'access_token' => $token
			],
		];

		try {
			$res = $this->request('GET', '/' . $id, $params);
		} catch(Exception $e) {
			Debugger::log($e);
			return FALSE;
		}

		return json_decode((string) $res->getBody(), TRUE);
	}

	public function loadSubscribedApps() {
		$token = $this->getToken();

		$params = [
			'query' => [
				'access_token' => $token
			],
		];

		try {
			$res = $this->request('GET', '/me/subscribed_apps', $params);
		} catch(Exception $e) {
			Debugger::log($e);
			return FALSE;
		}

		return json_decode((string) $res->getBody(), TRUE)['data'];
	}

	public function isHookedToApp($appId) {
		$subscribed = $this->loadSubscribedApps();
		$appId = (string) $appId;
		foreach($subscribed as $app) {
			if($appId === $app['id']) {
				return TRUE;
			}
		}
		return FALSE;
	}

	public function sendMessage($payload) {
		$token = $this->getToken();

		$params = [
			'query' => [ 'access_token' => $token ],
			'json' => $payload,
		];

		try {
			$res = $this->request('POST', '/me/messages', $params);
		} catch(Exception $e) {
			Debugger::log($e);
			return FALSE;
		}

		$status = $res->getStatusCode();
		return json_decode((string) $res->getBody(), TRUE);
	}

	public function setGreeting(Greeting $greeting) {
		$token = $this->getToken();

		$payload = $greeting->toSchema();

		$params = [
			'query' => [ 'access_token' => $token ],
			'json' => $payload,
		];

		$res = $this->request('POST', '/me/thread_settings', $params);

		$status = $res->getStatusCode();

		return $status === 200;
	}

	public function removeGreeting() {
		return $this->setGreeting(Greeting::text(''));
	}

	public function setGetStartedButton(GetStartedButton $button) {
		$token = $this->getToken();

		$payload = $button->toSchema();

		$params = [
			'query' => [ 'access_token' => $token ],
			'json' => $payload,
		];

		$res = $this->request('POST', '/me/thread_settings', $params);

		$status = $res->getStatusCode();

		return $status === 200;
	}

	public function removeGetStartedButton() {
		$token = $this->getToken();

		$button = GetStartedButton::empty();
		$payload = $button->toSchema();

		$params = [
			'query' => [ 'access_token' => $token ],
			'json' => $payload,
		];

		$res = $this->request('DELETE', '/me/thread_settings', $params);

		$status = $res->getStatusCode();

		return $status === 200;
		
	}

	public function setPersistentMenu(PersistentMenu $menu) {
		$token = $this->getToken();

		$payload = $menu->toSchema();

		$params = [
			'query' => [ 'access_token' => $token ],
			'json' => $payload,
		];

		$res = $this->request('POST', '/me/thread_settings', $params);

		$status = $res->getStatusCode();

		return $status === 200;
	}

	public function removePersistentMenu() {
		$token = $this->getToken();

		$menu = PersistentMenu::empty();
		$payload = $menu->toSchema();

		$params = [
			'query' => [ 'access_token' => $token ],
			'json' => $payload,
		];

		$res = $this->request('DELETE', '/me/thread_settings', $params);

		$status = $res->getStatusCode();

		return $status === 200;
	}

	public function createDomainWhitelistingPayload($domains, $action = 'add') {
		if(!is_array($domains)) {
			$domains = [ $domains ];
		}

		$payload = [
			'setting_type' => 'domain_whitelisting',
			'whitelisted_domains' => $domains,
			'domain_action_type'=> $action,
		];

		return $payload;
	}

	public function whitelistDomainForExtensions($domain, $action = 'add') {
		$token = $this->getToken();

		$payload = $this->createDomainWhitelistingPayload($domain, $action);

		$params = [
			'query' => [ 'access_token' => $token ],
			'json' => $payload,
		];

		$res = $this->request('POST', '/me/thread_settings', $params);

		$status = $res->getStatusCode();

		return $status === 200;
	}


}
