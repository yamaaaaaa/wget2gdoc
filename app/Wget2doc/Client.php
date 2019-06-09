<?php

namespace app\Wget2doc;

class Client
{
	
	protected $client;
	protected $service;
	
	public function __construct()
	{
		$this->client = new \Google_Client();
		$this->client->useApplicationDefaultCredentials();
		$this->service = new \Google_Service_Sheets($this->client);
	}
	
}