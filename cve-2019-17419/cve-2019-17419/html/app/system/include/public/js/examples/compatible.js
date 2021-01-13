define(function(require, exports, module) {

	var $ = jQuery = require('jquery');
	require('epl/include/cookie');
	require('pub/bootstrap/js/bootstrap.min');
	$(document).ready(function() {
		/*上传组件*/
		window.adminurl = window.adminurl+'index.php?lang='+window.lang+'&';
		var upload = $('.ftype_upload .fbox input');
		if(upload.length){
			require.async('epl/upload/own',function(a){
				a.func($('body'));
			});
		}
		// 颜色选择组件（新模板框架banner文字颜色属性组件）
		if($('.ftype_color').length>0){
			require.async(['epl/color/jquery.minicolors.css','epl/color/jquery.minicolors.min'],function(){
				$('.ftype_color .fbox input').minicolors();
			});
		}
	});
});
