<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:34:41
  from "D:\OpenServer\domains\hwcms\cms\side\back\tpl\messages.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838b1d84ee5_90974640',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb941db1ebf1c310eadcf13b198ba64bcbc640da' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\side\\back\\tpl\\messages.tpl',
      1 => 1473511279,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d838b1d84ee5_90974640 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['messages']->value, 'mess');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['mess']->value) {
?>
<div <?php if ($_smarty_tpl->tpl_vars['messages_id']->value) {?> id="<?php echo $_smarty_tpl->tpl_vars['messages_id']->value;?>
"<?php }?> class="alert alert-<?php echo $_smarty_tpl->tpl_vars['mess']->value['type'];?>
 fade in">
	<button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
    <strong><?php echo $_smarty_tpl->tpl_vars['mess']->value['text'];?>
</strong>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}
}
