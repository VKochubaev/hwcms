<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

include_once 'libs/godb.php';

class DB {

static private $instance = array();

static function getInstance($init_id='core',$con_options=false){

	if (!isset(self::$instance[$init_id]) || self::$instance[$init_id] == null){
	
		$conf = config::getInstance('core');
		$dbconf = $conf->getDB();

		try {
			self::$instance[$init_id] = new goDB(!$con_options ? array(
				'username' => $dbconf['user'],
				'passwd' => $dbconf['password'],
				'host' => $dbconf['host'],
				'dbname' => $dbconf['base']
			) : $con_options);
			@self::$instance[$init_id]->query("SET NAMES 'utf8'");
		} catch (goDBExceptionConnect $e) {
			die('DB connection error!');
		}
		unset($conf,$dbconf);

	}
	return self::$instance[$init_id];

}

private function __construct(){}

private function __clone(){}

}

?>