<?php
if(!defined('hwid')) { e404('Access denied!'); }

// базовый класс движка
class CoreBase {

static private $instance = null;

static function getInstance(){

	if (self::$instance == null){
		self::$instance = new CoreBase();
	}
	return self::$instance;

}

private function __construct(){}

private function __clone(){}

}

?>