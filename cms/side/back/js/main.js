( function( $ ) {

    // Сворачивание/разворачивание ветвей дерева
    $.treeGreedCollapse = function(onoff){
        
        if(onoff === false){
            
             $('table.greed.treeCollapsable .tColRow').each(function(){
                 
                 var row = $(this);
                 row.removeData('closed');
                 $('.tColRow', row).remove();
                 
             });
            return true;
                 
        }
        
        $('table.greed.treeCollapsable').each(function(){

            var treeGreed = $(this);
            $('.tColRow', treeGreed).each(function(){

                var row = $(this);
                var btnCont = $('.colBtn', row);
                if(row.data('has-childs') > 0 && btnCont.size()>0){

                    var affectRows = $('.tColRow[data-way^="'+row.data('way')+'/"]', treeGreed);
                    //console.log('.tColRow[data-way^="'+row.data('way')+'/"] ==>> '+affectRows.size());
                    var state = row.data('closed');
                    var btn = $('<i class="treeCps '+(state==true?'p':'m')+'"/>').appendTo(btnCont).css('cursor', 'pointer')
                    .on('click.treeCps', function(e){

                        var state = row.data('closed');
                        if(state == true){
                            affectRows.show()
                            .each(function(){
                                $('.colBtn .treeCps', this).click();
                            });
                            btn.removeClass('r p').addClass('m');
                            row.data('closed', false);
                        }else{
                            affectRows
                            .each(function(){
                                $('.colBtn .treeCps', this).click();
                            }).hide();
                            btn.removeClass('r m').addClass('p');
                            row.data('closed', true);
                        }

                    });

                }

            });

        });
        
    };
    
    // Отправка Ajax запроса при клике на элементе и реакция на ответ
    $.ajaxToElements = function(onoff){
     
        if(onoff === false){
            $('body').off('.ajaxAction');
            return true;
        }
        
        $('body').on('click.ajaxAction', '.ajax', function(e){
        
            e.stopPropagation();
            var el = $(this);
            el.parents('.dyn-panel').hide();
            //var mess = $('#messages').mess();
            var ajax_action = el.data('ajax-action');

            if(ajax_action){

                var ajax_subaction = el.data('ajax-subaction');
                var ajax_data = el.data('ajax-data');
                var ajax_confirm = el.data('ajax-confirm');
                
                var data = {action: ajax_action};
                if(ajax_subaction !== undefined) data['subaction'] = ajax_subaction;
                if(ajax_data !== undefined) data['data'] = ajax_data;
                var l = window.location;
                var url = $.buildURL({protocol: l.protocol, host: l.host, pathname: l.pathname});

                var doAjax = function(url, data){

                    $.post(
                        url,
                        data,
                        function(d){

                            if('status' in d){
                                
                                switch(d.status){
                                    case 'success':

                                        if('ret' in d && $.arrSize(d.ret) > 0){

                                            if(typeof d.ret.message != 'undefined') $.mess().s(d.ret.message);
                                            
                                            // Если нужно подгрузить и обновить определённую часть страницы
                                            if('reload_page_by_sel' in d.ret && d.ret){

                                                var sel_obj = $(d.ret.reload_page_by_sel);
                                                if(sel_obj.size() > 0){

                                                    $.get(
                                                        window.location.href,
                                                        {not_ajax: true},
                                                        function(ld){

                                                            var replCont = $(ld).find(d.ret.reload_page_by_sel);
                                                            sel_obj.each(function(idx){

                                                                $(this).empty().append(replCont.eq(idx).find('>'));

                                                            });

                                                        },
                                                        'html'
                                                    );

                                                }

                                            }

                                            // Если нужно удалить определённую часть страницы
                                            if('remove_by_sel' in d.ret && d.ret){

                                                if(typeof d.ret.remove_by_sel == 'object'){
                                                    
                                                    $.each(d.ret.remove_by_sel, function(i, sel){
                                                     
                                                        $(sel).remove();
                                                        
                                                    });
                                                    
                                                }else $(d.ret.remove_by_sel).remove();

                                            }

                                        }

                                    break;
                                    default:
                                    case 'error':

                                        if('errors' in d && $.arrSize(d.errors) > 0){
                                            var m = $.mess();
                                            $.each(d.errors, function(i, str){  m.e(str[1]+' (error id '+str[0]+') ');   });   
                                        } 

                                    break;

                                }
                                
                            }

                        },
                        'json'
                    );

                };

                if(ajax_confirm !== undefined){

                    if(confirm(ajax_confirm)){
                        
                        doAjax(url, data);
                        
                    }

                }else doAjax(url, data);

            }
            
        });
        
    };
    
    // Отправка Ajax запроса при отправке форм и реакция на ответ
    $.ajaxToForms = function(onoff){
     
        if(onoff === false){
            $('body').off('.ajaxFormAction');
            return true;
        }
        
        $('body').on('click.ajaxFormAction', 'form.ajaxForm', function(e){
        
            e.stopPropagation();
            var form = $(this);
            var mess = $('#messages').mess();
            var ajax_action = form.data('ajax-action');

            if(ajax_action){

                var ajax_subaction = form.data('ajax-subaction');
                var ajax_confirm = form.data('ajax-confirm');
                
                var data = {};
                
                
                
                data.ajax_action = ajax_action;
                data = $.param(data);                
                var url = form.attr(action) || './';

                var doAjax = function(url, data){

                    $.post(
                        url,
                        data,
                        function(d){

                            if('status' in d){
                                
                                switch(d.status){
                                    case 'success':

                                        if('ret' in d && $.arrSize(d.ret) > 0){

                                            if(typeof d.ret.message != 'undefined') $.mess().s(d.ret.message);
                                            
                                            // Если нужно подгрузить и обновить определённую часть страницы
                                            if('reload_page_by_sel' in d.ret && d.ret){

                                                var sel_obj = $(d.ret.reload_page_by_sel);
                                                if(sel_obj.size() > 0){

                                                    $.get(
                                                        window.location.href,
                                                        {not_ajax: true},
                                                        function(ld){

                                                            var replCont = $(ld).find(d.ret.reload_page_by_sel);
                                                            sel_obj.each(function(idx){

                                                                $(this).empty().append(replCont.eq(idx).find('>'));

                                                            });

                                                        },
                                                        'html'
                                                    );

                                                }

                                            }

                                            // Если нужно удалить определённую часть страницы
                                            if('remove_by_sel' in d.ret && d.ret){

                                                if(typeof d.ret.remove_by_sel == 'object'){
                                                    
                                                    $.each(d.ret.remove_by_sel, function(i, sel){
                                                     
                                                        $(sel).remove();
                                                        
                                                    });
                                                    
                                                }else $(d.ret.remove_by_sel).remove();

                                            }

                                        }

                                    break;
                                    default:
                                    case 'error':

                                        if('errors' in d && $.arrSize(d.errors) > 0){
                                            var m = $.mess();
                                            $.each(d.errors, function(i, str){  m.e(str[1]+' (error id '+str[0]+') ');   });   
                                        } 

                                    break;

                                }
                                
                            }

                        },
                        'json'
                    );

                };

                if(ajax_confirm !== undefined){

                    if(confirm(ajax_confirm)){
                        
                        doAjax(url, data);
                        
                    }

                }else doAjax(url, data);

            }
            
        });
        
    };
    
    $.dynPanelToggler = function(onoff){
      
        if(onoff === false){
            $('body').unbind('.dynPanel');
            return true;
        }
        
        $('body').on('click.dynPanel', '.dyn-panel-toggler', function(e){
                
            e.stopPropagation();
            var el = $(this);
            var pPosition = el.position();
            pPosition.top = pPosition.top + el.height();
            pPosition.left = pPosition.left + (el.width() / 2);
            var pTrg = el.data('panel-target');
            if(!pTrg) return false;
            var panel = el.siblings('.dyn-panel[rel="'+pTrg+'"]').css(pPosition);
            if(panel.is(':hidden')) panel.show();
            else panel.hide();
            $('.dyn-panel').not(panel).hide();
            
        }).on('click.dynPanel', function(){
            
            $('.dyn-panel').hide();
            
        });
        
    };
    
    $.fn.mess = function(){
        
        var mess_cont = $(this);
        var mess_ul = $('> ul:first', mess_cont);
        var mess_btn = $('.mess-btn', mess_cont);
        
        var on_change = function(str){
            
            mess_cont.removeClass('m e s');
            if(str) mess_cont.addClass(str);
            if(mess_ul.is(':hidden') && $('> li', mess_ul).size() > 0) mess_btn.click();
            
        };
        
        var add_ul = function(){
            
            if(mess_ul.size() < 1){
                
                mess_ul = $('<ul\>').prependTo(mess_cont);
                
            }
            
            mess_btn.css('cursor','pointer').off('.mToggle').on('click.mToggle', function(e){

                console.log('click');
                e.stopPropagation();
                if($('> li', mess_ul).size() > 0){

                    if(mess_ul.is(':visible')) mess_ul.slideUp(200);
                    else mess_ul.slideDown(200);

                }

            });

                
        };
        
        var add_li = function(cls, text){
            
            var new_li = $('<li/>').addClass(cls).html(text).appendTo(mess_ul).slideDown(100);
            mess_ul.scrollTo(new_li)
            .stopTime('mess-panele-close')
            .oneTime(5000, 'mess-panele-close', function(){
                
               mess_ul.slideUp(200); 
                
            });
            
        };
        
        var process_li = function(li){
            
            mess_ul.scrollTo(li)
            .stopTime('mess-panele-close')
            .oneTime(5000, 'mess-panele-close', function(){
                
               mess_ul.slideUp(200); 
                
            });
            
        };
        
        on_change();
        
        return {
            m: function(text){
                
                add_ul();
                add_li('m', text);
                on_change('m');
                
            },
            e: function(text){
                
                add_ul();
                add_li('e', text);
                on_change('e');
                
            },
            s: function(text){
                
                add_ul();
                add_li('s', text);
                on_change('s');
                
            },
            render: function(){
                
                add_ul();
                var mLines = $('> li', mess_ul);
                var stat = 'm';
                if(mLines.size() > 0){
                    
                   mLines.each(function(i, el){

                       process_li(el);

                   });
                    on_change(mLines.filter('li:last').attr('class'));
                    
                }
                
            }
        };
        
    };
    
    $.mess = function(){
      
        return $('#messages').mess();
        
    };

    // todo
    $.fn.checkAll = function(target){
        
        target = $(target);
        
        $(this).on('change.checkall', function(){
          
            if($(this).is(':checked') === true) target.attr('checked', true);
            else target.removeAttr('checked');
                
        });
        
    }
    
})(jQuery);



$(function(){

    // Плагин для выбора узла в многомерном дереве
    $('form .field.branch-sel').each(function(){

        var branchEl = $(this);
        var branchList = $('ul.tree-list', branchEl);
        var branchListLi = $('li', branchList);
        var branchSelVal = $('.tree-list-value', branchEl);
        var branchSelBtn = $('button', branchEl);
        var branchSelLabel = $('.tree-list-label', branchEl);

        if(branchListLi.size() > 0){
            
            var lockBranch = function(nid, iid){
                
                $('a[data-value]', branchEl).removeClass('lock').removeAttr('title');
                var firstB = $('a[data-value="'+nid+'"]', branchEl);
                firstB.add($('li[data-item-id="'+iid+'"]', branchEl));
                if(firstB.size() > 0){
                    
                    firstB.addClass('lock').attr('title', 'Нельзя выбрать самого себя!');
                    firstB.parent('li').find('ul a').addClass('lock').attr('title', 'Нельзя выбирать свои дочерние узлы!');
                    return true;
                    
                }
                return false;
                
            };
            
            var curA = $('a[data-value="'+branchSelVal.val()+'"]', branchEl);
            var curLi = curA.parent('li');
            branchSelLabel.text(curA.text()+' (nid'+curA.data('value')+')');
            
            var lockNid = branchSelVal.data('lock-nid');
            if(lockNid) lockBranch(lockNid);
            
            branchListLi.each(function(){
                
                var curLi = $(this);
                $('a', curLi).on('click.branchsel', function(e){
                    
                    var a = $(this);
                    e.preventDefault();
                    e.stopPropagation();
                    if(!a.hasClass('lock')){
                        branchSelVal.val(a.data('value'));
                        branchSelLabel.text(a.text()+' (nid'+a.data('value')+')');
                        branchList.hide();
                    }
                    
                });
                
                if(curLi.data('item-id') != '0'){
                    
                    var chlds = $('> ul:has(li)', curLi);
                    if(chlds.size() > 0){
                        
                        chlds.hide();
                        var cbtn = $('<i class="treeCps"/>').prependTo(curLi);
                        cbtn.removeClass('m').addClass('p')
                        .on('click', function(e){
                            
                            e.stopPropagation();
                            var thisUl = $(this).siblings('ul');
                            if(thisUl.is(':visible')){
                                
                                thisUl.hide();
                                cbtn.removeClass('m').addClass('p');
                                
                            }else{
                                
                                thisUl.show();
                                cbtn.removeClass('p').addClass('m');
                                
                            }
                            
                        });
                        
                    }
                    
                }
                    
            });

            branchSelBtn.on('click', function(e){
               
                console.log('btnClick');
                e.stopPropagation();
                if(branchList.is(':hidden')){
                    
                    $(document).on('click.branchsel', function(e){
                        
                        e.stopPropagation();
                        branchList.hide();
                        $(document).off('.branchsel');
                        
                    });
                    var btnPos = branchSelBtn.position();
                    branchList.css({top:(btnPos.top+branchSelBtn.outerHeight())+'px', left:btnPos.left+'px'}).show();
                    
                }else{
                    
                    branchList.hide();
                    
                }
                
            });

        }

    });

    $.treeGreedCollapse(true);
    $.ajaxToElements(true);
    $.ajaxToForms(true);
    $.dynPanelToggler(true);
    $.mess().render();
    $('.greed input[type="checkbox"].checkAll').checkAll('.greed .row input[type="checkbox"]');
    
});