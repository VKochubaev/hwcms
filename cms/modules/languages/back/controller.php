<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='languages') { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

$view = backendView::getInstance();
$view->includeLink(path(mod_back_base, 'pages.css'));
$module_info = $view->getCurModuleInfo();
//print_r(get_defined_constants());

switch(@$_GET['module_view']){

// Вывод дерева страниц
case '': default:

	$view->sectionTitle('Список');
	$view->addAction('add_lang','Добавить язык','add',array('module_view'=>'add_lang'),'page_add_open_dialog');
	$view->setModuleTPL('default');

break;

// Добавление языка
case 'add_page':

	$form = new Form('add_page');
	
	$form->textField('Название0', 'title0');
	$g = $form->group('seo','SEO',null,false);
	$g->textField('Название1', 'title1');
	$g->textField('Название2', 'title2');
	$g->textField('Название3', 'title3');
	
	$form->assignStructureForTPL();
	
	$view->sectionTitle('Добавление языка');
	$view->setModuleTPL('add');

break;

// Редактирование языка
case 'edit_page':

	$view->sectionTitle('Редактирование языка');
	$view->setModuleTPL('edit');

break;

}

?>