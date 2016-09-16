<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class SiteVersions {

private $siteVersion = null;
static private $instance = null;

static function getInstance(){

	if (self::$instance == null){
		self::$instance = new self();
	}
	return self::$instance;

}

private function __construct(){

	// Подключаем БД и грузим список языков
	$db = DB::getInstance('core');
	$q = $db->query("SELECT * FROM `site_versions` ORDER BY FIELD(`def`,1,0), `title` ASC", null, 'kassoc:version_id');
	$this->siteVersion = $q ? $q : null;

}

private function __clone(){}

public function getVersion($ver_id=null){

	if($this->siteVersion == null) return false;
	if(defined('siteVersion') && strlen(constant('siteVersion'))>0 && !isset($this->siteVersion[0]['cur'])){
		foreach($this->siteVersion as $i=>$v){
			$this->siteVersion[$i]['cur'] = ($v['version_id'] == constant('siteVersion')) ? true : false;
		}
	}
	if($ver_id != null){
		return isset($this->siteVersion[$ver_id]) ? $this->siteVersion[$ver_id] : false;
	} else return $this->siteVersion;

}

public function getDefaultVersion(){
	
	if($this->siteVersion==null) return false;
	foreach($this->siteVersion as $ver){
		if($ver['def']) return $ver;
	}
	return false;
	
}
	
}