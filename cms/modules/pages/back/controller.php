<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='pages') { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

$view = backendView::getInstance();
$module_info = $view->getCurModuleInfo();
$view->showModulesMenu();

$db = DB::getInstance();
$m = Messages::getInstance();

switch(@$_GET['module_view']){

        
        
// Вывод дерева страниц
case '': default:

	$view->setModuleTPL('default');
    $view->sectionTitle('Управление созданными разделами и страницами сайта');
	$view->addAction('add_page', 'Создать страницу', 'plus', array('module_view'=>'add_page'));

	$pages = new Nodes('pages');
	$pages->loadNodes('pages', array('page_id','act','vis','def','nick','page_path','title'), 'page_id');
	$struct = $pages->exportFlat('_id', '_parent', true, false);
    $view->setTPLVars(array('pages'=>&$struct));

break;

        
        
// Добавление страницы
case 'add_page':

	$view->setModuleTPL('add');
        
    $form = Modules::getClass('Forms', 'Form', array('id' => 'add_page'));
	
	$form->openGroup('main','Основное',null,false);
        
		$form->textField('Заголовок страницы', 'page_title', '', true);
		$form->textField('Псевдоним Для URL', 'page_nick');
		
		$parents_tree = array();
		$parents = new Nodes('pages');
		$parents->loadNodes('pages', array('page_id'=>'id','title'), 'page_id');
		$parents_tree = $parents->exportTree('node_id', 'parent_node', '_tree', false, false);
        
        $defaultParent = 0;
        if(isset($_GET['parent']) && isdig($_GET['parent'])){

            $db = DB::getInstance();
            $parentLoockup = $db->query("SELECT p.`title`, p.`page_id` FROM `pages` p ".
                                        "LEFT JOIN `nodes` n ON p.`node_id`=n.`node_id` ".
                                        " WHERE n.`node_id`=?i", array($_GET['parent']), 'rowassoc');
            if($parentLoockup !== false){
                
                $defaultParent = $_GET['parent'];
                $view->sectionTitle('Добавление дочерней страницы для &quot;'.$parentLoockup['title'].'&quot; (id'. $parentLoockup['page_id'].')');
                    
            }
            
        }
        if($defaultParent == 0){

            $view->sectionTitle('Добавление страницы');

        }
        
		if($parents_tree) $form->branchSelect('Родительский раздел', 'page_parent', $defaultParent, true, $parents_tree);
		
		$form->textArea('Содержание страницы', 'page_body', '', false, null, 'text-editor', '100%', 200);
        
	$form->closeGroup();
	$form->openGroup('other','Дополнительно',null,false);
        
		$form->selectField('Активность', 'page_act', 1, true, array('Включена для всех'=>1, 'Включена для зарег. пользователей'=>2, 'Выключена'=>0));
		$form->selectField('Видимость', 'page_vis', 1, true, array('Включена'=>1, 'Выключена'=>0));
		$form->intField('Очередь в разделе', 'page_ord', 0, false);
        
	$form->closeGroup();
	$form->openGroup('seo','SEO',null,false);
        
		$form->textField('Заменять заголовок страницы', 'seo_title');
		$form->textField('Title на ссылках', 'seo_atitle');
		$form->textArea('Ключевые слова', 'seo_keyw', '', false, null, null, 300, 100);
		$form->checkBox('Дописывать к основному набору', 'seo_keyw_add', 1, true);
		$form->textArea('Описание', 'seo_descr', '', false, null, null, 300, 100);
		$form->checkBox('Дописывать к основному набору', 'seo_descr_add', 1, true);
        
	$form->closeGroup();
        
        $form->submitButton('Создать страницу', 'add_btn');
        $form->resetButton('Очистить поля', 'reset_btn');
		
	$form->assignStructureForTPL();
	
break;

        
        
// Редактирование страницы
case 'edit_page':

    $view->setModuleTPL('edit');
    
    if(isset($_REQUEST['id']) && isdig($_REQUEST['id'])){
        
        $page = $db->query("SELECT `p`.*, `s`.*, n.`node_id`, n.`parent_id`, n.`node_ord` AS ord ".
                            "FROM `pages` p ".
                            "LEFT JOIN `nodes` n ON p.`node_id`=n.`node_id` ".
                            "LEFT JOIN `seo` s ON s.`seo_context`='pages' AND s.`seo_context_id`=p.`page_id` ".
                            "WHERE p.`page_id`=?i LIMIT 1", array($_REQUEST['id']), 'rowassoc');

        if($page !== false){
        
            $form = Modules::getClass('Forms', 'Form', array('id' => 'edit_page', 'action' => mod_back_url.'/', 'data-ajax-action' => 'save-page'));

            $view->sectionTitle('Редактирование страницы &quot;'.$page['title'].'&quot; (id'.$page['page_id'].')');
            
                $form->submitButton('Сохранить страницу', 'add_btn');
                $form->resetButton('Очистить поля', 'reset_btn');
            
            $form->openGroup('main','Основное',null,false);
            
                $form->textField('Заголовок страницы', 'page_title', $page['title'], true);
                $form->textField('Псевдоним Для URL', 'page_nick', $page['nick']);

                $parents_tree = array();
                $parents = new Nodes('pages');
                $parents->loadNodes('pages', array('page_id'=>'id','title'), 'page_id');
//                print_r($parents->subtractNode($page['node_id']));
                $parents_tree = $parents->exportTree('node_id', 'parent_node', '_tree', false, false);

                if($parents_tree) $form->branchSelect('Родительский раздел', 'page_parent', $page['parent_id'], true, $parents_tree, $page['node_id']);

                $form->textArea('Содержание страницы', 'page_body', $page['body'], false, null, 'text-editor', '100%', 200);
            
            $form->closeGroup();
            $form->openGroup('other','Дополнительно',null,false);
            
                $form->selectField('Активность', 'page_act', $page['act'], true, array('Включена для всех'=>1, 'Включена для зарег. пользователей'=>2, 'Выключена'=>0));
                $form->selectField('Видимость', 'page_vis', $page['vis'], true, array('Включена'=>1, 'Выключена'=>0));
                $form->intField('Очередь в разделе', 'page_ord', $page['ord'], false);
            
            $form->closeGroup();
            $form->openGroup('seo','SEO',null,false);
            
                $form->textField('Заменять заголовок страницы', 'seo_title', $page['seo_title']);
                $form->textField('Title на ссылках', 'seo_atitle', $page['seo_atitle']);
                $form->textArea('Ключевые слова', 'seo_keyw', $page['seo_keyw'], false, null, null, 300, 100);
                $form->textArea('Описание', 'seo_descr', $page['seo_descr'], false, null, null, 300, 100);
            
            $form->closeGroup();
                
                $form->hidden('page_id', $page['page_id']);
                $form->hidden('form_action', 'page.save');
                $form->submitButton('Сохранить страницу', 'add_btn');
                $form->resetButton('Очистить поля', 'reset_btn');

            $form->assignStructureForTPL();
        //print_r($tpl->getTemplateVars());
        }else $m->mess('Ошибка получение информации о странице!', 'e');
        
    }

break;

}

?>