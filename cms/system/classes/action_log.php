<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }


class log {

static private $instance = null;

static function getInstance(){

	if (self::$instance == null){
		self::$instance = new self();
	}
	return self::$instance;

}

private function __construct(){}

}

public function alog($module=null,$action=null,$result=null){
    
	$db = DB::getInstance();
    
}

?>