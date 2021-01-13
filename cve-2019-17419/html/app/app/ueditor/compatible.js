define(function(require, exports, module) {

	var $ = jQuery = require('jquery');
	require('epl/include/cookie');
	require('pub/bootstrap/js/bootstrap.min');
	var editor = $('textarea.ckeditor');
		if(editor.length){
			require.async('edturl/ueditor.config');
			require.async('edturl/ueditor.all.min',function(){
				editor.each(function(){
					var name = $(this).attr('name')
				
					$(this).attr("id",'container_'+name);
					var ue = UE.getEditor('container_'+name,{
						iframeCssUrl: siteurl + 'app/system/include/public/bootstrap/css/bootstrap.min.css',
						scaleEnabled :true,
						initialFrameWidth : '100%',
						initialFrameHeight : 400
					});
				});
			});
		}
		});