<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back') { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

$tpl = TPL::getInstance('core');
$view = backendView::getInstance();
$view->includeLink('/side/back/css/style.css');
$module_info = $view->getCurModuleInfo();

switch(@$_GET['module_view']){

// Вывод списка блоков
case '': default:

	$view->sectionTitle('Список');
	$view->addAction('add_page','Добавить блок','add',array('module_view'=>'add_block'),'block_add_open_dialog');
	$view->setModuleTPL('default');

break;

// Добавление блока
case 'add_block':

	$view->sectionTitle('Добавление');
	$view->setModuleTPL('add');

break;

// Редактирование блока
case 'edit_block':

	$view->sectionTitle('Редактирование');
	$view->setModuleTPL('edit');

break;

}

?>