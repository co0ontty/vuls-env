/*
招聘模块
 */
(function(){
	$(function(){
		// 招聘模块表单
		$(".met-job-cvbtn").click(function(){
			var $job_modal=$($(this).data('target'));
			$job_modal.find('form input[name="jobid"]').val($(this).data('jobid'));
		});
	});
})();