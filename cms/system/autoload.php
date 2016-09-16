<?php

class Autoload {

    private static $_lastLoadedFilename;
 
	public static function loadMainClasses($className){
		
		$class_file = path($_SERVER['DOCUMENT_ROOT'],'cms','system','classes',strtolower($className) . '.php');
		$interface_file = path($_SERVER['DOCUMENT_ROOT'],'cms','system','interfaces', strtolower($className) . '.php');
		if(!file_exists($class_file)){
            if(!file_exists($class_file)) return false;
            else  require_once($interface_file );
        }else require_once($class_file);

	}
	
}

spl_autoload_extensions ('.php');
spl_autoload_register(array('Autoload', 'loadMainClasses'));