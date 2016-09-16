<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='filemanager') { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

$view = backendView::getInstance();
$module_info = $view->getCurModuleInfo();
$view->showModulesMenu();

$view->setModuleTPL('default');

$view->includeLink(path(mod_back_base, 'elFinder/css/elfinder.min.css'));
$view->includeLink(path(mod_back_base, 'elFinder/css/theme.css'));


$view->includeScript(path(mod_back_base, 'elFinder/js/elfinder.min.js'));
$view->includeScript(path(mod_back_base, 'elFinder/js/i18n/elfinder.ru.js'));

//print_r($_SERVER);

?>