<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class Messages {

private $mess = null;
private $group = false;
static private $instance = array();

static function getInstance($init_id='core'){

	if (!isset(self::$instance[$init_id]) || self::$instance[$init_id] == null){
		self::$instance[$init_id] = new self();
	}
	return self::$instance[$init_id];

}

private function __construct(){}

private function __clone(){}

public function useGroup($group=true){

	$this->group = $group ? true : false;
	if($this->group == true && sizeof($this->mess)>0 && !is_string(key($this->mess))){
		$tmp_mess = array();
		foreach($this->mess as $i=>$m){
			if(isset($m['type'])){
				if(!isset($tmp_mess[$m['type']])) $tmp_mess[$m['type']] = array();
				$tmp_mess[$m['type']][] = array(
					'type'=>$m['type'],
					'text'=>$m['text'],
					'errorno'=>$m['errorno'],
					'errorm'=>$m['errorm']
				);
			}
		}
		$this->mess = $tmp_mess;
		unset($tmp_mess);
	}elseif(sizeof($this->mess)>0 && is_string(key($this->mess))){
		$tmp_mess = array();
		foreach($this->mess as $ti=>$ta){
			if(sizeof($ta)>0){
				foreach($ta as $mi=>$ma){
					$tmp_mess[] = $ma;
				}
			}
		}
		$this->mess = $tmp_mess;
		unset($tmp_mess);
	}

}

public function mess($text, $type, $errorno=0, $errorm=''){

	$mess = array('type'=>$type,'text'=>$text,'errorno'=>$errorno,'errorm'=>$errorm);
	if($this->group == true){
		$this->mess[$type][] = $mess;
	}else{
		$this->mess[] = $mess;
	}

}

public function messSize(){
	
	if(!$this->mess || sizeof($this->mess)==0) return false;
	if($this->group == true){
		$count = 0;
		foreach($this->mess as $g){ $count = $count+sizeof($g); }
		return $count;
	}else return sizeof($this->mess);

}

public function display($t='messages.tpl', $id=null, $class=null){

	if($t === null) $t = 'messages.tpl';
    if($this->mess!=null && sizeof($this->mess)>0){
		if($this->group == true){
			$mess = array();
			foreach($this->mess as $gr=>$me){
				$mess = array_merge($mess,$me);
			}
		}else $mess = $this->mess;
		$tpl = TPL::getInstance();
		$tpl->assignByRef('messages',$mess);
		$tpl->assign('messages_id',$id);
		$tpl->assign('messages_class',$class);
		$tpl->display($t);
		return true;
	}
	return false;

}
    
public function clear(){

    $this->mess = null;
    return true;
    
}

}

?>