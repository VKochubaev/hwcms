<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back') { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class backendView {

	private $way = array();
	private $tabs = array();
	private $actions = array();
	private $page_nav = null;
	private $filters = null;
	private $use_module = null;
	private $tpl_path = null;
	private $mod_path = null;
	private $moduleInfo = null;
	private $moduleTitle = null;
    private $default_back_module = null;
	private $sectionTitle = null;
	private $active_sections = null;
	private $content = null;
	private $pre_content = null;
	private $post_content = null;
	private $tray = array();
	private $scripts = array();
	private $styles = array();
	private $trigers = array();

	static private $instance = null;

static function getInstance(){

	if (self::$instance == null){
	
			self::$instance = new self();

	}
	return self::$instance;

}

private function __construct(){

	$this->use_module = 'pages';
    $this->use_tpl = path(cmsPath,'modules', $this->use_module, 'back', $this->use_module.'.tpl');
	$this->trigers['show_modules_menu'] = true;

}

private function __clone(){}

// Очистка
public function clear(){

	$this->versions = array();
	$this->way = array();
	$this->tabs = array();
	$this->actions = array();
	$this->page_nav = null;
	$this->filters = null;
	$this->use_module = null;
	$this->tpl_path = null;
	$this->mod_path = null;
	$this->moduleInfo = null;
	$this->moduleTitle = null;
    $this->default_back_module = null;
	$this->sectionTitle = null;
	$this->active_sections = null;
	$this->content = null;
	$this->pre_content = null;
	$this->post_content = null;
	$this->tray = array();
	$this->scripts = array();
	$this->styles = array();
	$this->triggers = array();


}

// Назначение используемого модуля
public function useModule($tpl_name=false) {

	$numof_active_sections = sizeof($this->active_sections);
	$tpl_name = (!$tpl_name && $numof_active_sections>0) ? $this->active_sections[0] : $this->use_module;
	
    $tpl = TPL::getInstance();
    
	$use_tpl = 'file:['.$tpl_name.']default.tpl';;
	$tpl_path = path(cmsPath,'modules',$tpl_name,'back','tpl');
	$mod_path = path(cmsPath,'modules',$tpl_name,'back','view.php');
//	if(!file_exists($tpl_path) || !is_dir($tpl_path) ) return -1;
//	if(!$tpl->templateExists($use_tpl) ) return -2;
	if(!file_exists($mod_path) ) $mod_path = false;
	
	$conf = config::getInstance();
	$modules = $conf->getMods(true);
	
	$cur_module = false;
	foreach($modules as $i=>$mod){ 
		if(isset($mod['path']) && $mod['path'] == $tpl_name && $mod['use_in_back']){
			$cur_module = $mod;
		}
        if(isset($mod['default_in_back']) && $mod['default_in_back']) $this->default_back_module = $mod['path'];
	}
	if($cur_module){
		$this->tpl_path = $tpl_path;
		$this->mod_path = $mod_path;
		$this->use_module = $tpl_name;
		define('back_cur_module',$tpl_name);
		$this->use_tpl = $use_tpl;
		$this->moduleTitle($cur_module['title']);
		$this->moduleInfo = $cur_module;
		return $this->moduleInfo;
	}
	return 0;

}
    
public function getDefaultModuleName(){
    
    return is_null($this->default_back_module) ? false : $this->default_back_module;
    
}

// Информация о используемом модуле
public function getCurModuleInfo($key=null) {

	if(!$this->moduleInfo) return false;
	return is_null($key) ? $this->moduleInfo : (isset($this->moduleInfo[$key]) ? $this->moduleInfo[$key] : false);

}

// Назначение/получение актуальных секций
public function activeSections($arr=null){

	if(is_null($arr)) return $this->active_sections;
	else return ($this->active_sections = array_values($arr)) ? true : false;

}

// Берём актуальную секцию по индексу
public function getActiveSectionByIndex($index){
	
	if(!isdig($index)) return -1;
	return isset($this->active_sections[$index]) && !empty($this->active_sections[$index])
		? $this->active_sections[$index] : false;

}

// Назначение/получение заголовка секции
public function sectionTitle($str=null){

	if($str === null) return $this->sectionTitle;
    elseif($str === false){ $this->sectionTitle = null; return true; }
	else return ($this->sectionTitle = $str) ? true : false;

}

// Назначение/получение заголовка модуля
public function moduleTitle($str=null){

	if($str === null) return $this->moduleTitle;
    elseif($str === false){ $this->moduleTitle = null; return true; }
	else return ($this->moduleTitle = $str) ? true : false;

}

// Добавление действия
public function addAction($nick,$title,$ico=null,$href_vars=null,$item_id=null){

	if(!$nick || !$title) return false;
	$href = false;
	if(is_array($href_vars) && sizeof($href_vars)>0){
		$href = '?'.http_build_query($href_vars);
	}
	$this->actions[$nick] = array(
		'title'=>$title,
		'ico'=>$ico ? $ico : false,
		'href'=>$href ? $href : false,
		'item_id'=>$item_id ? $item_id : false
	);

}

// Добавление скрипта в шаблон
public function includeScript($src, $script_lang='javascript', $type='text/javascript'){

	$this->scripts[] = array('src'=>$src,'language'=>$script_lang,'type'=>$type);

}

// Добавление CSS в шаблон
public function includeLink($src, $rel='stylesheet', $type='text/css', $media='all'){

	$this->styles[] = array('src'=>$src, 'media'=>$media, 'rel'=>$rel, 'type'=>$type);

}

// Назначение языков
public function setSiteVersions($ver_array=null){
	
	if(is_null($ver_array)){
		$siteVer = SiteVersions::getInstance();
		$ver_array = $siteVer->getVersion();
	}elseif(!$ver_array) return false;
	return ($this->versions = $ver_array) ? true : false;

}

// Показать меню модулей
public function showModulesMenu(){

	$this->triggers['show_modules_menu'] = true;

}

// Спрятать меню модулей
public function hideModulesMenu(){

	$this->triggers['show_modules_menu'] = false;

}

// Назначение внутримодульного шаблона
public function setModuleTPL($tplname){

	if(empty($tplname)) return 0;
    $tpl = TPL::getInstance('core');
    
    $ftpl = $tpl->getTemplateDir($this->moduleInfo['path']);
    if(!$ftpl) return -1;
    
    $ftpl = 'file:['.$this->moduleInfo['path'].']'.$tplname.'.tpl';
    if(!$tpl->templateExists($ftpl)) return -2;
    
	$tpl->pushTPL('module_main_tpl',$ftpl);
	
}
    
// Назначение данных для шаблона
public function setTPLVars($varsArray){
    
    if(!is_array($varsArray) || sizeof($varsArray)==0) return false;
    $tpl = TPL::getInstance('core');
    foreach($varsArray as $varName=>&$varData){
       
       $tpl->assignByRef($varName, $varData); 
        
    }
    
}

// Вывод шаблона модуля
public function render(){

	$tpl = TPL::getInstance('core');

	$tpl->assignByRef('back_versions',	$this->versions);
	$tpl->assignByRef('back_module_title',	$this->moduleTitle);
	$tpl->assignByRef('back_section_title',	$this->sectionTitle);
	$tpl->assignByRef('back_actions', $this->actions);
	$tpl->assignByRef('back_tabs', $this->tabs);
	$tpl->assignByRef('back_scripts', $this->scripts);
	$tpl->assignByRef('back_styles', $this->styles);
	$tpl->assignByRef('back_content_tpl',	$this->use_tpl);
	$tpl->assignByRef('back_triggers',	$this->triggers);
	$tpl->display('main.tpl');
	$this->clear();
	
}

}

?>