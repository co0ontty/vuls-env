/*
字体大小下拉选择
 */
$.fn.fontSizeSelect=function(){
	var id='select-font'+new Date().getTime(),
		html='<datalist>'
			+'<option value="'+METLANG.default_values+'"></option>'
			+'<option value="12">12'+METLANG.setimgPixel+'</option>'
			+'<option value="14">14'+METLANG.setimgPixel+'</option>'
			+'<option value="16">16'+METLANG.setimgPixel+'</option>'
			+'<option value="18">18'+METLANG.setimgPixel+'</option>'
			+'<option value="20">20'+METLANG.setimgPixel+'</option>'
			+'<option value="22">22'+METLANG.setimgPixel+'</option>'
			+'<option value="24">24'+METLANG.setimgPixel+'</option>'
			+'<option value="26">26'+METLANG.setimgPixel+'</option>'
			+'<option value="28">28'+METLANG.setimgPixel+'</option>'
			+'<option value="30">30'+METLANG.setimgPixel+'</option>'
		+'</datalist>';
	$(this).attr({placeholder:METLANG.default_values}).after(html).each(function(index, el) {
		var this_id=id+index;
		$(this).val(parseInt($(this).val())?$(this).val():'').attr({list:this_id}).next('datalist').attr({id:this_id});
	});
};
(function(){
	// 字体大小切换
	$(document).on('change', '[data-plugin="select-fontsize"]', function(event) {
		var val=parseInt($(this).val());
		$(this).val(val?$(this).val():'');
	});
})();