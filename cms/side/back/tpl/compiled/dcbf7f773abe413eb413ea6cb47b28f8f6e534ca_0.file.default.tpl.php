<?php
/* Smarty version 3.1.30, created on 2016-09-16 09:55:26
  from "D:\OpenServer\domains\hwcms\cms\modules\filemanager\back\tpl\default.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57db975eb90cd4_84096912',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dcbf7f773abe413eb413ea6cb47b28f8f6e534ca' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\filemanager\\back\\tpl\\default.tpl',
      1 => 1474008575,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57db975eb90cd4_84096912 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript" charset="utf-8">
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $(document).ready(function() {
        $('#elfinder').elfinder({
            url : '<?php echo $_smarty_tpl->tpl_vars['mod_back_base']->value;?>
/elFinder/php/connector.php', lang: 'ru'
        });
    });
<?php echo '</script'; ?>
>

<div id="elfinder"></div><?php }
}
