<?php
// BACK
if(!defined('hwid') || !defined('cms_side') || cms_side!='back') { header('HTTP/1.1 404 Not Found',true,404); die('Fuck off!'); }

// Подключаем отладку
	$debug = debug::getInstance();	
	$debug->timeMarker('Начало side.php');

// Подключаем сообщения
	$m = Messages::getInstance();

// Подключаем работу с урлами
	$url = URL::getInstance('core');

// Подключаем утилитарный экземпляр работы с урлами
	$burl = URL::getInstance('back_util');
	$burl->set(loc);
	$burl->setRootPath(loc);
	$rpath = $burl->getPathSections('root');
	$burl->clear();
	define('rvdir_admin',path($rpath,vdir_admin));

// назначаем корневой путь в URL
	$url->setRootPath(path($url->getRootPath(),vdir_admin));

//подключаем языковой функционал
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

// шаблонизатор (view)
$tpl = TPL::getInstance('core');

$debug->timeMarker('tpl');

//define('mod_base',$url->renderAdminModBase());
define('admin_base',path(loc,rvdir_admin).'/');
define('active_base',path(admin_base,siteVersion).'/');

$tpl->assign('doc_base',loc);
$tpl->assign('rvdir_admin',rvdir_admin);
$tpl->assign('active_base',active_base);
$tpl->assign('side_path',side_path);

// инициализация сессии
/*session_set_cookie_params(0, ($rpath ? $rpath : '').'/'.vdir_admin.'/', (constant('win_os')?'':'.').$url->getHost());*/
session_name('hw_admin');
session_start();

$debug->timeMarker('После старта сессии');

// манипуляции с пользователями
$users = Users::getInstance();
$cur_admin = $users->admin();

if(!$cur_admin){ // если мы не авторизованы как администратор - требуем авторизации

	if(isset($_POST['hw_admin_name']) && isset($_POST['hw_admin_passw'])){

		$auth = $users->authorizeAdmin($_POST['hw_admin_name'], $_POST['hw_admin_passw']);
		if($auth){

			$url->delVar('logout');
			$url->setPath(rvdir_admin);
			$url->redirect();

		}else{

			$m->mess('Неправильный логин или пароль!','e');

		}

	}

	$tpl->display('login.tpl');
	
}else{ // если пользователь авторизован

	// Если админу надо срочно выйти :)
	if(isset($_REQUEST['logout'])){

		if($users->logoutAdmin()){

			$burl->delVar('logout');
			$burl->setPath(rvdir_admin);
			$burl->redirect();
            $burl->clear();

		}else{

			$m->mess('Ошибка выхода из системы!','e');

		}

	}

	// создание меню модулей
	$menu_modules_tmp = $conf->getMods(true);
	$menu_modules = array();
    
	if(sizeof($menu_modules_tmp)>0){

		foreach($menu_modules_tmp as $i=>$mod){

			if(isset($mod['use_in_back']) && $mod['use_in_back'] == 1 && $mod['path'] != 'default'){

				$mod['back_link'] = path(rvdir_admin,siteVersion,$mod['path'].'/');
			
				//if(isset($mod['ico'])) $mod['ico'] = path($rpath,$mod['ico']);
				$menu_modules[$mod['position']][] = $mod;
                
                $mod_tpls = path($mod['fpath'], 'back', 'tpl');
                if(file_exists($mod_tpls) && is_dir($mod_tpls))
                    $tpl->addTemplateDir($mod_tpls, $mod['path']);
                unset($mod_tpls);

			}
            if(isset($mod['back_tpl_plugins']) && $mod['back_tpl_plugins']){
                
                $mod_tpl_plugins = path($mod['fpath'], 'back', 'tpl', 'plugins');
                if(file_exists($mod_tpl_plugins) && is_dir($mod_tpl_plugins))
                    $tpl->addPluginsDir($mod_tpl_plugins);
                unset($mod_tpl_plugins);
                
            }

		}

	}
	unset($menu_modules_tmp);

	if(sizeof($menu_modules)>0){

		ksort($menu_modules,SORT_NUMERIC);
		function usort_mods($a,$b){

			return ($a['priority']<$b['priority']) ? 1 : -1;

		}
		foreach($menu_modules as $i=>$mod){

			usort($menu_modules[$i],'usort_mods');

		}

        $tpl->assignByRef('mmodules',$menu_modules);

	}
	
	$debug->timeMarker('Меню модулей');
	
	// Контроллер вывода бэка
	include_once 'view_controller.php';
	
	$view = backendView::getInstance();
	$view->activeSections($url->getPathSectionsArray('active'));
	$view->setSiteVersions();
	$view->useModule();

    // Если модуль не указан, то назначаем модуль по-умолчанию и перенаправляем на него
    if(!$view->getActiveSectionByIndex(0) && $view->getDefaultModuleName()){
        
        $burl->set(loc);
        $burl->setPath(path(rvdir_admin, siteVersion, $view->getDefaultModuleName()));
        $burl->redirect();
        $burl->clear();
        
    }
    
	$view->includeLink(path('/'.cmsBase, '/side/back/css/design.css'));
	$view->includeLink(path('/'.cmsBase, '/side/back/css/style.css'));
	$view->includeLink(path('/'.cmsBase, '/side/back/css/styleOLD.css'));
	$view->includeLink(path('/'.cmsBase, '/side/back/css/style-responsive.css'));
	$view->includeLink(path('/'.cmsBase, '/side/back/js/jquery-ui/jquery-ui.min.css'));
	$view->includeLink(path('/'.cmsBase, '/side/back/js/icheck/skins/all.css'));
    
	$view->includeScript(path('/'.cmsBase, '/side/back/js/jquery.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/jquery-ui/jquery-ui.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/jquery-migrate.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/bootstrap.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/modernizr.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/icheck/skins/icheck.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/jquery.scrollTo.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/jquery.timers.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/global.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/main.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/tinymce/tinymce.min.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/tinymce/init.js'));
	$view->includeScript(path('/'.cmsBase, '/side/back/js/scripts.js'));
    $view->showModulesMenu();
    
	$module_info = $view->getCurModuleInfo();

	$debug->timeMarker('Контроллер вывода бэка');
	
	$include_back_module = false;

	if($module_info['use_in_back'] && isset($module_info['fpath']) && !empty($module_info['fpath'])){

		$include_back_module = path($module_info['fpath'],'back','controller.php'); // Генерируем путь к контроллеру бэка

		if(file_exists($include_back_module)){
			
			// Назначение констант в помощь модулю
			define('mod_path',$module_info['fpath']);
			define('mod_base',path(loc,$module_info['base']));
			define('mod_back_path',path(mod_path,'back'));
			define('mod_back_base',path(mod_base,'back'));
			define('mod_back_url',path(loc,rvdir_admin,siteVersion,$module_info['path']));
			
			$tpl->assign('admin_base',admin_base);
			$tpl->assign('active_base',active_base);
			$tpl->assign('mod_path',mod_path);
			$tpl->assign('mod_base',mod_base);
			$tpl->assign('mod_back_path',mod_back_path);
			$tpl->assign('mod_back_base',mod_back_base);
			$tpl->assign('mod_back_url',mod_back_url);
//            print_r($tpl->getTemplateVars());
		
            if(isset($_REQUEST['form_action']) && !empty($_REQUEST['form_action'])){
            
                $actions_file = path(mod_back_path, 'action.'.simple_str($_REQUEST['form_action'], '_', '.').'.php');
                if(file_exists($actions_file)) include_once $actions_file;
                else $m->mess('Не удалось подключить обработчик входящих данных!', 'e');
                
            }
            
			include_once $include_back_module; // Подключаем основной контроллер бэка модуля
			
			$debug->timeMarker('Основной контроллер бэка модуля "'.$module_info['path'].'"');
			
		}

	}
	
	if(!$include_back_module) $m->mess('Модуль не найден!','e');
	
	// Рендеринг шаблона
	$view->render();
	$debug->timeMarker('Рендеринг шаблона');
	
}

?>