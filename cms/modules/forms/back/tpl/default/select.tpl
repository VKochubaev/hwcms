<div class="field clear"><label>{$_item._attr.title}</label><select{if count($_item._attr)>0}{foreach $_item._attr key=k item=v} {if !empty($v)}{$k}="{$v}"{/if}{/foreach}{/if}>
{if isset($_item._options) and count($_item._options) > 0}
{foreach $_item._options key=otitle item=oval}{if is_int($otitle)}	<option value="{$oval}"{if $oval == $_item._attr.value} selected{/if}>{$oval}</option>{else}	<option value="{$oval}"{if $oval == $_item._attr.value} selected{/if}>{$otitle}</option>{/if}{/foreach}
{/if}
</select>
</div>
