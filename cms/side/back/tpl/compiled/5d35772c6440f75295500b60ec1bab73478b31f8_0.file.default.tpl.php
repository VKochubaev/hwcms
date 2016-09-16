<?php
/* Smarty version 3.1.30, created on 2016-09-13 20:33:56
  from "D:\OpenServer\domains\hwcms\cms\modules\pages\back\tpl\default.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57d83884735512_02865998',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5d35772c6440f75295500b60ec1bab73478b31f8' => 
    array (
      0 => 'D:\\OpenServer\\domains\\hwcms\\cms\\modules\\pages\\back\\tpl\\default.tpl',
      1 => 1473527038,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57d83884735512_02865998 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form id="pagesListForm">
<table class="table table-striped table-bordered custom-table table-hover treeCollapsable tiny nowrap">
<thead>

    <tr>	
        <th class="colCBox">&nbsp;</th>
        <th class="colId">ID</th>
        <th class="colTitle">Название</th>
        <th class="colSmall"><i class="fa fa-thumb-tack"></i> Главная</th>
        <th class="colSmall"><i class="fa fa-sort-amount-desc"></i> Порядок</th>
        <th class="colSmall"><i class="fa fa-eye"></i> Статусы</th>
        <th class="colSmall"><i class="fa fa-gear"></i> Действия</th>
    </tr>
    
</thead>
<tbody>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pages']->value, 'page');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['page']->value) {
?>
    <tr class="tColRow row" data-has-childs="<?php echo $_smarty_tpl->tpl_vars['page']->value['_has_childs'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['page']->value['_id'];?>
" data-parent="<?php echo $_smarty_tpl->tpl_vars['page']->value['_parent'];?>
" data-page="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
" data-way="/<?php echo join("/",$_smarty_tpl->tpl_vars['page']->value['_way']);?>
">
        <td class="colCBox"><label class="checkbox-custom check-warning"><input type="checkbox" name="chk[]" value="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
" id="checkbox-<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"/><label for="checkbox-<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"></label></label></td>
        <td class="colId"><?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
 (nid <?php echo $_smarty_tpl->tpl_vars['page']->value['_id'];?>
)</td>
        <td class="colTitle colCps"<?php if ($_smarty_tpl->tpl_vars['page']->value['_level'] > 1) {?> style="padding-left:<?php echo $_smarty_tpl->tpl_vars['page']->value['_level']*16;?>
px;"<?php }?>><a href="/<?php echo $_smarty_tpl->tpl_vars['page']->value['page_path'];?>
/" target="_blank"><?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
</a></td>
        <td class="colSmall mark-def" align="center">
        	<?php if ($_smarty_tpl->tpl_vars['page']->value['def'] == 1) {?>
        		<a href="javascript:void(0);" class="ico16 mark-<?php echo $_smarty_tpl->tpl_vars['page']->value['def'];?>
 ajax" data-ajax-action="def" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
" title="Данная страница является главной страницей сайта"><i class="fa fa-check-square fa-lg"></i></a>
            <?php } else { ?>
                <a href="javascript:void(0);" class="ico16 mark-<?php echo $_smarty_tpl->tpl_vars['page']->value['def'];?>
 ajax" data-ajax-action="def" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
" title="Сделать страницу главной на сайте"><i class="fa fa-square-o mainpagemarker"></i></a>
            <?php }?>
        </td>
        <td class="colSmall" align="center">
         		<a href="javascript:void(0);" class="orderarrow" data-ajax-action="sort" data-ajax-subaction="0" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><i class="fa fa-lg fa-arrow-up"></i></a>
                <input class="form-control orderinput" name="sort[<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['page']->value['_node_ord'];?>
" type="text"/>
                <a href="javascript:void(0);" class="orderarrow" data-ajax-action="sort" data-ajax-subaction="1" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><i class="fa fa-lg fa-arrow-down"></i></a>   
        </td>
        <td class="colSmall mark-actvis">
            <ul class="action-icons">
                <li><a href="javascript:void(0);" class="ico-notext dyn-panel-toggler" data-panel-target="act" data-confirm="Вы действительно хотите сделать страницу &quot;<?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
&quot; (id<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
)?" title="Изменить активность страницы"><i class="ico16 act-<?php echo $_smarty_tpl->tpl_vars['page']->value['act'];?>
 "></i><span>Изменить активность страницы</span></a>
                    <ul class="dyn-panel" rel="act">
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="act" data-ajax-subaction="1" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><i class="ico16 act-1"></i><span>Доступна всем</span></a></li>
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="act" data-ajax-subaction="2" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><i class="ico16 act-2"></i><span>Доступна только зарегистрированным</span></a></li>
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="act" data-ajax-subaction="0" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><i class="ico16 act-0"></i><span>Закрыта для всех</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" class="ico16 vis-<?php echo $_smarty_tpl->tpl_vars['page']->value['vis'];?>
 dyn-panel-toggler" data-panel-target="vis" data-confirm="Вы действительно хотите изменить видимость страницы &quot;<?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
&quot; (id<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
)?" title="Изменить видимость страницы">Изменить видимость страницы</a>
                    <ul class="dyn-panel mark-vis" rel="vis">
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="vis" data-ajax-subaction="1" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><i class="ico16 vis-1"></i><span>Показывать страницу в навигации</span></a></li>
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="vis" data-ajax-subaction="0" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
"><i class="ico16 vis-0"></i><span>Скрыть страницу из навигации</span></a></li>
                    </ul>
                </li>
            </ul>
        </td>
        <td class="colSmall mark-other">
        	<a href="<?php echo $_smarty_tpl->tpl_vars['mod_back_url']->value;?>
/?module_view=add_page&parent=<?php echo $_smarty_tpl->tpl_vars['page']->value['_id'];?>
" class="btn btn-info btn-xs" title="Добавить дочернюю страницу"><i class="fa fa-plus"></i></a>
            <a href="<?php echo $_smarty_tpl->tpl_vars['mod_back_url']->value;?>
/?module_view=edit_page&id=<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
" class="btn btn-primary btn-xs" title="Редактировать страницу"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0);" class="btn btn-danger btn-xs ajax" data-ajax-action="del" data-ajax-data="<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
" data-ajax-confirm="Вы действительно хотите удалить страницу &quot;<?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
&quot; (id<?php echo $_smarty_tpl->tpl_vars['page']->value['page_id'];?>
)" title="Удалить страницу"><i class="fa fa-trash-o "></i></a>      
        </td>
    </tr>
<?php
}
} else {
?>

    <tr>
        <td colspan="7" class="mess-no-entries">Страницы не найдены!</td>
    </tr>
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    <tr>
        <td><input type="checkbox" name="check_all" class="checkAll" value="1"/></td>
        <td colspan="7">
            <select name="sel_action" class="form-control" style="width:250px;">
                <option value="save_ord">Сохранить очерёдность у всех</option>
                <option value="act_1">Доступно всем</option>
                <option value="act_2">Доступно только зарегистрированным</option>
                <option value="act_0">Закрыть доступ для всех</option>
                <option value="vis_1">Показывать в меню</option>
                <option value="vis_0">Скрыть из меню</option>
                <option value="del">Удалить</option>
            </select>
        </td>
    </tr>
    
</tbody>
</table>
</form><?php }
}
