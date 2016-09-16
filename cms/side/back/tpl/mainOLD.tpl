<!DOCTYPE html >
<html>
<head>
{include 'head.inc.tpl'}
</head>
<body>
    
<div id="messages">
    {messages}
    <div class="mess-btn"></div>
</div>
    
<div id="head">
{include 'top.inc.tpl'}
</div>
    
<div id="content{if $back_triggers.show_modules_menu != true} full-width{/if}">

	{if $back_module_title}<h1 id="module_title">{if isset($mod_back_url) and $mod_back_url}<a href="{$mod_back_url}">{$back_module_title}</a>{else}{$back_module_title}{/if}</h1>{/if}
{if $back_section_title}	
	<h2 id="section_title">{$back_section_title}</h2>
{/if}

<div id="tabs_and_actions">

{if $back_actions}
<ul id="actions">
{foreach from=$back_actions key=nick item=action}
	<li><a href="{if $action.href}{$mod_back_url}/{$action.href}{else}#{/if}"{if $action.item_id} id="{$action.item_id}{if $action.ico}"{/if} class="ico {$action.ico}"{/if}>{$action.title}</a></li>
{/foreach}
</ul>
{/if}

{if $back_tabs}
<ul id="tabs">
{foreach from=$back_tabs key=nick item=tab}
	<li><a href="{if $tab.href}{$action.tab}{else}#{/if}"{if $tab.item_id} id="{$tab.item_id}{if $tab.ico}"{/if} class="ico {$tab.ico}"{/if}>{$tab.title}</a></li>
{/foreach}
</ul>
{/if}

</div>

{display tpl='module_main_tpl'}

</div>

{if $back_triggers.show_modules_menu == true}{include 'menu.inc.tpl'}{/if}

<div id="footer">
{include 'footer.inc.tpl'}
</div>

</body>
</html>