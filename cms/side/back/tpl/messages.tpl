{foreach $messages as $mess}
<div {if $messages_id} id="{$messages_id}"{/if} class="alert alert-{$mess.type} fade in">
	<button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>
    <strong>{$mess.text}</strong>
</div>
{/foreach}