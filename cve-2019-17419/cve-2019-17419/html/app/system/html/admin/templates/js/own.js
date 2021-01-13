define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
	var langtxt = common.langtxt();

	$(document).ready(function(){
		if($('#auto').val() == 1){
			ajax_html($('.v52fmbx').find('a').eq(0).data('url'));
		}
	});

	$(document).on('click',".html", function(){
		return ajax_html($(this).data('url'));
	});

	function ajax_html(url){
		$.ajax({
			url: url,
			dataType: 'json',
			type: "GET",
			cache : false,
			success: function(data) {
				if (data.suc == 1) {
					console.log(data);
					generatehtm(data.json, 0);
				} else {
					// alert(user_msg['jsx12']);
					// nxt.empty();
					// hl = 0;
				}
			}
		});
		return false;
	}

	$(document).on('click',".submit", function(){
		var web_html = $("[name = 'met_webhtm']:checked").val();
		var web_html_or = $("[name = 'webhtm']").val();
		if(web_html == 0 && web_html_or != web_html){
			if(confirm($(this).data('del-html'))){
				$("input[name='op']").val(1);
			}
		}
		if(web_html != 0 && web_html_or != web_html){
			if(confirm($(this).data('generate-html'))){
				$("input[name='op']").val(1);
			}
		}
		return true;
	});

	function generatehtm(json, num){
		var nowp = json[num];
		num++;
		if(nowp){
			$.ajax({
				url: nowp.url,
				dataType: 'json',
				type: "GET",
				cache : false,
				error: function() {
					//alert('生成失败');
					$('#htmlloading .listbox').prepend(nowp.fail+"<br />");
					generatehtm(json, num);
				},
				success: function(data) {
					if (data.suc == 1) {
						$('#htmlloading .listbox').prepend(nowp.suc+"<br />");
					} else {
						$('#htmlloading .listbox').prepend(nowp.fail+"<br />");
						//alert('生成失败');
						// alert(user_msg['jsx12']);
						// nxt.empty();
						// hl = 0;
					}
					generatehtm(json, num);
				}
			});
		}else{
			$('#htmlloading .listbox').prepend(METLANG.html_createend_v6+"<br />");
			if($('#reurl').val()){
				//alert($('#reurl').val());
				window.location.href = $('#reurl').val();
			}
		}
	}
});
