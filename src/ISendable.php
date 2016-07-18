<?php

namespace Mangoweb\Messenger;

interface ISendable {

	public function getSendType();

	public function toSchema();

}
