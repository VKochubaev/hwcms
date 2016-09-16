<fieldset{if count($_item._attr) > 0}{foreach $_item._attr key=k item=v} {if $k=='class'}{$k}="{$v}{if $_item._state===true} opened{elseif $_item._state===false} closed{/if}"{else}{if !empty($v)}{$k}="{$v}"{/if}{/if}{/foreach}{/if}>
<legend>{$_item.title}</legend>

{if isset($_item._items) and count($_item._items)>0}
{foreach $_item._items item=gi}
{if isset($gi._tpl)}{include file=$gi._tpl _item=$gi}{/if}
{/foreach}
{/if}

</fieldset>

