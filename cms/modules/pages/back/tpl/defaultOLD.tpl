<form id="pagesListForm">
<table class="greed treeCollapsable tiny nowrap">
<thead>

    <tr>
        <th class="colCBox">&nbsp;</th>
        <th class="colId">id</th>
        <th class="colTitle" colspan="2">Название</th>
        <th class="colSmall">Главная</th>
        <th class="colSmall">Порядок</th>
        <th class="colSmall">Акт./<br/>видим.</th>
        <th class="colSmall">Действия</th>
    </tr>
    
</thead>
<tbody>

{foreach from=$pages item=page}
    <tr class="tColRow row" data-has-childs="{$page._has_childs}" data-id="{$page._id}" data-parent="{$page._parent}" data-page="{$page.page_id}" data-way="/{"/"|join:$page._way}">
        <td class="colCBox"><input type="checkbox" name="chk[]" value="{$page.page_id}"/></td>
        <td class="colId">{$page.page_id} (nid {$page._id})</td>
        <td class="col16 colCps colBtn"></td>
        <td class="colTitle colCps"{if $page._level > 1} style="padding-left:{$page._level * 16}px;"{/if}><a href="/{$page.page_path}/" target="_blank">{$page.title}</a></td>
        <td class="colSmall mark-def">
            <ul class="action-icons">
                <li><a href="javascript:void(0);" class="ico16 mark-{$page.def} ajax" data-ajax-action="def" data-ajax-data="{$page.page_id}"   title="Сделать эту страницу  стартовой">Сделать эту страницу стартовой</a></li>
            </ul>
        </td>
        <td class="colSmall">
            <ul class="action-icons">
                <li><a href="javascript:void(0);" class="ico-notext ajax" data-ajax-action="sort" data-ajax-subaction="0" data-ajax-data="{$page.page_id}"><i class="ico16 sort-0{if $page._first} disabled{/if}"></i><span>Переместить вверх</span></a></li>
                <li><input class="ord-field" name="sort[{$page.page_id}]" value="{$page._node_ord}" /></li>
                <li><a href="javascript:void(0);" class="ico-notext ajax" data-ajax-action="sort" data-ajax-subaction="1" data-ajax-data="{$page.page_id}"><i class="ico16 sort-1{if $page._last} disabled{/if}"></i><span>Переместить вниз</span></a></li>
            </ul>
        </td>
        <td class="colSmall mark-actvis">
            <ul class="action-icons">
                <li><a href="javascript:void(0);" class="ico-notext dyn-panel-toggler" data-panel-target="act" data-confirm="Вы действительно хотите сделать страницу &quot;{$page.title}&quot; (id{$page.page_id})?" title="Изменить активность страницы"><i class="ico16 act-{$page.act} "></i><span>Изменить активность страницы</span></a>
                    <ul class="dyn-panel" rel="act">
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="act" data-ajax-subaction="1" data-ajax-data="{$page.page_id}"><i class="ico16 act-1"></i><span>Доступна всем</span></a></li>
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="act" data-ajax-subaction="2" data-ajax-data="{$page.page_id}"><i class="ico16 act-2"></i><span>Доступна только зарегистрированным</span></a></li>
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="act" data-ajax-subaction="0" data-ajax-data="{$page.page_id}"><i class="ico16 act-0"></i><span>Закрыта для всех</span></a></li>
                    </ul>
                </li>
                <li><a href="javascript:void(0);" class="ico16 vis-{$page.vis} dyn-panel-toggler" data-panel-target="vis" data-confirm="Вы действительно хотите изменить видимость страницы &quot;{$page.title}&quot; (id{$page.page_id})?" title="Изменить видимость страницы">Изменить видимость страницы</a>
                    <ul class="dyn-panel mark-vis" rel="vis">
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="vis" data-ajax-subaction="1" data-ajax-data="{$page.page_id}"><i class="ico16 vis-1"></i><span>Показывать страницу в навигации</span></a></li>
                        <li><a href="javascript:void(0);" class="ajax" data-ajax-action="vis" data-ajax-subaction="0" data-ajax-data="{$page.page_id}"><i class="ico16 vis-0"></i><span>Скрыть страницу из навигации</span></a></li>
                    </ul>
                </li>
            </ul>
        </td>
        <td class="colSmall mark-other">
            <ul class="action-icons">
                <li><a href="{$mod_back_url}/?module_view=add_page&parent={$page._id}" class="ico16 add" title="Добавить дочернюю страницу">Добавить дочернюю страницу</a></li>
                <li><a href="{$mod_back_url}/?module_view=edit_page&id={$page.page_id}" class="ico16 edit" title="Редактировать страницу &quot;{$page.title} (id{$page.page_id})&quot;">Редактировать страницу</a></li>
                <li><a href="javascript:void(0);" class="ico16 del ajax"  data-ajax-action="del" data-ajax-data="{$page.page_id}" data-ajax-confirm="Вы действительно хотите удалить страницу &quot;{$page.title}&quot; (id{$page.page_id})" title="Удалить страницу">Удалить страницу</a></li>
            </ul>
        </td>
    </tr>
{foreachelse}
    <tr>
        <td colspan="8" class="mess-no-entries">Страницы не найдены!</td>
    </tr>
{/foreach}
    <tr>
        <td><input type="checkbox" name="check_all" class="checkAll" value="1"/></td>
        <td colspan="7">&nbsp;►&nbsp;
            <select name="sel_action">
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
</form>