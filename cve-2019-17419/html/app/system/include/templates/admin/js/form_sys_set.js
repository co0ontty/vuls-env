/*
反馈、招聘系统设置
 */
(function(){
	M.component.modal_call_status.form_sys_set=[];
	metui.use(['form','app_form'],function(){
		var that=$.extend(true,{}, admin_module),
			hash=that.hash=='job/set'?'feedback/set':'job/set',
			formSaveCallbackItem=function(){
				var thats=$.extend(true,{}, admin_module),
					order=thats.obj.find('[data-validate_order]').attr('data-validate_order');
				if(!M.component.modal_call_status.form_sys_set[order]){
					M.component.modal_call_status.form_sys_set[order]=1;
					formSaveCallback(order,{
			            true_fun: function() {
			                $($(order).parents('.content-show-item').find('.met-headtab a[data-url*="'+thats.module+'/list/"]').attr('href')).removeAttr('data-loaded');
			            }
			        });
				}
			};
		formSaveCallbackItem();
		// 表单系统设置保存后销毁表单信息列表的已加载状态，以使表单信息列表页面重新加载
		TEMPLOADFUNS[that.hash]=formSaveCallbackItem;
		TEMPLOADFUNS[hash]=formSaveCallbackItem;
	});
	// 招聘设置
	$(document).on('click', '#job-set-form input[name="met_cv_emtype"]', function(event) {
		var $dl=$(this).parents('form').find('input[name="met_cv_to"]').parents('dl');
		if(parseInt($(this).val())){
			$dl.addClass('hide');
		}else{
			$dl.removeClass('hide');
		}
	});
})();