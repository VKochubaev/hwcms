<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='pages') { header('HTTP/1.1 404 Not Found'); die('{errors:[""]}'); }

       if(isdig($_POST['data'])){
            
            $db = DB::getInstance();
            $db->transactionBegin();

            try{
                
                $ret1 = $db->query("UPDATE `pages` SET `def`='1' WHERE `page_id`=?i", array($_POST['data']), 'ar');
                if($ret1 !== false){

                    $ret2 = $db->query("UPDATE `pages` SET `def`='0' WHERE `page_id`!=?i", array($_POST['data']), 'ar');
                    if($ret2 !== false){
                        
                        $db->transactionCommit();
                        $output->data(array(
                            'reload_page_by_sel' => '#pagesListForm td.mark-def',
                            'message' => 'Страница id'.$_POST['data'].' назначена стартовой.'
                        ));
                        $output->success();
                        
                    }else $output->error(3, 'Ошибка обновления остальных записей!');

                }else $output->error(2, 'Ошибка обновления целевой записи!');
                if($output->errorsCnt() > 0) $db->transactionRollback();
                
            }catch(goDBQuery $e){
                
                $db->transactionRollback();
                
            }
            
        }else $output->error(1, 'Ошибка входных данных!');
