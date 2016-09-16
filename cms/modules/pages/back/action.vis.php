<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='pages') { header('HTTP/1.1 404 Not Found'); die('{errors:[""]}'); }

        if(isdig($_POST['data']) && in_array($_POST['subaction'], array(0,1))){
            
            $db = DB::getInstance();
            $db->transactionBegin();
            $type = array(
                0 => 'спрятана',
                1 => 'стала видимой',
            );

            try{
                
                $ret1 = $db->query("UPDATE `pages` SET `vis`=?i WHERE `page_id`=?i", array($_POST['subaction'], $_POST['data']), 'ar');
                if($ret1 !== false){

                    $db->transactionCommit();
                    $output->data(array(
                        'reload_page_by_sel' => '#pagesListForm tr[data-page="'.$_POST['data'].'"] td.mark-actvis',
                        'message' => 'Страница id'.$_POST['data'].' '.$type[intval($_POST['subaction'])].'.'
                    ));
                    $output->success();

                }else $output->error(2, 'Не получилось изменить видимость страницы!');
                if($output->errorsCnt() > 0) $db->transactionRollback();
                
            }catch(goDBQuery $e){
                
                $db->transactionRollback();
                
            }
            
        }else $output->error(1, 'Ошибка входных данных!');
