<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:37
  from "D:\OpenServer\domains\hwcms\cms\modules\forms\back\tpl\default\form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838adef7272_23903926',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '124d669dd04bc2d2cc3b5e86765156b9e44205d0' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\forms\\back\\tpl\\default\\form.tpl',
      1 => 1473436168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838adef7272_23903926 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['form_data__TEMP']->value['_attr']['title']) {?><h2><?php echo $_smarty_tpl->tpl_vars['form_data__TEMP']->value['_attr']['title'];?>
</h2><?php }?>
<form<?php if (count($_smarty_tpl->tpl_vars['form_data__TEMP']->value['_attr']) > 0) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['form_data__TEMP']->value['_attr'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?> <?php if (!empty($_smarty_tpl->tpl_vars['v']->value)) {
echo $_smarty_tpl->tpl_vars['k']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}?>>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['form_data__TEMP']->value['_items'], 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value) {
if (isset($_smarty_tpl->tpl_vars['i']->value['_tpl'])) {
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['i']->value['_tpl'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_item'=>$_smarty_tpl->tpl_vars['i']->value), 0, true);
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


</form>

<?php }
}
