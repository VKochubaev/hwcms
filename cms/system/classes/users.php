<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class Users {

private $user = null;
private $session_name_admin = 'hw_admin';
static private $instance = array();

static function getInstance($init_id='core'){

	if (!isset(self::$instance[$init_id]) || self::$instance[$init_id] == null){
		self::$instance[$init_id] = new self();
	}
	return self::$instance[$init_id];

}

private function __construct(){}

private function __clone(){}

public function admin($id=false){
	
	if(!$id){
		if(isset($_SESSION) && isset($_SESSION['user']) && sizeof($_SESSION['user'])>0 && isdig($_SESSION['user']['id']) && $_SESSION['user']['id']>0){
			return $this->user = $_SESSION['user'];
		}
	}else{
		$idins = (isdig($id)) ? "id=?i" : (!$id) ? false : "nick LIKE(?s)";
		if($idins){
			$db = DB::getInstance();
			$q = $db->query("SELECT id,uniq_id,confirmed,active,reg_date,upd_date,vis_date,nick FROM admins WHERE $idins",array($id),'rowassoc');
			if($q) return $this->user = $q;		
		}
	}
	return false;
	
}

public function authorizeAdmin($login,$passw){

	if(!empty($login) && !empty($passw)){
		$db = DB::getInstance();
		$q = $db->query("SELECT id,active,reg_date,upd_date,vis_date,nick FROM admins WHERE nick LIKE(?) AND passw LIKE(MD5(?))",array($login,$passw),'rowassoc');
		if($q && sizeof($q)>0){
			if(!isset($_SESSION)){
				$url = URL::getInstance();
				$ppath = $url->getPrePath();
				// инициализация сессии
				session_set_cookie_params(
					0,
					(cms_side=='back' ? ($ppath ? join('/',$ppath) : '').'/'.vdir_admin.'/' : ''),
					(constant('win_os')?'':'.').$url->getHost()
				);
				session_name($this->session_name_admin);
				session_start();
			}
			$_SESSION['user'] = $q;
			return $q;
		}
	}
	return false;

}

public function logoutAdmin(){
	if(isset($_SESSION) && session_name() == $this->session_name_admin){
		session_destroy();
		return true;
	}
	return false;
}

}
?>