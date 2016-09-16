<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Администратор</title>
    <base href="{$active_base}"/>
    
    {foreach from=$back_styles item=css_style}
	<link href="{$css_style.src}" media="{$css_style.media}" rel="{$css_style.rel}" type="{$css_style.type}" />
	{/foreach}
	
	{foreach from=$back_scripts item=script}
	<script language="{$script.language}" type="{$script.type}" src="{$script.src}"></script>
	{/foreach}
    
</head>

<body class="sticky-header">

    <section>
        <!-- sidebar left start-->
        <div class="sidebar-left sticky-sidebar">
        
            <div class="logo dark-logo-bg visible-xs-* visible-sm-*">
                <a href="{$active_base}"><img src="/images/back/logo-icon.png" alt=""></a>
            </div>

            <div class="sidebar-left-info">

                {if $back_triggers.show_modules_menu == true}{include 'menu.inc.tpl'}{/if}               

            </div>
        </div>
        <!-- sidebar left end-->

        <!-- body content start-->
        <div class="body-content" >

            <div class="header-section">

                <div class="logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="{$active_base}">
                        <img src="/cms/side/back/images/logo-orange.png" />
                    </a>
                </div>

                <div class="icon-logo dark-logo-bg hidden-xs hidden-sm">
                    <a href="{$active_base}">
                        <img src="/cms/side/back/images/logo-icon.png" alt="">
                       
                    </a>
                </div>
                
                <a class="toggle-btn"><i class="fa fa-outdent"></i></a>

                <div id="navbar-collapse-1" class="navbar-collapse collapse yamm mega-menu">
                    <ul class="nav navbar-nav">
                    	<li class="dropdown">
                            {foreach $back_versions item=ver}
                            	
                                {if !$ver.cur}
                                	<ul role="menu" class="dropdown-menu language-switch">
                                		<li>
                                    		<a tabindex="-1" href="{$admin_base}{$ver.version_id}/"><span>{$ver.title}</span></a> 
                                		</li>
                            		</ul>
                                {else}
                                	<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle">
                                    	Текущая версия: {$ver.title}&nbsp;&nbsp;<b class="fa fa-angle-down"></b>
                                    </a>
                                {/if}
                            {/foreach}    
                        </li>
                    </ul>
                </div>
                
                <div class="loginzone">Имя администратора  <a href="{$active_base}?logout">(<i class="fa fa-power-off"></i> Выйти)</a></div>
              
            </div>         
            
            
            <div class="page-head">
            	<h3>{if $back_module_title}{if isset($mod_back_url) and $mod_back_url}<a href="{$mod_back_url}">{$back_module_title}</a>{else}{$back_module_title}{/if}{/if}</h3>
                <span class="sub-title">{if $back_section_title}{$back_section_title}{/if}</span>
                
                {if $back_actions}

                                
                <div class="state-information">
                	{foreach from=$back_actions key=nick item=action}
                	<a class="btn btn-success addon-btn m-b-10" href="{if $action.href}{$mod_back_url}/{$action.href}{else}#{/if}"><i class="fa fa-{$action.ico}"></i>{$action.title}</a>
                    {/foreach}
                </div>
                {/if}
            </div>
            
            <div class="wrapper">
            
                            

            	<div class="row">
                	<div class="col-lg-12">
                    	<section class="panel">
                        
                            <div id="messages">
                                {messages}
                                <div class="mess-btn"></div>
                            </div>
                            
                            <div id="tabs_and_actions">
            
                                
                                {if $back_tabs}
                                <ul id="tabs">
                                    {foreach from=$back_tabs key=nick item=tab}
                                    <li><a href="{if $tab.href}{$action.tab}{else}#{/if}"{if $tab.item_id} id="{$tab.item_id}{if $tab.ico}"{/if} class="ico {$tab.ico}"{/if}>{$tab.title}</a></li>
                                    {/foreach}
                                </ul>
                                {/if}
                                
                            </div>
                
                			{display tpl='module_main_tpl'}
                            
                       </section>                
                	</div>
                </div>
                
            </div>

        </div>
        <!-- body content end-->
    </section>

</body>
</html>