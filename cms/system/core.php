<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

setlocale(LC_ALL, 'ru_RU.UTF8');
header('Content-Type: text/html; charset=utf-8');

if(is_callable('iconv')){

	@iconv_set_encoding('internal_encoding', 'UTF-8');
	@iconv_set_encoding('input_encoding', 'UTF-8');
	@iconv_set_encoding('output_encoding', 'UTF-8');

}

// базовые функции
include_once 'functions.php';

define('win_os', strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? true : false);
set_include_path(trim(get_include_path(),PATH_SEPARATOR).
	PATH_SEPARATOR . path($_SERVER['DOCUMENT_ROOT'], 'cms/system') .	
	PATH_SEPARATOR . path($_SERVER['DOCUMENT_ROOT'], 'cms/system/libs') .
	PATH_SEPARATOR . path($_SERVER['DOCUMENT_ROOT'], 'cms/system/libs/pear'));

// Автозагрузчик классов
include_once 'autoload.php';

// подгрузка конфига
include_once 'classes/config.php';
$conf = Config::getInstance();
$conf->getVars();
$conf->defineConstants();

// Инициализируем дебаг
$debug = Debug::getInstance();

$debug->timeStart('После секций functions, config');

?>