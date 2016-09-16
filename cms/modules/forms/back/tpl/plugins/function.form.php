<?php

function smarty_function_form($params, $template){
    
    $m = Messages::getInstance('core');
    
	if(!isset($params['id']) || empty($params['id'])) $m->mess('ID формы не указан!','e');
	else{

		$tpl = TPL::getInstance('core');

		$form_data = $tpl->getTemplateVars('form_data_'.$params['id']);

		$tpl_path = ($form_data && isset($form_data['tpl']) && !empty($form_data['tpl']))
			? path(cmsPath,'modules','forms','back','tpl',$form_data['tpl']) : path(cmsPath,'modules','forms','back','tpl','default');
		
		$tpl->assign('form_data__TEMP',$form_data);
		$tpl->display(path($tpl_path,'form.tpl'));
		$tpl->clearAssign('form_data__TEMP');
			

		$m->display();

	}

}

?>