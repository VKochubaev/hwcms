{if $mmodules}

{foreach $mmodules as $pos}
<ul class="nav nav-pills nav-stacked side-navigation">
{foreach $pos as $item}
	<li{if isset($item.ico)} style="background-image: url({$item.ico})"{/if}><a href="{$item.back_link}"{if isset($item.back_menu_id)} id="{$item.back_menu_id}"{/if}><i class="{$item.use_icon}"></i><span>{$item.title}</span></a></li>
{/foreach}
</ul>
{/foreach}

{/if}