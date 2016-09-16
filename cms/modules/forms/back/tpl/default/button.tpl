<div class="field clear"><button{if count($_item._attr)>0}{foreach $_item._attr key=k item=v} {if !empty($v)}{$k}="{$v}"{/if}{/foreach}{/if}>{$_item._attr.title}</button></div>
