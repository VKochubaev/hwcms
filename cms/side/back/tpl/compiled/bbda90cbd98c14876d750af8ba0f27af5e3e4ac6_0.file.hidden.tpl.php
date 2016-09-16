<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:38
  from "D:\OpenServer\domains\hwcms\cms\modules\forms\back\tpl\default\hidden.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838ae460487_12194553',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bbda90cbd98c14876d750af8ba0f27af5e3e4ac6' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\forms\\back\\tpl\\default\\hidden.tpl',
      1 => 1473436168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838ae460487_12194553 (Smarty_Internal_Template $_smarty_tpl) {
?>
<input<?php if (count($_smarty_tpl->tpl_vars['_item']->value['_attr']) > 0) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_item']->value['_attr'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?> <?php if (!empty($_smarty_tpl->tpl_vars['v']->value)) {
echo $_smarty_tpl->tpl_vars['k']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}?>/>
<?php }
}
