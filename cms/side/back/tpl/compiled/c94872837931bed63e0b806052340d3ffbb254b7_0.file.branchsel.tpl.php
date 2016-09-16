<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:38
  from "D:\OpenServer\domains\hwcms\cms\modules\forms\back\tpl\default\branchsel.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838ae283b11_19673216',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c94872837931bed63e0b806052340d3ffbb254b7' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\forms\\back\\tpl\\default\\branchsel.tpl',
      1 => 1473436168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838ae283b11_19673216 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['branch']->value)) {?>

	<ul>
	<?php if (count($_smarty_tpl->tpl_vars['branch']->value) > 0) {?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['branch']->value, 'br');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['br']->value) {
?>
        <?php $_smarty_tpl->_assignInScope('has_childs', isset($_smarty_tpl->tpl_vars['br']->value['_tree']) && count($_smarty_tpl->tpl_vars['br']->value['_tree']) > 0 ? true : false);
?>
        <li data-item-id="<?php if (isset($_smarty_tpl->tpl_vars['br']->value['id'])) {
echo $_smarty_tpl->tpl_vars['br']->value['id'];
} else { ?>0<?php }?>">
            <a href="#" data-value="<?php echo $_smarty_tpl->tpl_vars['br']->value['node_id'];?>
"><?php if ($_smarty_tpl->tpl_vars['br']->value['node_id'] == 0) {?><b>Корневой</b><?php } else {
echo $_smarty_tpl->tpl_vars['br']->value['title'];
}?></a>
        <?php if ($_smarty_tpl->tpl_vars['has_childs']->value) {?>
			<?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['_item']->value['_tpl'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('branch'=>$_smarty_tpl->tpl_vars['br']->value['_tree'],'tpl'=>$_smarty_tpl->tpl_vars['_item']->value['_tpl']), 0, true);
?>

		<?php }?></li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	<?php }?>
	</ul>

<?php } else { ?>

<div class="field clear branch-sel"><label><?php echo $_smarty_tpl->tpl_vars['_item']->value['_attr']['title'];?>
</label>
	<ul class="tree-list">
	<?php if (isset($_smarty_tpl->tpl_vars['_item']->value['_tree']) && count($_smarty_tpl->tpl_vars['_item']->value['_tree']) > 0) {?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_item']->value['_tree'], 'br');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['br']->value) {
?>
        <?php $_smarty_tpl->_assignInScope('has_childs', isset($_smarty_tpl->tpl_vars['br']->value['_tree']) && count($_smarty_tpl->tpl_vars['br']->value['_tree']) > 0 ? true : false);
?>
        <li data-item-id="<?php if (isset($_smarty_tpl->tpl_vars['br']->value['id'])) {
echo $_smarty_tpl->tpl_vars['br']->value['id'];
} else { ?>0<?php }?>">
            <a href="#" data-value="<?php echo $_smarty_tpl->tpl_vars['br']->value['node_id'];?>
"><?php if ($_smarty_tpl->tpl_vars['br']->value['node_id'] == 0) {?><b>Корневой</b><?php } else {
echo $_smarty_tpl->tpl_vars['br']->value['title'];
}?></a>
        <?php if ($_smarty_tpl->tpl_vars['has_childs']->value) {?>
			<?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['_item']->value['_tpl'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('branch'=>$_smarty_tpl->tpl_vars['br']->value['_tree'],'tpl'=>$_smarty_tpl->tpl_vars['_item']->value['_tpl']), 0, true);
?>

		<?php }?></li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	<?php }?>
	</ul>
	<input class="tree-list-value" type="hidden"<?php if (count($_smarty_tpl->tpl_vars['_item']->value['_attr']) > 0) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_item']->value['_attr'], 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?> <?php echo $_smarty_tpl->tpl_vars['k']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}?>/>
	<button type="button">Обзор</button>
	<span class="tree-list-label"></span>
</div>

<?php }
}
}
