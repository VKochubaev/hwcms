<div class="field clear"><label>{$_item._attr.title}</label><input{if count($_item._attr)>0}{foreach $_item._attr key=k item=v} {if !empty($v)}{$k}="{$v}"{/if}{/foreach}{/if}/></div>
