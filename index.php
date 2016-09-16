<?php
define('hwid', 1); // Вводим константу-идентификатор

//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
error_reporting(E_ALL);

//chdir('cms');

include_once $_SERVER['DOCUMENT_ROOT'].'/cms/system/core.php'; // Подключаем ядро

if(http_encoding){
    
    if(ini_get('zlib.output_compression')){
        
        // i think its notig to do
        
    }elseif(preg_match('~gzip, deflate~i',$_SERVER['HTTP_ACCEPT_ENCODING'])){
        
        define('use_http_compression', true);
        ob_start(http_encoding()); // включение сжатие вывода
        
    }
    
}

// работа с URL
$url = URL::getInstance('core');

// eсли не правильный хост - корректируем его и переадресуем...
if(use_redir2first){
    $location_host = $url->set(loc)->structure['host'];
    $URL_cur = $url->getStructure('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    if($location_host != $_SERVER['HTTP_HOST']){
        $url->setHost($location_host);
        header('Location: '.$url->render(false).(!empty($URL_cur['fragment'])?'#'.$URL_cur['fragment']:''), 301);
        exit('Redirect to correct host.');
    }
}

$url->set();
$url->setRootPath(loc);

$debug->timeMarker('url');
	

// определение контроллера стороны вывода (front|back)
if(!defined('cms_side')){
    if($url){
        $uri_sections = $url->getPathSectionsArray('active');
//			print_r($uri_sections);
        define('cms_side',
            (defined('vdir_admin') && strlen(vdir_admin) > 0
        && sizeof($uri_sections) > 0 && $uri_sections[0] == vdir_admin)
            ? 'back' : 'front'
        );
    }else define('cms_side','front');
}

define('side_path',path(cmsPath,'side',cms_side));

$debug->timeMarker('side_toggle');

// подключение контроллера сторны вывода
	$cms_side_file = path(side_path,
        (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' && !isset($_REQUEST['not_ajax']))
        ? 'ajax.php' : 'side.php'
    );

	if(file_exists(side_path) && is_dir(side_path)
	&& file_exists($cms_side_file)){
        
		include_once $cms_side_file;
        
	}else exit('Requested side not found!');

$debug->timeStop();

$debug->render();

//if(defined('use_http_compression') && use_http_compression) ob_end_flush();

?>
