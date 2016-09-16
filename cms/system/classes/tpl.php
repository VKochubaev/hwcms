<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

include_once 'libs/smarty/Autoloader.php';
Smarty_Autoloader::register();

class TPL extends Smarty {

static private $instance = array();
private $tpl_stack = array();

static function getInstance($init_id='core'){

	if (!isset(self::$instance[$init_id]) || self::$instance[$init_id] == null){
		
		$siteVersionSuffix = (constant('cms_side')!='back' && defined('siteVersion')) ? '/'.constant('siteVersion') : '';
		
		self::$instance[$init_id] = new self();
		
		self::$instance[$init_id]->setTemplateDir(path(cmsPath,'side',cms_side,'tpl'.$siteVersionSuffix));
		self::$instance[$init_id]->setCompileDir(path(cmsPath,'side',cms_side,'tpl/compiled'.$siteVersionSuffix));
		self::$instance[$init_id]->setConfigDir(path(cmsPath,'side',cms_side,'tpl/configs'));
		self::$instance[$init_id]->setCacheDir(path(cmsPath,'side',cms_side,'tpl/cache'.$siteVersionSuffix));
		self::$instance[$init_id]->left_delimiter = tpl_ldelim;
		self::$instance[$init_id]->right_delimiter = tpl_rdelim;
		self::$instance[$init_id]->caching = tpl_caching==1 ? true : false;
		self::$instance[$init_id]->compile_check = tpl_compile_check==1 ? true : false;
		self::$instance[$init_id]->debugging = tpl_debugging==1 ? true : false;
		
		self::$instance[$init_id]->addPluginsDir(path(cmsPath,'side',cms_side,'tpl/plugins'));
        
        // Подключаем ресурс page
        self::$instance[$init_id]->registerResource('page', new SmartyResourcePage());
	  
	}
	return self::$instance[$init_id];

}
    
public function pushTPL($tpl_name, $tpl_path) {
	
	if(empty($tpl_name) || empty($tpl_path)) return false;
	$this->tpl_stack[$tpl_name] = $tpl_path;
	return $this->tpl_stack[$tpl_name];

}

public function getTPL($tpl_name) {

    if(empty($tpl_name) || !isset($this->tpl_stack[$tpl_name])) return false;
	return $this->tpl_stack[$tpl_name];

}
    
}

// Ресурс "page" позволяет открывать материал страницы по её пути (about_us/news)
class SmartyResourcePage extends Smarty_Resource_Custom {

    protected $db;

    public function __construct() {

        try {
            $this->db = DB::getInstance('smarty');
        } catch (goDBException $e) {
            throw new SmartyException('Mysql Resource failed: ' . $e->getMessage());
        }
        
    }
    
    /**
     * Fetch a template and its modification time from database
     *
     * @param string $name template name
     * @param string $source template source
     * @param integer $mtime template modification timestamp (epoch)
     * @return void
     */
    protected function fetch($name, &$source, &$mtime)
    {
        $name = trim($name, '/ ');
        $row = $this->db->query("SELECT `mdate`, `body` FROM `pages` WHERE `page_path`=? LIMIT 1", array($name), 'rowassoc');
        if ($row) {
            $source = $row['body'];
            $mtime = strtotime($row['mdate']);
        } else {
            $source = null;
            $mtime = null;
        }
    }
    
    /**
     * Fetch a template's modification time from database
     *
     * @note implementing this method is optional. Only implement it if modification times can be accessed faster than loading the comple template source.
     * @param string $name template name
     * @return integer timestamp (epoch) the template was modified
     */
    protected function fetchTimestamp($name)
    {
        $name = trim($name, '/ ');
        $mtime = $this->db->query("SELECT `mdate` FROM `pages` WHERE `page_path`=? LIMIT 1", array($name), 'el');
        return strtotime($mtime);
    }
}

?>