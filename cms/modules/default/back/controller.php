<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back') { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

$tpl->pushTPL('module_main_tpl',path($module_info['fpath'],'back','tpl','default.tpl'));

// Прячем меню модулей
$view->hideModulesMenu();

$view->moduleTitle(false);

$active_path = $url->getPathSectionsArray('active');

// Корректируем секции, если потребуется
if(isset($active_path[0]) && $active_path[0]=='default'){
	$url->removeActivePathSectionByIndex(0);
	$url->redirect();
}

?>