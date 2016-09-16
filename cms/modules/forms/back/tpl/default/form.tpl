{if $form_data__TEMP._attr.title}<h2>{$form_data__TEMP._attr.title}</h2>{/if}
<form{if count($form_data__TEMP._attr) > 0}{foreach $form_data__TEMP._attr key=k item=v} {if !empty($v)}{$k}="{$v}"{/if}{/foreach}{/if}>

{foreach from=$form_data__TEMP._items item='i'}
{if isset($i._tpl)}{include file=$i._tpl _item=$i}{/if}
{/foreach}

</form>

