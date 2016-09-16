<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class URL {

protected $input_url = null;
public $structure = null;
public $root_path = null;
protected $output_url = null;

static private $instance = array();

// инициализация
static function getInstance($init_id='core'){

	if (!isset(self::$instance[$init_id]) || self::$instance[$init_id] == null){
		self::$instance[$init_id] = new self();
	}
	return self::$instance[$init_id];

}

private function __construct(){}

private function __clone(){}

// Очистка
public function clear(){

	$this->input_url = null;
	$this->structure = null;
	$this->root_path = null;
	$this->output_url = null;
	return $this;

}
    
public function __destruct(){

    if(isset($this->init_id) && !is_null($this->init_id)) unset(self::$instance[$this->init_id]);

}
    
// Назначение URL адреса
public function set($url=false){

	$this->clear();
	$this->input_url = !$url ? 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] : $url;
	$this->structure = parse_url(urldecode($this->input_url));
	if(isset($this->structure['path']) && !empty($this->structure['path'])) $this->structure['path'] = preg_split('~[/\\\]~',trim($this->structure['path'],'/\\ '),0);
	if(isset($this->structure['path']) && sizeof($this->structure['path'])==1 && empty($this->structure['path'][0])) $this->structure['path'] = array();
	if(isset($this->structure['query']) && !empty($this->structure['query'])) parse_str($this->structure['query'], $this->structure['query']);
	else $this->structure['query'] = array();
	return $this;

}

// Назначение корневой части path
public function setRootPath($path){

	if(!$path) return false;
	return $this->root_path = $this->getPathSectionsArray('full',$path);
}

// Получение корневой части path в виде массива
public function getRootPathArray(){

	return $this->root_path;

}

// Получение корневой части path
public function getRootPath(){

	return '/'.path($this->root_path);

}

// Получение массив структуры URL
public function getStructure($url=false){
	
	if($url && !empty($url)) $this->set($url);
	return $this->structure;

}

// Назначение структуры URL
public function setStructure($arr,$return_render=false,$fragment=true){

	if(!isset($arr) || sizeof($arr)==0) return false;
	$this->structure = $arr;
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Получение хоста
public function getHost($url=false){
	
	if($url && !empty($url)) $this->set($url);
	return $this->structure['host'];

}

// Назначение хоста
public function setHost($str,$return_render=false,$fragment=true){

	if(!isset($str) || empty($str)) return false;
	$this->structure['host'] = $str;
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Назначение протокола
public function setScheme($str,$return_render=false,$fragment=true){

	if(!isset($str) || empty($str)) return false;
	$this->structure['scheme'] = $str;
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Назначение пути
public function setPath($str,$return_render=false,$fragment=true){

	if(!isset($str) || empty($str)) return false;
	$this->structure['path'] = preg_split('~[/\\\]~',trim($str,'/\\ '),0);
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Назначение имени пользователя
public function setUser($str,$return_render=false,$fragment=true){

	if(!isset($str) || empty($str)) return false;
	$this->structure['user'] = $str;
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Назначение пароля пользователя
public function setPass($str,$return_render=false,$fragment=true){

	if(!isset($str) || empty($str)) return false;
	$this->structure['pass'] = $str;
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Назначение строки запроса
public function setQuery($str,$return_render=false,$fragment=true){

	if(!isset($str) || empty($str)) return false;
	$str = urldecode($str);
	parse_str($str, $this->structure['query']);
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Назначение якоря
public function setFragment($str,$return_render=false,$fragment=true){

	if(!isset($str) || empty($str)) return false;
	$this->structure['fragment'] = $str;
	return $return_render ? $this->render($fragment) : $this->structure;

}

// Назначение переменных запроса из массива
public function setVars($vars){

	if(!$this->structure) return false;
	$url =& $this->structure;
	$vars = is_array($vars) ? $vars : array($vars);
	if(!isset($url['query'])) $url['query'] = array();
	if(is_array($vars) && count($vars)>0){
		$qvars =& $url['query'];
		foreach($vars as $vk=>$vv){ $qvars[$vk] = $vv; } 
		$url['query'] = $qvars;
	}
	$this->structure = $url;
	return $vars;

}

// Назначение переменных запроса
public function setVar(){

	$keys = func_get_args();
	if(sizeof($keys)>0){
		$ii = 0; $arr = array();
		foreach($keys as $i=>$k){
			if($i%2 == 0) $arr[$k] = '';
			else $arr[$keys[$i-1]] = $k;
		}
	}
	return $this->setVars($arr);

}

// Удаление переменных запроса (массив)
public function delVars($vars){

	if(!$this->structure) return false;
	$url =& $this->structure;
	$vars = is_array($vars) ? $vars : array($vars);
	if(!isset($url['query'])) $url['query'] = array();
	if(is_array($vars) && count($vars)>0){
		$qvars =& $url['query'];
		foreach($vars as $vv){ unset($qvars[$vv]); } 
		$url['query'] = $qvars;
	}
	$this->structure = $url;
	return $vars;

}

// Удаление переменных запроса
public function delVar(){
	$keys = func_get_args();
	return $this->delVars($keys);
}

// Оставить только указанные переменные запроса (массив)
public function leaveVars($vars){

	if(!$this->structure) return false;
	$url =& $this->structure;
	$vars = is_array($vars) ? $vars : array($vars);
	if(!isset($url['query'])) $url['query'] = array();
	if(is_array($vars) && count($vars)>0){
		$qvars =& $url['query'];
		$leave = array();
		foreach($vars as $lk=>$lv){ 
			if(!is_int($lk)) $leave[$lk] = $lv;
			elseif(isset($qvars[$lv])) $leave[$lv] = $qvars[$lv];
		} 
	}
	$url['query'] = $leave;
	$this->structure = $url;
	return $vars;

}

// Оставить только указанные переменные запроса
public function leaveVar(){
	$keys = func_get_args();
	return $this->leaveVars($keys);
}

// Возврашение частей пути по критерию (массив)
public function getPathSectionsArray($mode='full',$url=false){

	$url = $url ? parse_url($url) : $this->structure;
	if(!$url) return false;
	if(isset($url['path']) && !is_array($url['path'])) $url['path'] = preg_split('~[/\\\]~',trim($url['path'],'/ '),0);
	if(isset($url['path'])){
		switch($mode){
		default:
		case 'full':
			return $url['path'];
		break;
		case 'root':
			$rpath_size = @sizeof($this->root_path);
			$rpath = array();
			if($this->root_path && $rpath_size>0){
				foreach($this->root_path as $i=>$s){
					if( isset($this->structure['path'][$i])
					&& $this->structure['path'][$i]==$s ) $rpath[] = $s;
				}
			}
			return $rpath;
		break;
		case 'active':
			$apath_size = @sizeof($this->structure['path']);
			$apath = $this->structure['path'];
			if($this->root_path && $apath_size>0){
				foreach($apath as $i=>$s){
					if(!isset($this->root_path[$i])) continue;
					if($this->root_path[$i]==$s ){ unset($apath[$i]); $apath_size--; }
				}
			}
			return array_values($apath);
		break;
		}
	}
	return false;

}

// Возврашение путь по критерию [string]
public function getPathSections($mode='full',$url=false){

	return '/'.path($this->getPathSectionsArray($mode,$url));

}

// Назначение частей пути
public function setPathSections(){

	if(!$this->structure) return -1;
	$psect_num = func_num_args();
	if($psect_num>0){
		$psect = func_get_args();
		if(is_array($psect[0])) $psect = $psect[0];
		return $this->structure['path'] = $psect;
	}
	return false;

}

// Добавить секцию в начало пути
public function prependPathSection($sect){

	if(!$sect || empty($sect)) return -1;
	if(isset($this->structure['path'])) $path = preg_split('~[/\\\]~',trim($this->structure['path'],'/ '),0);
	else $path = array();
	array_unshift($path,urlencode($sect));
	return $this->structure['path'] = $path;

}

// Добавить секцию в конец пути
public function appendPathSection($sect){

	if(!$sect || empty($sect)) return -1;
	if(isset($this->structure['path'])) $path = $this->structure['path'];
	else $path = array();
	array_push($path,urlencode($sect));
	return $this->structure['path'] = $path;

}

// Замена секции пути по индексу
public function replacePathSection($sect, $index=0){

	if(!$sect || empty($sect) || !isdig($index)) return -1;
	$path = $this->structure['path'];
	if(isset($path[$index])) $path[$index] = urlencode($sect);
	elseif($index > sizeof($path)-1) array_push($path,urlencode($sect));
	else array_unshift($path,urlencode($sect));
	return $this->structure['path'] = $path;

}

// Удаление секции пути по индексу
public function removePathSectionByIndex($index){

	if(!is_int($index)) return -1;
	if(isset($this->structure['path'][$index])){
		unset($this->structure['path'][$index]);
		$this->structure['path'] = array_values($this->structure['path']);
		return true;
	}else return false;

}

// Удаление активной секции пути по индексу
public function removeActivePathSectionByIndex($index){

	if(!is_int($index)) return -1;
	$root = $this->getPathSectionsArray('root');
	$this->removePathSectionByIndex(sizeof($root)+$index);

}

// Удаление секции пути по значению
public function removePathSectionByValue($str, $only_first=false, $offset=0){

	if(empty($str)) return -1;
	$str = strval($str);
	if($offset>0){
		$path0 = array_slice($this->structure['path'], 0, intval($offset), false);
		$path  = array_slice($this->structure['path'], intval($offset), null, false);
	}else{
		$path = $this->structure['path'];
	}
	if($indexs = array_keys($path,$str)){
		foreach($indexs as $i=>$index){
			if(($only_first && $i==0) || !$only_first) unset($path[$index]);
		}
		$this->structure['path'] = $offset>0 ? array_merge($path0,$path) : $path;
		return true;
	}else return false;

}

// Удаление секции пути по значению
public function removeActivePathSectionByValue($str, $only_first=false){

	if(empty($str)) return -1;
	$root = $this->getPathSectionsArray('root');
	return $this->removePathSectionByValue($str, $only_first, sizeof($root));

}

// Вычитание секций пути
public function diffPathSections(){

	$args = func_get_args();
	$argsize = func_num_args();
	if($argsize == 2){
		$path = $args[0];
		$sects = $args[1];
	}elseif($argsize == 1){
		$path = $this->structure['path'];
		$sects = $args[0];
	}else return false;
	if(!$sects || !sizeof($sects)) return false;
	if(!is_array($path)) $sects = array($path);
	if(!is_array($sects)) $sects = array($sects);
	$tmpath = $path; $trowed = 0;
	foreach($sects as $sk=>$sv){
		if(isset($tmpath[$sk]) && $sv == $tmpath[$sk]){ unset($tmpath[$sk]); $trowed++; }
	}
	$tmpath = array_values($tmpath);
//echo sizeof($sects)." == ".$trowed;
	if(sizeof($sects) == $trowed) return $tmpath;
	else return $path;
}

// перенаправление по составленному url
public function redirect($http_code=null){

	if(!$this->structure) return false;
	if(!isset($this->structure['scheme']) || !$this->structure['scheme']) $this->setScheme('http'); 
	if(!isset($this->structure['host']) || !$this->structure['host']) $this->setHost($_SERVER['HTTP_HOST']); 
	header('Location: '.$this->render(), true, $http_code);
	exit();

}

// Рендринг url
public function render($fragment=true, $options=false){

	$final = '';
	if(!$options) $options = array('scheme','user_pass','host','port','path','query','fragment');
	
	if($fragment && isset($this->structure['fragment']) && strlen($this->structure['fragment'])>0) $this->structure['fragment'] = $fragment;
	
	if(!$this->structure || !is_array($this->structure) || count($this->structure)<1) return false;
	
	if(@in_array('scheme',$options) && isset($this->structure['scheme']) && !empty($this->structure['scheme']) && isset($this->structure['host']) && !empty($this->structure['host']))
		$final .= $this->structure['scheme'].'://';
	
	if(@in_array('user_pass',$options) && isset($this->structure['user']) && !empty($this->structure['user']))
		$final .= $this->structure['user'].(isset($this->structure['pass']) && !empty($this->structure['pass']) ? ':'.$this->structure['pass'] : '').'@';
	
	if(@in_array('host',$options) && isset($this->structure['host']) && !empty($this->structure['host']))
		$final .= $this->structure['host'].(@in_array('port',$options) && isset($this->structure['port']) && !empty($this->structure['port']) ? ':'.$this->structure['port'] : '');
	
	
	if(@in_array('path',$options) && isset($this->structure['path']) && is_array($this->structure['path']) && sizeof($this->structure['path'])>0)
		$final .= (isset($this->structure['host']) && !empty($this->structure['host']) ? '/' : '').join('/',$this->structure['path']).'/';
	
	elseif(@in_array('mod_path',$options) && isset($this->structure['path']) && is_array($this->structure['path']) && sizeof($this->structure['path'])>0) 
		$final .= path($this->getRootPath(),$this->getPathSections('active')).'/';
	
	
	if(@in_array('query',$options) && isset($this->structure['query']) && sizeof($this->structure['query'])>0){
		$qtmp = array();
		foreach($this->structure['query'] as $qk=>$qv){ $qtmp[] = urlencode($qk).'='.urlencode($qv); }
		$final .= '/?'.join('&',$qtmp);
	}
	
	if($fragment!==false && @in_array('fragment',$options) && isset($this->structure['fragment']) && !empty($this->structure['fragment']))
		$final .= '#'.$this->structure['fragment'];

	return $this->output_url = $final;

}

public function renderAdminModBase(){

	return $this->render(false,array('scheme','host','port','mod_path'));

}

}
?>