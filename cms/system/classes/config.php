<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class Config {

private $conf = null;
private $vars = null;
private $all_vars = null;
private $mods = null;
private $back_mods = null;
private $front_mods = null;
private $tmp_vars = null;
static private $instance = null;

static function getInstance(){

	if (self::$instance == null){
		self::$instance = new Config();
	}
	return self::$instance;

}

private function __construct(){

	// Подключение и обработка конфига
	if(!$this->conf = parse_ini_file(path($_SERVER['DOCUMENT_ROOT'],'cms/config/config.ini'),true)) die('Error config load!');
	$this->conf['site']['loc'] = is_array($this->conf['site']['location']) ? $this->conf['site']['location'][0] : $this->conf['site']['location'];
    
//    chdir('..');
    
	define('loc', $this->conf['site']['loc']);
	define('path', $_SERVER['DOCUMENT_ROOT']);
	define('cmsBase', $this->conf['site']['cms_base']);
	define('cmsPath', path(path, cmsBase));
	define('sysPath', path(cmsPath, 'system'));
	define('modPath', path(cmsPath, 'modules'));
	define('modBase', path(loc, cmsBase, 'modules'));
	define('debug_mode', (boolean)$this->conf['site']['debug_mode']);
	define('use_redir2first', $this->conf['site']['redir_location_to_first']);

}

private function __clone(){}

public function getDB(){

	return $this->conf['DB'];

}

public function getVars(){

	$this->_loadSmallConf();
	return $this->vars;

}
    
public function getVar($varName){

    if(!is_string($varName)) return false;
	$this->_loadSmallConf();
    if(!isset($this->vars[$varName])) return false;
	return $this->vars[$varName];

}
    
public function getConfVar($varName){

    if(!is_string($varName)) return false;
	$this->_loadSmallConf();
    if(!isset($this->conf[$varName])) return false;
	return $this->conf[$varName];

}
    
public function setConfVar($varName, $varVal){
    
    if(!is_string($varName)) return false;
    if(isset($this->conf) && !is_null($this->conf)){
       
        $this->conf[$varName] =  $varVal;
        return true;
       
    }
    return false;
    
}

public function getMods($cache=true,$small=false){
	
	if($cache){
		if(!$mods = fdeserialize(path(cmsPath,'/tmp/_config_mods_'.($small?'small':'full').'_.ser'))){
			$this->_loadMods(false);
			fserialize(path(cmsPath,'/tmp/_config_mods_'.($small?'small':'full').'_.ser'),$this->mods);
		}else $this->mods = $mods;
	}else $this->_loadMods(false);
	return $this->mods;

}

public function getFrontMods(){

	$this->_loadMods(false);
	return $this->front_mods;

}

public function getBackMods(){

	$this->_loadMods(false);
	return $this->back_mods;

}
    
public function defineConstants(){

	if($this->vars && sizeof($this->vars)>0){
		foreach($this->vars as $var_name=>$var_val){
			if(!defined($var_name)){
				if(isdig($var_val)) $var_val = intval($var_val);
				elseif(isfloat($var_val)) $var_val = floatval($var_val);
				define($var_name,$var_val);
			}
		}
		return true;
	}
	return false;

}

public function clearFullConf($unlink=true){

	if($unlink) @unlink(path(cmsPath,'/tmp/_config_full_.ser'));
	$this->all_vars = null;
	
}

public function clearSmallConf($unlink=true){

	if($unlink) @unlink(path(cmsPath,'/tmp/_config_small_.ser'));
	$this->vars = null;
	
}

public function clearModsConf($unlink=true){

	if($unlink) @unlink(path(cmsPath,'/tmp/_config_mods_full_.ser'));
	$this->mods = null;
	$this->back_mods = null;
	$this->front_mods = null;
	
}

public function clearAllConf($unlink=true){

	if($unlink){
		@unlink(path(cmsPath,'/tmp/_config_full_.ser'));
		@unlink(path(cmsPath,'/tmp/_config_small_.ser'));
		@unlink(path(cmsPath,'/tmp/_config_mods_full_.ser'));
	}
	$this->vars = null;
	$this->all_vars = null;
	
}

private function _loadSmallConf($force=false){

	if(!$this->vars || $force){
		if($force || !$this->vars = fdeserialize(path(cmsPath,'/tmp/_config_small_.ser'))){
			$this->_loadFullConf(true);
			foreach($this->all_vars as $conf_sect){
				if(is_array($conf_sect)){
					foreach($conf_sect as $conf_var_name=>$conf_var){
						$this->vars[$conf_var_name] = $conf_var['value'];
					}
				}
			}
			$this->clearFullConf();
			$this->_saveSmallConf();
		}
	}

}

private function _loadFullConf($force=false){

	if($force || !$this->all_vars){
		if($force || !$this->all_vars = fdeserialize(path(cmsPath,'/tmp/_config_full_.ser'))){
			$this->all_vars = array();
			$this->all_vars['main'] = parse_ini_file(path(cmsPath,'/config/main.ini'),true);
			$this->_loadMods(true);
		}
		$this->_saveFullConf();
	}

}

private function _saveSmallConf(){

	if($this->vars && sizeof($this->vars)>0){
		return @fserialize(path(cmsPath,'/tmp/_config_small_.ser'),$this->vars);
	}
    return false;

}

private function _saveFullConf(){

	if(!$this->all_vars || sizeof($this->all_vars)<=0){
		$this->_loadFullConf(true);
	}
	return @fserialize(path(cmsPath,'/tmp/_config_full_.ser'),$this->all_vars);

}

private function _loadMods($and_load_conf=true,$small_mods=false){

	$this->mods = getFD(path(cmsPath,'modules'),false,true,false,false,true);
	if($this->mods && sizeof($this->mods)>0){
		foreach($this->mods as $i=>$mpath){
            
//			$i = $mpath;
			if(!file_exists(path(cmsPath,'modules',$mpath)) || !is_dir(path(cmsPath,'modules',$mpath))
			|| !file_exists(path(cmsPath,'modules',$mpath,'meta.ini'))){
				unset($this->mods[$i]);
				continue;
			}
            
			$mod = parse_ini_file(path(cmsPath,'modules',$mpath,'meta.ini'),true);
            
			if($mod && isset($mod['title']) && !empty($mod['title'])){
                
				$this->mods[$i] = array(
                    'path' => $this->mods[$i],
                    'base' => path(cmsBase, 'modules',$mpath),
                    'fpath' => path(cmsPath,'modules',$mpath),
                    'title' => $mod['title'],
                    'in_settings' => boolval($mod['use_in_settings']),
                    'default_in_back' => (isset($mod['default_in_back']) && $mod['default_in_back']) ? true : false,
                    'back_tpl_plugins' => isset($mod['back_tpl_plugins']) ? boolval($mod['back_tpl_plugins']) : false,
                    'front_tpl_plugins' => isset($mod['front_tpl_plugins']) ? boolval($mod['front_tpl_plugins']) : false
                );
                
				if(!$small_mods){
                    
					if($mod['use_in_back']){
                        
						$this->back_mods[] = $this->mods[$i];
						if(file_exists(path($this->mods[$i]['fpath'],'back/images/menu_ico.svg'))) $mod['menu_ico'] = path('/'.$this->mods[$i]['base'],'back/images/menu_ico.svg');
						elseif(file_exists(path($this->mods[$i]['fpath'],'back/images/menu_ico.png'))) $mod['menu_ico'] = path('/'.$this->mods[$i]['base'],'back/images/menu_ico.png');
						elseif(file_exists(path($this->mods[$i]['fpath'],'back/images/menu_ico.gif'))) $mod['menu_ico'] = path('/'.$this->mods[$i]['base'],'back/images/menu_ico.gif');
                        
						if(file_exists(path($this->mods[$i]['fpath'],'back/images/ico96.svg'))) $mod['ico96'] = path('/'.$this->mods[$i]['base'],'back/images/ico96.svg');
						elseif(file_exists(path($this->mods[$i]['fpath'],'back/images/ico96.png'))) $mod['ico96'] = path('/'.$this->mods[$i]['base'],'back/images/ico96.png');
						elseif(file_exists(path($this->mods[$i]['fpath'],'back/images/ico96.gif'))) $mod['ico96'] = path('/'.$this->mods[$i]['base'],'back/images/ico96.gif');
                        
					}
					if($mod['use_in_front']) $this->front_mods[] = $this->mods[$i];
                    
					$this->mods[$i] = array_merge($this->mods[$i],$mod);
                    
					if($and_load_conf && file_exists(path(getcwd(),'modules',$mpath,'config.ini')) && $mpath!='main'){
						$this->all_vars[$mpath] = parse_ini_file(path(cmsPath,'modules',$mpath,'config.ini'),true);
					}
                    
				}
                
			}
            
		}
        
		$this->mods = array_values($this->mods);

	}

}
	
}
?>