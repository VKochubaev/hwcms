<?php
function smarty_function_messages($params, $template){

	// Подключаем сообщения
	$m = Messages::getInstance('core');
	
	if($m->messSize()>0){
	
		$m->display();
	
	}
    $m->clear();

}
?>