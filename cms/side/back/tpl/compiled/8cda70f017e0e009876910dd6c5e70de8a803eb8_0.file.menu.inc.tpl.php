<?php
/* Smarty version 3.1.30, created on 2016-09-14 00:46:53
  from "D:\OpenServer\domains\hwcms\cms\side\back\tpl\menu.inc.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d873cd7f5636_71528363',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8cda70f017e0e009876910dd6c5e70de8a803eb8' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\side\\back\\tpl\\menu.inc.tpl',
      1 => 1473523364,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d873cd7f5636_71528363 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['mmodules']->value) {?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['mmodules']->value, 'pos');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['pos']->value) {
?>
<ul class="nav nav-pills nav-stacked side-navigation">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pos']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
	<li<?php if (isset($_smarty_tpl->tpl_vars['item']->value['ico'])) {?> style="background-image: url(<?php echo $_smarty_tpl->tpl_vars['item']->value['ico'];?>
)"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['back_link'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['item']->value['back_menu_id'])) {?> id="<?php echo $_smarty_tpl->tpl_vars['item']->value['back_menu_id'];?>
"<?php }?>><i class="<?php echo $_smarty_tpl->tpl_vars['item']->value['use_icon'];?>
"></i><span><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</span></a></li>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</ul>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


<?php }
}
}
