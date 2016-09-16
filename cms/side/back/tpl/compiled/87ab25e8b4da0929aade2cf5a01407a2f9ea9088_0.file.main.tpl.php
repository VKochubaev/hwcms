<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:33:56
  from "D:\OpenServer\domains\hwcms\cms\side\back\tpl\main.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d838844a8ef9_83053110',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87ab25e8b4da0929aade2cf5a01407a2f9ea9088' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\side\\back\\tpl\\main.tpl',
      1 => 1473784786,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu.inc.tpl' => 1,
  ),
),false)) {
function content_57d838844a8ef9_83053110 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_messages')) require_once 'D:\\OpenServer\\domains\\hwcms\\cms\\side\\back\\tpl\\plugins\\function.messages.php';
if (!is_callable('smarty_function_display')) require_once 'D:\\OpenServer\\domains\\hwcms\\cms\\side\\back\\tpl\\plugins\\function.display.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Администратор</title>
    <base href="<?php echo $_smarty_tpl->tpl_vars['active_base']->value;?>
"/>
    
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['back_styles']->value, 'css_style');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['css_style']->value) {
?>
	<link href="<?php echo $_smarty_tpl->tpl_vars['css_style']->value['src'];?>
" media="<?php echo $_smarty_tpl->tpl_vars['css_style']->value['media'];?>
" rel="<?php echo $_smarty_tpl->tpl_vars['css_style']->value['rel'];?>
" type="<?php echo $_smarty_tpl->tpl_vars['css_style']->value['type'];?>
" />
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

	
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['back_scripts']->value, 'script');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['script']->value) {
?>
	<?php echo '<script'; ?>
 language="<?php echo $_smarty_tpl->tpl_vars['script']->value['language'];?>
" type="<?php echo $_smarty_tpl->tpl_vars['script']->value['type'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['script']->value['src'];?>
"><?php echo '</script'; ?>
>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    
</head>

<body class="sticky-header">

    <section>
        <!-- sidebar left start-->
        <div class="sidebar-left sticky-sidebar">
        
            <div class="logo dark-logo-bg visible-xs-* visible-sm-*">
                <a href="<?php echo $_smarty_tpl->tpl_vars['active_base']->value;?>
"><img src="/images/back/logo-icon.png" alt=""></a>
            </div>

            <div class="sidebar-left-info">

                <?php if ($_smarty_tpl->tpl_vars['back_triggers']->value['show_modules_menu'] == true) {
$_smarty_tpl->_subTemplateRender("file:menu.inc.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>               

            </div>
        </div>
        <!-- sidebar left end-->

        <!-- body content start-->
        <div class="body-content" >

            <div class="header-section">

                <div class="logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['active_base']->value;?>
">
                        <img src="/cms/side/back/images/logo-orange.png" />
                    </a>
                </div>

                <div class="icon-logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['active_base']->value;?>
">
                        <img src="/cms/side/back/images/logo-icon.png" alt="">
                       
                    </a>
                </div>
                
                <a class="toggle-btn"><i class="fa fa-outdent"></i></a>

                <div id="navbar-collapse-1" class="navbar-collapse collapse yamm mega-menu">
                    <ul class="nav navbar-nav">
                    	<li class="dropdown">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['back_versions']->value, 'ver');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ver']->value) {
?>
                            	
                                <?php if (!$_smarty_tpl->tpl_vars['ver']->value['cur']) {?>
                                	<ul role="menu" class="dropdown-menu language-switch">
                                		<li>
                                    		<a tabindex="-1" href="<?php echo $_smarty_tpl->tpl_vars['admin_base']->value;
echo $_smarty_tpl->tpl_vars['ver']->value['version_id'];?>
/"><span><?php echo $_smarty_tpl->tpl_vars['ver']->value['title'];?>
</span></a> 
                                		</li>
                            		</ul>
                                <?php } else { ?>
                                	<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle">
                                    	Текущая версия: <?php echo $_smarty_tpl->tpl_vars['ver']->value['title'];?>
&nbsp;&nbsp;<b class="fa fa-angle-down"></b>
                                    </a>
                                <?php }?>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
    
                        </li>
                    </ul>
                </div>
                
                <div class="loginzone">Имя администратора  <a href="<?php echo $_smarty_tpl->tpl_vars['active_base']->value;?>
?logout">(<i class="fa fa-power-off"></i> Выйти)</a></div>
              
            </div>         
            
            
            <div class="page-head">
            	<h3><?php if ($_smarty_tpl->tpl_vars['back_module_title']->value) {
if (isset($_smarty_tpl->tpl_vars['mod_back_url']->value) && $_smarty_tpl->tpl_vars['mod_back_url']->value) {?><a href="<?php echo $_smarty_tpl->tpl_vars['mod_back_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['back_module_title']->value;?>
</a><?php } else {
echo $_smarty_tpl->tpl_vars['back_module_title']->value;
}
}?></h3>
                <span class="sub-title"><?php if ($_smarty_tpl->tpl_vars['back_section_title']->value) {
echo $_smarty_tpl->tpl_vars['back_section_title']->value;
}?></span>
                
                <?php if ($_smarty_tpl->tpl_vars['back_actions']->value) {?>

                                
                <div class="state-information">
                	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['back_actions']->value, 'action', false, 'nick');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['nick']->value => $_smarty_tpl->tpl_vars['action']->value) {
?>
                	<a class="btn btn-success addon-btn m-b-10" href="<?php if ($_smarty_tpl->tpl_vars['action']->value['href']) {
echo $_smarty_tpl->tpl_vars['mod_back_url']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['action']->value['href'];
} else { ?>#<?php }?>"><i class="fa fa-<?php echo $_smarty_tpl->tpl_vars['action']->value['ico'];?>
"></i><?php echo $_smarty_tpl->tpl_vars['action']->value['title'];?>
</a>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </div>
                <?php }?>
            </div>
            
            <div class="wrapper">
            
                            

            	<div class="row">
                	<div class="col-lg-12">
                    	<section class="panel">
                        
                            <div id="messages">
                                <?php echo smarty_function_messages(array(),$_smarty_tpl);?>

                                <div class="mess-btn"></div>
                            </div>
                            
                            <div id="tabs_and_actions">
            
                                
                                <?php if ($_smarty_tpl->tpl_vars['back_tabs']->value) {?>
                                <ul id="tabs">
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['back_tabs']->value, 'tab', false, 'nick');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['nick']->value => $_smarty_tpl->tpl_vars['tab']->value) {
?>
                                    <li><a href="<?php if ($_smarty_tpl->tpl_vars['tab']->value['href']) {
echo $_smarty_tpl->tpl_vars['action']->value['tab'];
} else { ?>#<?php }?>"<?php if ($_smarty_tpl->tpl_vars['tab']->value['item_id']) {?> id="<?php echo $_smarty_tpl->tpl_vars['tab']->value['item_id'];
if ($_smarty_tpl->tpl_vars['tab']->value['ico']) {?>"<?php }?> class="ico <?php echo $_smarty_tpl->tpl_vars['tab']->value['ico'];?>
"<?php }?>><?php echo $_smarty_tpl->tpl_vars['tab']->value['title'];?>
</a></li>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                </ul>
                                <?php }?>
                                
                            </div>
                
                			<?php echo smarty_function_display(array('tpl'=>'module_main_tpl'),$_smarty_tpl);?>

                            
                       </section>                
                	</div>
                </div>
                
            </div>

        </div>
        <!-- body content end-->
    </section>

</body>
</html><?php }
}
