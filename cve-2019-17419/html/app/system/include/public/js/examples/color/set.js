define(function(require, exports, module) {

	var common = require('common');
	require('epl/color/jquery.minicolors.css');
	require('epl/color/jquery.minicolors.min');
	exports.func = function(d){
		d.find('.ftype_color .fbox input').minicolors();
	}
});