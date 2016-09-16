<?php

set_time_limit(0); 
error_reporting(0);
ini_set('max_file_uploads', 100);   // allow uploading up to 50 files at once

define('hwid', 1);
chdir($_SERVER['DOCUMENT_ROOT']);
include_once $_SERVER['DOCUMENT_ROOT'].'/cms/system/core.php';

// Session initialize
session_name('hw_admin');
session_start();

// Access for users
$users = Users::getInstance();
$cur_admin = $users->admin();
if(!$cur_admin) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

// Needed for case insensitive search to work, due to broken UTF-8 support in PHP
ini_set('mbstring.internal_encoding', 'UTF-8');
ini_set('mbstring.func_overload', 2);

if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set('Europe/Moscow');
}

// ElFinder autoload
require dirname(__FILE__).'/autoload.php';
// ===============================================


function access($attr, $path, $data, $volume, $isDir) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

/**
 * Access control example class
 **/
class elFinderTestACL {
	
	public function fsAccess($attr, $path, $data, $volume) {
		
		if ($volume->name() == 'localfilesystem') {
			return strpos(basename($path), '.') === 0
				? !($attr == 'read' || $attr == 'write')
				: $attr == 'read' || $attr == 'write';
		}
		
		return true;
	}
	
} // END class 

$acl = new elFinderTestACL();

function validName($name) {
	return strpos($name, '.') !== 0;
}

$opts = array(
	'locale' => 'ru_RU.UTF-8',
	'netVolumesSessionKey' => 'netVolumes',
	'bind' => array(
				'upload.pre mkdir.pre mkfile.pre rename.pre archive.pre ls.pre' => array(
					'Plugin.Normalizer.cmdPreprocess',
					'Plugin.Sanitizer.cmdPreprocess'
				),  
				'ls' => array(
					'Plugin.Normalizer.cmdPostprocess',
					'Plugin.Sanitizer.cmdPostprocess'
				),
				'upload.presave' => array(
					'Plugin.AutoResize.onUpLoadPreSave',
					'Plugin.Normalizer.onUpLoadPreSave',
					'Plugin.Sanitizer.onUpLoadPreSave'
				),
			),
			'plugin' => array(
				'AutoResize' => array(
					'enable' => true,
					'maxWidth'  => 1200,
					'maxHeight'  => 1200,
					'quality' => 95
				),
			
				'Normalizer' => array(
					'enable'    => true,
 					'nfc'       => true,
 					'nfkc'      => true,
 					'lowercase' => false,
					'convmap' => array(
						' ' => '_',
						',' => '_',
						'^' => '_',
						',' => '',
						'а' => 'a',
						'б' => 'b',
						'в' => 'v',
						'г' => 'g',
						'д' => 'd',
						'е' => 'e',
						'ё' => 'e',
						'ж' => 'zh',
						'з' => 'z',
						'и' => 'i',
						'й' => 'i',
						'к' => 'k',
						'л' => 'l',
						'м' => 'm',
						'н' => 'n',
						'о' => 'o',
						'п' => 'p',
						'р' => 'r',
						'с' => 's',
						'т' => 't',
						'у' => 'u',
						'ф' => 'f',
						'х' => 'h',
						'ц' => 'c',
						'ч' => 'ch',
						'ш' => 'sh',
						'щ' => 'sh',
						'ъ' => '',
						'ы' => 'y',
						'ь' => '',
						'э' => 'e',
						'ю' => 'u',
						'я' => 'ya',
						
					)
				),
				'Sanitizer' => array(
 				'enable' => true,
 				'targets'  => array('\\','/',':','*','?','"','<','>','|'), // Target chars
 				'replace'  => '_'    // Replace to this
 			),
	),
	'roots' => array(
		array(
			'driver'     => 'LocalFileSystem',
			'path'       => path($_SERVER['DOCUMENT_ROOT'], '/data/images/'),
			'startPath'  => path($_SERVER['DOCUMENT_ROOT'], '/data/images/'),
			'URL'        => '/data/images/',
			'alias'      => 'Изображения на сайте',
			'mimeDetect' => 'internal',
			'tmbPath'    => '.tmb',
			'imgLib'     => 'gd',
			'utf8fix'    => true,
			'tmbCrop'    => false,
			'tmbBgColor' => 'transparent',
			'accessControl' => 'access',
			'acceptedName'    => '/^[^\.].*$/',
			// 'disabled' => array('extract', 'archive'),
			// 'tmbSize' => 128,
			'uploadDeny'  => array(''),                // All Mimetypes not allowed to upload
			'uploadAllow' => array('image'),  // Mimetype `image` allowed to upload
			'uploadOrder' => array('deny', 'allow'),      // Allowed Mimetype `image` and `text/plain` only
			'copyOverwrite' => false,
		),
		array(
			'driver'     => 'LocalFileSystem',
			'path'       => path($_SERVER['DOCUMENT_ROOT'], '/data/files/'),
			'startPath'  => path($_SERVER['DOCUMENT_ROOT'], '/data/files/'),
			'URL'        => '/data/files/',
			'alias'      => 'Файлы для скачивания',
			'mimeDetect' => 'internal',
			'tmbPath'    => '.tmb',
			'imgLib'     => 'gd',
			'utf8fix'    => true,
			'tmbCrop'    => false,
			'tmbBgColor' => 'transparent',
			'accessControl' => 'access',
			'acceptedName'    => '/^[^\.].*$/',
			// 'disabled' => array('extract', 'archive'),
			// 'tmbSize' => 128,
			'uploadDeny'  => array('text'),                // Mimetypes not allowed to upload
			'uploadAllow' => array(''), // Mimetype allowed to upload
			'uploadOrder' => array('deny', 'allow'),     
			'copyOverwrite' => false,
		),
		
		// array(
		// 	'driver' => 'FTP',
		// 	'host' => '192.168.1.38',
		// 	'user' => 'dio',
		// 	'pass' => 'hane',
		// 	'path' => '/Users/dio/Documents',
		// 	'tmpPath' => '../files/ftp',
		// 	'utf8fix' => true,
		// ),	
	)	
);

header('Access-Control-Allow-Origin: *');
$connector = new elFinderConnector(new elFinder($opts), true);
$connector->run();

