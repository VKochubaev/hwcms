<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='pages') { header('HTTP/1.1 404 Not Found'); die(); }

/************************
Сохранение страницы
************************/

$m = Messages::getInstance();

if(isdig($_POST['page_id'])){
    
    if(in($_POST['page_act'], '1','2','0') && in($_POST['page_vis'], '1','0') && is($_POST['page_nick']) && is($_POST['page_title']) && is($_POST['page_body'])){

        $db = DB::getInstance();
        $db->transactionBegin();

        SEO::set('pages', $_POST['page_id'], $_POST);

        $pageUpd = $db->query("UPDATE `pages` SET `modules`=?, `act`=?i, `vis`=?i, `nick`=?, `page_path`=?, `title`=?, `body`=? ".
                             "WHERE `page_id`=?i", array(
                             '', $_POST['page_act'], $_POST['page_vis'], $_POST['page_nick'],
                             '', $_POST['page_title'], $_POST['page_body'], $_POST['page_id']
                             ), 'ar');

        if(!$pageUpd || $pageUpd<1){

            $db->transactionRollback();
            $m->mess('Не удалось сохранить страницу!','e');

        }else{

            $db->transactionCommit();
            $m->mess('Страница успешно сохранена','s');

        }
        
    }else $m->mess('Не корректные входные данные!','e');
    
}else $m->mess('Не указан или не корректный идентификатор страницы!','e');
