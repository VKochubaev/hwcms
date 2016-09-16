<?php
// AJAX BACK
if(!defined('hwid') || !defined('cms_side') || cms_side!='back') { header('HTTP/1.1 404 Not Found',true,404); die('Fuck off!'); }

// Подключаем работу с урлами
	$url = URL::getInstance('core');

// Подключаем утилитарный экземпляр работы с урлами
	$burl = URL::getInstance('back_util');
	$burl->set(loc);
	$burl->setRootPath(loc);
	$rpath = $burl->getPathSections('root');
	$burl->clear();
	define('rvdir_admin',path($rpath,vdir_admin));

// Назначаем корневой путь в URL
	$url->setRootPath(path($url->getRootPath(),vdir_admin));

// Подключаем языковой функционал
	$siteVer = SiteVersions::getInstance();

// если языковая константа не назначена
if(!defined('siteVersion')){

	// проверяем является ли первая активная секция языковым идентификатором
	$active_path = $url->getPathSectionsArray('active');
    //	print_r($active_path);
	$siteVersion = false;
	if(sizeof($active_path)>0){

		$siteVersion = $siteVer->getVersion($active_path[0]);
		// если первая активная секция является языковым идентификатором - фиксируем это и переназначаем корневой путь url
		if($siteVersion){

			define('siteVersion',$siteVersion['version_id']);
			$url->setRootPath(path($url->getRootPath(),$siteVersion['version_id']));

		}

	}

    // если первая активная секция не является языковым идентификатором - перенаправляем на правильный адрес
	if(!$siteVersion){

		$siteVersion = $siteVer->getDefaultVersion();
		$burl->set(loc);
		$burl->setPath(path(rvdir_admin,$siteVersion['version_id']));
		$burl->redirect();
        $burl->clear();

	}

}

///////////////////////////

$output = new Output('ret');
$output->mode('json');

///////////////////////////

//define('mod_base',$url->renderAdminModBase());
define('admin_base',path(loc,rvdir_admin).'/');
define('active_base',path(admin_base,siteVersion).'/');

// Инициализация сессии
/*session_set_cookie_params(0, ($rpath ? $rpath : '').'/'.vdir_admin.'/', (constant('win_os')?'':'.').$url->getHost());*/
session_name('hw_admin');
session_start();

// Манипуляции с пользователями
$users = Users::getInstance();
$cur_admin = $users->admin();

if(!$cur_admin){ // если мы не авторизованы как админ - требуется авторизация админа

	$output->error(0,'Not authorised!');
	
}else{ // если пользователь авторизован

	// Если админу надо срочно выйти :)
	if(isset($_REQUEST['logout'])){

		if($users->logoutAdmin()){

			$burl->delVar('logout');
			$burl->setPath(rvdir_admin);
			$burl->redirect();
            $burl->clear();

		}else{

			$output->error(0,'Ошибка выхода из системы!');

		}

	}

	// Контроллер вывода бэка
	include_once 'view_controller.php';
	
	$view = backendView::getInstance();
	$view->activeSections($url->getPathSectionsArray('active'));
	$view->setSiteVersions();
	$view->useModule();
    
	$module_info = $view->getCurModuleInfo();

	$include_back_module = false;

	if($module_info['use_in_back'] && isset($module_info['fpath']) && !empty($module_info['fpath'])){

		$include_back_module = path($module_info['fpath'],'back',
        (isset($_POST['action']) && !empty($_POST['action']))
            ? 'action.'.simple_str($_POST['action']).'.php'
            :'ajax.php'
        ); // Генерируем путь к ajax контроллеру бэка

		if(file_exists($include_back_module)){
			
			// Назначение констант в помощь модулю
			define('mod_path',$module_info['fpath']);
			define('mod_base',path(loc,$module_info['base']));
			define('mod_back_path',path(mod_path,'back'));
			define('mod_back_base',path(mod_base,'back'));
			define('mod_back_url',path(loc,rvdir_admin,siteVersion,$module_info['path']));
		
			include_once $include_back_module; // Подключаем основной контроллер бэка модуля
			
		}

	}
	
	if(!$include_back_module) $output->error(1, 'Модуль не найден!');
	
	// Вывод данных в JSON
	$output->render();
	
}


?>