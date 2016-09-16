<?php
function smarty_function_display($params, $template){
	
	$m = Messages::getInstance('core');
	
	if(!isset($params['tpl']) || empty($params['tpl'])) $m->mess('Не назначено имя шаблона!','e');
	else{

		$tpl = TPL::getInstance('core');
		
		$tpl_file = $tpl->getTPL($params['tpl']);

		if ($tpl_file) $tpl->display($tpl_file);
		else $m->mess('Шаблон не определён!','e');

		$m->display(null, null, 'incontent-mess');

	}
	
}
?>