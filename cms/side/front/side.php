<?php
// FRONT
if(!defined('hwid') || !defined('cms_side') || cms_side!='front') { header('HTTP/1.1 404 Not Found'); die('Access denied on side inclusion!'); }

// инициализация сессии
session_set_cookie_params(0, '/', (constant('win_os')?'':'.').$url->getHost());
session_name('hw_user');
session_start();

$furl = URL::getInstance('front_util');
$furl->set(loc);

$url = URL::getInstance('core');
$url->set();

//подключаем языковой функционал
include_once path(sysPath, 'classes', 'siteversions.php');
$siteVer = SiteVersions::getInstance();

// проверяем является ли первая активная секция языковым идентификатором
$active_path = $url->getPathSectionsArray('active');
$siteVersion = false;
if(sizeof($active_path)>0){
	$siteVersion = $siteVer->getVersion($active_path[0]);
    // если первая активная секция является языковым идентификатором фиксируем это и переназначаем корневой путь url
	if($siteVersion){
		define('siteVersion',$siteVersion['version_id']);
		$url->setRootPath(path($url->getRootPath(),$siteVersion['version_id']));
	}
}
if(!$siteVersion){
	$siteVersion = $siteVer->getDefaultVersion();
	if($siteVersion) define('siteVersion',$siteVersion['version_id']);
//	$furl->set(loc);
//	$furl->setPath(path(rvdir_admin,$language['version_id']));
//	$furl->redirect();
}

// шаблонизатор
include_once path(sysPath, 'classes', 'tpl.php');
$tpl = TPL::getInstance('core');

$debug->timeMarker('tpl');

//print_r($url->getStructure());

$tpl->display('main.tpl');

?>