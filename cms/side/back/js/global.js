(function($){

// измерение длины объекта
$.arrSize = function(arr){
	return Array.isArray(arr) ? arr.length : typeof arr == 'object' ? Object.keys(arr).length : -1;
};
    
// разбор url на компаненты
$.parseURL = function(url){
    
	var s = {};
	var pattern = "^(([^:/\\?#]+):)?(//(([^:/\\?#]*)(?::([^/\\?#]*))?))?([^\\?#]*)(\\?([^#]*))?(#(.*))?$";
    var rx = new RegExp(pattern); 
    var parts = rx.exec(url);
	s.href = parts[0] || '';
    s.protocol = parts[1] || '';
    s.host = parts[4] || '';
    s.hostname = parts[5] || '';
    s.port = parts[6] || '';
    s.pathname = parts[7] || '/';
    s.search = parts[8] || '';
    s.hash = parts[10] || '';
	var ss = s.search.replace(/^\?*/i, '').replace(/\?*$/i, '').split('&');
	//console.log(ss);
	//console.log(ss.length);
	if(ss.length>0){
		s.search = {};
		$.each(ss,function(i,v){ var t = v.split('='); s.search[unescape(t[0])]=unescape(t[1]); });
	}
	//console.log(s);
	return s;
    
};
    
// построение url изданных олусенных через parseUrl
$.buildURL = function(s){
    
	s.href = s.href || '';
    s.protocol = s.protocol || 'http:';
    s.hostname = s.hostname || '';
    s.port = s.port || '';
    s.host = s.host || s.hostname+(s.port ? ':'+s.port : '');
    s.pathname = s.pathname || '/';
    s.search = s.search || '';
    s.hash = s.hash || '';
	if(typeof s.search == 'object'){
		srch = [];
		$.each(s.search,function(i,v){ srch.push(escape(i)+'='+escape(v)); });
		s.search = (srch.length>0) ? '?'+srch.join('&') : '';
	}
	return s.protocol + '//' + s.host + s.pathname + s.search + s.hash;
    
};

})(jQuery);