<?php
if(!defined('hwid')) { header('HTTP/1.1 404 Not Found'); die('Access denied!'); }

// Вывод ошибки 404 и прекращение вывода
function e404($mess=''){
	header('HTTP/1.1 404 Not Found');
	die($mess);
}

// Соединение частей path
if(!function_exists('path')){

	function path(){

		$a = func_get_args();
		$l = func_num_args();
		$ds = '/';//DIRECTORY_SEPARATOR;
		if(is_array($a[0])){
			$a = $a[0];
			$l = sizeof($a);
		}
		for($i=0;$l>$i;$i++){
            if($a[$i] === false){
                unset($a[$i]);
                continue;
            }
			$a[$i] = str_replace('\\',$ds,$a[$i]);
			if($i==0)	$a[$i] = rtrim($a[$i],'/ '.$ds);
			else		$a[$i] = trim($a[$i],'/ '.$ds);
		}
		return join($ds,$a);

	}
	if(!function_exists('make_path')){
		function make_path(){ $a = func_get_args(); return call_user_func_array('path', $a); }
	}

}

if (!function_exists('boolval')) {
        function boolval($val) {
                return (bool) $val;
        }
}

// Сжатие HTTP содержимого
function http_encoding(){

		$support_gzip = !(strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') === false);
		$support_deflate = !(strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') === false);
        $support = 0;
    
        $support = $support_gzip ? 1 : $support_deflate ? 2 : 0;
    
		if($support == 1) {
            
		    header("Content-Encoding: gzip");
			return 'gzencode';
            
		}elseif($support == 2){
            
			header("Content-Encoding: deflate");
			return'gzdeflate';
            
	  	}else return null;

}

// Проверка строк на соответствие шаблону

function is_email($str){ // проверка E-Mail
	if(!empty($str) && preg_match("~^[a-zA-Z0-9]+([\.\-_a-zA-Z0-9]+)*[a-zA-Z0-9]@[a-zA-Z0-9]((\.[\-a-zA-Z0-9])*[\-a-zA-Z0-9]+)*\.[a-zA-Z]{2,4}$~si", $str)) {
	return true; }else return false;
	}
function is_url($str,$auth='noauth'){ // проверка URL
	if($auth=='noauth') $exp="~^(?:(?:https?|ftp)://".
	"(?![a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)".
   	")?(?:(?:[a-z0-9-]{1,128}\.)+(?:[a-z]{2,4})|(?!0)(?:(?".
   	"!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&".
   	"?+=\~/-]*)?(?:#[^ '\"&<>]*)?$~i";
	else $exp="~^(?:(?:https?|ftp)://(?:[a-z0-9_-]{1,32}".
   	"(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:[a-z]{2,4})|(?!0)(?:(?".
   	"!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&".
   	"?+=\~/-]*)?(?:#[^ '\"&<>]*)?$~i";
	if(!empty($str) && preg_match($exp, $str)) {
	return true; }else return false;
	}
function is_zip($str){ // проверка ZipCode
	if(!empty($str) && preg_match("~^[0-9]{6}~", $str)) {
	return true; }else return false;
	}
function is_dnw($str){ // проверка D(+W)
	$str = strval($str);
	if(preg_match("~^[0-9]\w?~si", $str)) {
	return true; }else return false;
	}
function is_dow($str){ // проверка D|W
	$str = strval($str);
	if(preg_match("~^[0-9]|\w~si", $str)) {
	return true; }else return false;
	}
function isdig($str, $dig=0){ // проверка D с условиями длины
    if(!is_int($str) && !is_float($str) && !is_string($str)) return false;
	$str = strval($str);
	if($dig==0) $px="~^[0-9]+$~"; elseif($dig=='d') $px="~^\d+$~"; else $px="~^[0-9]{".$dig."}$~";
	if(preg_match($px, $str)) {
	return true; }else return false;
	}
function isfloat($str, $force=false){ // проверка D с плавающей запятой
	$str = strval($str);
	if($force==true) $px='~^[0-9]+(\.|,)[0-9]+$~'; else $px='~^[0-9]+((\.|,)[0-9]*)?$~';
	if(preg_match($px, $str)) {
	return floatval(str_replace(',','.',$str)); }else return false;
	}
function regexp($str, $exp){ // проверка RegExp
	if(preg_match($exp, $str, $ret)) {
	return $ret; }else return false;
	}

function in(){
    
    if(func_num_args() < 2) return false;
    
    $a = func_get_args();
    $search = $a[0];
    unset($a[0]);
    $a = array_values($a);
    
    return in_array($search, $a);
    
}

function is(&$var){
    
    if(!isset($var) || empty($var)) return false;
    return true;
    
}


// Транслит из русского в английский
function trans_re($str){
	$ru = array('А','Б','В','Г','Д','Е','Ё','Ж', 'З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч', 'Ш', 'Щ', 'Э','Ю', 'Я', 'Ъ','Ь','Ы',
	          'а','б','в','г','д','е','ё','ж', 'з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч', 'ш', 'щ', 'э','ю', 'я', 'ъ','ь','ы');
	$en = array('A','B','V','G','D','E','E','ZH','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','C','CH','SH','SH','E','JU','JA','', '', 'I',
	          'a','b','v','g','d','e','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sh','e','ju','ja','', '', 'i');
	$num = sizeof($ru);
	for($i=0;$i<$num;$i++){$str = str_replace($ru[$i], $en[$i], $str);}
	$str = trim($str);
	return $str;
}

// Превращение строки в простую последовательность символов
function simple_str($str,$rep_space='-', $except=''){
	$str = trans_re($str);
	$str = preg_replace(array('~\s+~','~[^a-z0-9_\-'.preg_quote($except).']~i'),array($rep_space,''),$str);
	return $str;
}

// Десериализация файла в переменную
function fdeserialize($fname){
	if(file_exists($fname)){
		if(!$fp = fopen($fname, 'rb')) return false;
		if(!$str = fread($fp,filesize($fname))) return false;
		@fclose($fp);
		if(!$ustr = unserialize($str)) return false;
		return $ustr;
	}else return false;
}

// Сериализация переменной в файл
function fserialize($fname,$data){
	if(file_exists($fname)) @unlink($fname);
	if(!$fm = @fopen($fname, 'wb')) return false;
	@rewind($fm);
	if(@fwrite($fm, serialize($data)))
	return true; else return false;
	@ftruncate($fm, ftell($fm));
	@fclose($fm);
}


// Достаём список файлов и каталогов
function getFD($dir, $get_files=true, $get_dirs=true, $tree=false, $recursive=true, $no_basedir=false){
	$dir = rtrim($dir,'/ ');
	$files = array();
	if(!$d = @dir($dir)) return false;
	else{
		while (false !==($f = $d->read())) {
			$add_files = array();
			if('.' == $f || '..' == $f || '.htaccess' == $f) continue;
			else{
				if(is_dir(path($dir,$f))){
					if($get_dirs) $files[] = $no_basedir ? $f : path($dir,$f);
					if($recursive) $add_files = getFD(path($dir,$f),$get_files,$get_dirs,$tree,$recursive);
					if(is_array($add_files) && sizeof($add_files)>0){
						if($tree) $files[] = $add_files;
						else $files = array_merge($files, $add_files);
					}else continue;
				}elseif($get_files && is_file(path($dir,$f))) $files[] = $no_basedir ? $f : path($dir,$f);
			}
		}
	$d->close();
	}
	return (sizeof($files)>0) ? $files : array();
}


if(!is_callable('json_encode') || !is_callable('json_decode')) include_once 'libs/JSON.php';

// если php не поддерживает упаковку в json
if(!is_callable('json_encode')){
	function json_encode($data) { return Services_JSON::encode($data); }
}

// если php не поддерживает распаковку из json
if(!is_callable('json_decode')){
	function json_decode($jdata) { return Services_JSON::decode($jdata); }
}

?>