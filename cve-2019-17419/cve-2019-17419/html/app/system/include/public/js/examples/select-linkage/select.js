define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
		require('epl/select-linkage/jquery.cityselect');
	exports.func = function(d){
		d = d.find('.ftype_select-linkage .fbox');
		d.each(function(){
			var p = $(this).find(".prov").attr("data-checked"),
				c = $(this).find(".city").attr("data-checked"),
				s = $(this).find(".dist").attr("data-checked");
				p = p?p:'';
				c = c?c:undefined;
				s = s?s:undefined;
			var url = $(this).attr('data-selectdburl')?$(this).attr('data-selectdburl'):pubjspath+"js/examples/select-linkage/city.min.php";
			$(this).citySelect({url:url,prov:p, city:c, dist:s, nodata:"none"});
		});
	}
	
});