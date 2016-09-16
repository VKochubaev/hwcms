<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:38
  from "D:\OpenServer\domains\hwcms\cms\modules\forms\back\tpl\default\tarea.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838ae379cd7_34413134',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '00d809dcf27f4d8eee2d88b8a76678a9bf0c2925' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\forms\\back\\tpl\\default\\tarea.tpl',
      1 => 1473436168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838ae379cd7_34413134 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="field clear"><label><?php echo $_smarty_tpl->tpl_vars['_item']->value['_attr']['title'];?>
</label><br/>
<textarea<?php if (count($_smarty_tpl->tpl_vars['_item']->value['_attr']) > 0) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_item']->value['_attr'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?> <?php if (!empty($_smarty_tpl->tpl_vars['v']->value) && $_smarty_tpl->tpl_vars['k']->value != 'value') {
echo $_smarty_tpl->tpl_vars['k']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}?>><?php echo $_smarty_tpl->tpl_vars['_item']->value['_attr']['value'];?>
</textarea></div>
<?php }
}
