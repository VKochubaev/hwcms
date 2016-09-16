<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:38
  from "D:\OpenServer\domains\hwcms\cms\modules\forms\back\tpl\default\select.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838ae4066f0_31480517',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '80fb929121f576150b93bba578eec47e1d1e984f' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\forms\\back\\tpl\\default\\select.tpl',
      1 => 1473436168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838ae4066f0_31480517 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="field clear"><label><?php echo $_smarty_tpl->tpl_vars['_item']->value['_attr']['title'];?>
</label><select<?php if (count($_smarty_tpl->tpl_vars['_item']->value['_attr']) > 0) {
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
}?>>
<?php if (isset($_smarty_tpl->tpl_vars['_item']->value['_options']) && count($_smarty_tpl->tpl_vars['_item']->value['_options']) > 0) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_item']->value['_options'], 'oval', false, 'otitle');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['otitle']->value => $_smarty_tpl->tpl_vars['oval']->value) {
if (is_int($_smarty_tpl->tpl_vars['otitle']->value)) {?>	<option value="<?php echo $_smarty_tpl->tpl_vars['oval']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['oval']->value == $_smarty_tpl->tpl_vars['_item']->value['_attr']['value']) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['oval']->value;?>
</option><?php } else { ?>	<option value="<?php echo $_smarty_tpl->tpl_vars['oval']->value;?>
"<?php if ($_smarty_tpl->tpl_vars['oval']->value == $_smarty_tpl->tpl_vars['_item']->value['_attr']['value']) {?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['otitle']->value;?>
</option><?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>
</select>
</div>
<?php }
}
