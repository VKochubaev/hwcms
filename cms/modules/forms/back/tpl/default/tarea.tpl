<div class="field clear"><label>{$_item._attr.title}</label><br/>
<textarea{if count($_item._attr)>0}{foreach $_item._attr key=k item=v} {if !empty($v) and $k != 'value'}{$k}="{$v}"{/if}{/foreach}{/if}>{$_item._attr.value}</textarea></div>
