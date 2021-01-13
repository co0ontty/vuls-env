define(function(require, exports, module) {

	var $ = jQuery = require('jquery');
	var common = require('common');

	$("button[type='submit']").click(function(){
		if(!$("select[name='class']").val()){
			common.metalert({html:METLANG.jslang4});
			return false;
		}
		$("input[name='class']").val($("select[name='class']").val());
	});
	$("button[data-next]").click(function(){
		var next = $(this).data("next");
		$("a[aria-controls='"+next+"']").click();
	});

	function classpara(value,type,dom){
		if(value){
			var values=value;
			var listbox = $(".paralistbox");
			value = value.toString();
			if(value.indexOf(',')!=-1){
				value = value.split(',');
				value = value[0];
			}
			if(value!=listbox.data("class")||type==1){
				listbox.data("class",value);
				$.ajax({
				   type: "GET",
				   url: listbox.data('paralist')+'&class='+value,
				   success: function(msg){
						listbox.html(msg);
						common.AssemblyLoad($(".paralistbox"));
						common.defaultoption($(".paralistbox"));
						if(dom){
							dom.removeClass('met-laoding').css("font-size","");
						}
				   }
				});
			}
			var url=$('[name="turnurl"]').val().split('&class1=')[0],
				class_val=values[0].split('-');
			$('[name="turnurl"]').val(url+'&class1='+class_val[0]+'&class2='+class_val[1]+'&class3='+class_val[2]);
			$('[name="class1"]').val(class_val[0]);
			$('[name="class2"]').val(class_val[1]);
			$('[name="class3"]').val(class_val[2]);
			var classother='';
			$.each(values, function(index, val) {
				 if(index){
				 	classother+='|-';
				 	val=val.split('-');
				 	$.each(val, function(index1, val1) {
				 		classother+=index1?'-'+val1:val1;
				 	});
				 	classother+='-';
				 }
			});
			classother && (classother+='|');
			$('[name="classother"]').val(classother);
		}
	}
	var selectclass = $("select[name='class']");
	selectclass.change(function(){
		classpara($(this).val());
	});
	var value = selectclass.data('value');
	if(value){
		if(value.indexOf(',')!=-1){
			value = value.split(',');
			for(var i=0;i<value.length;i++){
				selectclass.find("option[value='"+value[i]+"']").attr("selected",true);
			}
		}else{
			selectclass.val(value);
		}
		classpara(selectclass.val());
	}

	$(".refresh_para").click(function(){
		if(selectclass.val())$(this).addClass('met-laoding');
		classpara(selectclass.val(),1,$(this));
	});

	$("input[name='addtype']").change(function(){
		if($(this).val()==2){
			$("input[name='addtime']").focus();
		}
	});

});