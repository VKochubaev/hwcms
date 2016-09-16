<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:38
  from "D:\OpenServer\domains\hwcms\cms\modules\forms\back\tpl\default\button.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838ae00ec04_06660499',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9dd3ba75d1346dc8451e7036354d0c47f371d1c7' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\forms\\back\\tpl\\default\\button.tpl',
      1 => 1473436168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838ae00ec04_06660499 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="field clear"><button<?php if (count($_smarty_tpl->tpl_vars['_item']->value['_attr']) > 0) {
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
}?>><?php echo $_smarty_tpl->tpl_vars['_item']->value['_attr']['title'];?>
</button></div>
<?php }
}
