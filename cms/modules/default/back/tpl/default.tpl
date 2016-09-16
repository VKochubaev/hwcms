{if $mmodules}

<div id="def_page_conteiner">
{foreach $mmodules as $pos}
{foreach $pos as $item}
	<div class="item"><a href="{$item.back_link}"{if isset($item.back_menu_id)} id="{$item.back_menu_id}"{/if}><div class="big-ico" {if isset($item.ico96)} style="background-image:url({$item.ico96});"{/if}></div><span>{$item.title}</span></a></div>
{/foreach}
{/foreach}
</div>

{/if}