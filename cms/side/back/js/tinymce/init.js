tinymce.init({
  selector: ".editor",
  height: 300,
  relative_urls: true,
  language: "ru",
  plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
  ],

  toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect",
  toolbar2: "cut copy paste removeformat | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media | forecolor backcolor | table | hr subscript superscript | visualblocks  restoredraft | fullscreen preview code ",

  menubar: false,
  toolbar_items_size: 'small',
  force_p_newlines : true,
  apply_source_formatting : false,
  forced_root_block :'',
  filemanager_title: 'Файловый менеджер',
  external_filemanager_path: '/system/filemanager/',
  external_plugins: { 'filemanager' : '/system/filemanager/plugin.min.js' },
});



(function($){

// Вызов файлового менеджера для отдельного от редактора использования. На onclick вешаем вызов этой функции
$.fileBrowserCall = function(){
	var overley = $('<div class="modal-overley"/>').appendTo('body');
	var mod_win = $('<div class="modal-window"/>').appendTo(overley);
	var close_win = $('<div class="modal-window-close">X</div>').appendTo(mod_win); 
	$('<div class="helper"/>').appendTo(overley);
	var iframe = $('<iframe width="100%" height="100%" frameborder="0" src="/system/filemanager/dialog.php?type=0"></iframe>').appendTo(mod_win);
	close_win.css('cursor','pointer').attr('title','Закрыть файловый менеджер').click(function(){
		overley.fadeOut(function(){ $(this).remove(); });
	});
	overley.click(function(e){ e.stopPropagation(); overley.fadeOut(function(){ $(this).remove(); }); });
}

})(jQuery);