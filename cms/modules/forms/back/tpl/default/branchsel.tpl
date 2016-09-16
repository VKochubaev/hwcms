{if isset($branch)}

	<ul>
	{if count($branch) > 0}
		{foreach $branch item=br}
        {$has_childs=(isset($br._tree) and count($br._tree) > 0) ? true : false}
        <li data-item-id="{if isset($br.id)}{$br.id}{else}0{/if}">
            <a href="#" data-value="{$br.node_id}">{if $br.node_id == 0}<b>Корневой</b>{else}{$br.title}{/if}</a>
        {if $has_childs}
			{include file=$_item._tpl branch=$br._tree tpl=$_item._tpl}
		{/if}</li>
        {/foreach}
	{/if}
	</ul>

{else}

<div class="field clear branch-sel"><label>{$_item._attr.title}</label>
	<ul class="tree-list">
	{if isset($_item._tree) and count($_item._tree) > 0}
		{foreach $_item._tree item=br}
        {$has_childs=(isset($br._tree) and count($br._tree) > 0) ? true : false}
        <li data-item-id="{if isset($br.id)}{$br.id}{else}0{/if}">
            <a href="#" data-value="{$br.node_id}">{if $br.node_id == 0}<b>Корневой</b>{else}{$br.title}{/if}</a>
        {if $has_childs}
			{include file=$_item._tpl branch=$br._tree tpl=$_item._tpl}
		{/if}</li>
        {/foreach}
	{/if}
	</ul>
	<input class="tree-list-value" type="hidden"{if count($_item._attr)>0}{foreach $_item._attr key=k item=v} {$k}="{$v}"{/foreach}{/if}/>
	<button type="button">Обзор</button>
	<span class="tree-list-label"></span>
</div>

{/if}