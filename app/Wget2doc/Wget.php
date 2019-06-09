<?php

namespace app\Wget2doc;

class Wget
{
	
	public $dir;
	public $url;
	public $domain;
	
	CONST GETFILES = 'html,htm,pdf,mp4';
	CONST WAIT = '3';
	
	public function __construct($domain,$dir)
	{
		if(empty($domain)){
			throw new \Exception('$domain is require.');
		}
		
		$this->url = $this->makeUrl($domain);
		
		if(!$domain){
			throw new \Exception('$domain is invalid.');
		}
		
		if(empty($dir)){
			throw new \Exception('$dir is require.');
		}
		
		if(!file_exists($dir)){
			throw new \Exception($dir.' does no exist.');
		}
		$this->domain = $domain;
		$this->dir = $dir;
	}
	
	public function get()
	{
		$command = sprintf('cd %s; wget -r -w%s -A %s %s',$this->dir,self::WAIT,self::GETFILES,$this->url);
		$result = system($command);
		return $this->getPages();
	}
	
	public function getPages(){
		$cmd = sprintf('cd %s; find . -type f',$this->dir.'/'.$this->domain);
//		$cmd = sprintf('cd %s; find . -type f | grep \'.html\'',$this->dir.'/'.$this->domain);
		return `$cmd`;
	}
	
	private function makeUrl($domain){
		$http = 'http://'.$domain;
		$https = 'https://'.$domain;
		
		if($this->isValidUrl($https)){
			return $https;
		}else if($this->isValidUrl($http)){
			return $http;
		}else{
			return false;
		}
	}

	private function isValidUrl($url){
		$headers = @get_headers( $url );
		if( preg_match( '/[2][0-9][0-9]|[3][0-9][0-9]/', $headers[0] ) ){
			return true;
		}else{
			return false;
		}
	}
	
	
}