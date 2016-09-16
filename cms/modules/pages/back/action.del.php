<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='pages') { header('HTTP/1.1 404 Not Found'); die('{errors:[""]}'); }

        if(isdig($_POST['data'])){
            
            $pages = new Nodes('pages');
            $pages->loadNodes('pages', array('page_id'), 'page_id');
            $nodeId = $pages->getNodeIdByEntryId($_POST['data']);
            
            if($nodeId && $res = $pages->removeNode($nodeId)){
             
                if($res['deleted']){
                 
                    $output->success();
                    
                    $data = array();
                    $data['remove_by_sel'] = array('#pagesListForm tr.tColRow[data-id="'.$res['deleted'].'"]');
                    if(isset($res['deletedChields']) && sizeof($res['deletedChields'])>0){
                        
                        foreach($res['deletedChields'] as $nid){
                            $data['remove_by_sel'][] = '#pagesListForm tr.tColRow[data-id="'.$nid.'"]';
                        }
                        
                    }
                    $data['message'] = 'Ветка id'.$_POST['data'].' успешно удалена.';
                    
                    $output->data($data);
                    
                }
                
            }else $output->error(2, 'Ошибка удаления данных!');
            
        }else $output->error(1, 'Ошибка входных данных!');
