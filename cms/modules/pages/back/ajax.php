<?php
if(!defined('hwid') || !defined('cms_side') || cms_side!='back' || !defined('back_cur_module') || back_cur_module!='pages') { header('HTTP/1.1 404 Not Found'); die('{errors:[""]}'); }

echo 'Default page ajax action file.';

?>