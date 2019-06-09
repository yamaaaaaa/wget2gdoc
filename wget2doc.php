<?php

use Dotenv\Dotenv;
use app\Wget2doc\{Wget, SpredSheet};
use QL\QueryList;

date_default_timezone_set('Asia/Tokyo');
require_once realpath(dirname(__FILE__) . '/vendor/autoload.php');
Dotenv::create(dirname(__FILE__))->load();

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . getenv('GOOGLE_APPLICATION_CREDENTIALS'));

$domain = getenv('WGET_DOMAIN');
$dir = __DIR__ . DIRECTORY_SEPARATOR . 'data';

$wget = new Wget($domain, $dir);
$pages = $wget->get();
//$pages = $wget->getPages();
$pages = explode("\n", $pages);

$ql = QueryList::getInstance();
$ql->bind('src', function ($src) {
	$result = file_get_contents($src);
	$this->setHtml($result);
	return $this;
});


$output = [];

sort($pages);
$cnt = 1;

foreach ($pages as $key => $page) {
	if(preg_match('/feed|wp\-json/',$page)){
		continue;
	}
	if(preg_match('/\.html/',$page)){
		$localUrl = str_replace('./', $dir . '/' . $domain . '/', $page);
		if(!file_exists($localUrl)){
			continue;
		}
		$ql->src($localUrl);
		$title =  $ql->find('title')->text();
	}else{
		if($page==''){
			continue;
		}else if(preg_match('/\.pdf/',$page)){
			$title = 'PDFファイル';
		}else{
			var_dump($page);
			exit;
			continue;
		}
	}
	
	if(preg_match('/\/en\//',$page)){
		$lang = 'en';
	}else if(preg_match('/\/ja\//',$page)){
		$lang = 'ja';
	}else{
		$lang = 'other';
	}
	
	$page = urlencode($page);
	$page = str_replace('%2F', '/', $page);
	$page = str_replace('./', $wget->url . '/', $page);
	$page = str_replace('index.html', '', $page);
	$output[] = [$lang,$title,$page];
}

$api = new SpredSheet(getenv('SPREAD_SHEET_ID'), getenv('SPREAD_SHEET_NAME'));
$api->upload($output);

var_dump('COMPLETE!'); 