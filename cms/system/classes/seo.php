<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

class SEO {
 
static public function get($context, $ids){
 
    if(empty($context)) return false;
    if(!is_array($ids)) $ids = array($ids);
    
    $db = DB::getInstance();   
    
    $seoData = $db->query("SELECT `seo_title`, `seo_atitle`, `seo_keyw`, `seo_descr` ".
                          "FROM `seo` WHERE `seo_context`=? AND `seo_context_id` IN(?li)",
                          array($context, $ids), 'assoc');
    return $seoData;
    
}
    
static public function set($context, $id, $data){
 
    if(empty($context) || !isdig($id)) return false;
    
    $db = DB::getInstance();   
    
    $seoLook = $db->query("SELECT COUNT(0) FROM `seo` WHERE `seo_context`=? AND `seo_context_id`=?i", array($context, $id), 'el');
    
    if($seoLook > 0){
        
        $fld = array();
        if(isset($_POST['seo_title'])) $fld['seo_title'] = $_POST['seo_title'];
        if(isset($_POST['seo_atitle'])) $fld['seo_atitle'] = $_POST['seo_atitle'];
        if(isset($_POST['seo_keyw'])) $fld['seo_keyw'] = $_POST['seo_keyw'];
        if(isset($_POST['seo_descr'])) $fld['seo_descr'] = $_POST['seo_descr'];
        
        $seoUpd = $db->query("UPDATE `seo` SET ?s WHERE `seo_context`=? AND `seo_context_id`=?i",
                       array($fld, $context, $id), 'ar');
        
        if(!$seoUpd) return false;
        
    }else{
        
        $seoIns = $db->query("INSERT INTO `seo` SET `seo_context`=?,`seo_context_id`=?i, `seo_title`=?n, `seo_atitle`=?n, `seo_keyw`=?n, `seo_descr`=?n",
                       array($context, $id, 
                             isset($_POST['seo_title']) ? $_POST['seo_title'] : null,
                             isset($_POST['seo_atitle']) ? $_POST['seo_atitle'] : null,
                             isset($_POST['seo_keyw']) ? $_POST['seo_keyw'] : null,
                             isset($_POST['seo_descr']) ? $_POST['seo_descr'] : null
                        ), 'id');
        
        if(!$seoIns) return false;
        
    }
    
    $seoData = $db->query("SELECT * ".
               "FROM `seo` WHERE `seo_context`=? AND `seo_context_id`=?i",
               array($context, $id), 'assoc');
    
    return $seoData;
    
}
    
}