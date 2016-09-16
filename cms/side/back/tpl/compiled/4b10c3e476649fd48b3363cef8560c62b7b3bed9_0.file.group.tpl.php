<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:38
  from "D:\OpenServer\domains\hwcms\cms\modules\forms\back\tpl\default\group.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838ae09f4a2_82133042',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4b10c3e476649fd48b3363cef8560c62b7b3bed9' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\forms\\back\\tpl\\default\\group.tpl',
      1 => 1473436168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838ae09f4a2_82133042 (Smarty_Internal_Template $_smarty_tpl) {
?>
<fieldset<?php if (count($_smarty_tpl->tpl_vars['_item']->value['_attr']) > 0) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_item']->value['_attr'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?> <?php if ($_smarty_tpl->tpl_vars['k']->value == 'class') {
echo $_smarty_tpl->tpl_vars['k']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['v']->value;
if ($_smarty_tpl->tpl_vars['_item']->value['_state'] === true) {?> opened<?php } elseif ($_smarty_tpl->tpl_vars['_item']->value['_state'] === false) {?> closed<?php }?>"<?php } else {
if (!empty($_smarty_tpl->tpl_vars['v']->value)) {
echo $_smarty_tpl->tpl_vars['k']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"<?php }
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}?>>
<legend><?php echo $_smarty_tpl->tpl_vars['_item']->value['title'];?>
</legend>

<?php if (isset($_smarty_tpl->tpl_vars['_item']->value['_items']) && count($_smarty_tpl->tpl_vars['_item']->value['_items']) > 0) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_item']->value['_items'], 'gi');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['gi']->value) {
if (isset($_smarty_tpl->tpl_vars['gi']->value['_tpl'])) {
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['gi']->value['_tpl'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('_item'=>$_smarty_tpl->tpl_vars['gi']->value), 0, true);
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>

</fieldset>

<?php }
}
