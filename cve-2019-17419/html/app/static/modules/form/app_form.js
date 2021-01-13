/*
应用表格功能
 */
(function(){
	$.fn.extend({
		// 表单两种类型提交前的处理（保存、删除）
        metSubmit:function(type){
            // 插入submit_type字段
            var type=typeof type!='undefined'?type:1,
                type_str=type?(type==1?'save':type):'del';
            if($(this).find('table').length){
                if(type=='recycle'){
                    type_str='del';
                    $(this).append(M.component.formWidget('recycle',1));
                }else{
                    $(this).find('[name="recycle"]').remove();
                }
            }
            if(!$(this).find('[name="submit_type"]').length) $(this).append(M.component.formWidget('submit_type',''));
            $(this).find('[name="submit_type"]').val(type_str);
            // 插入表格的allid字段
            if($(this).find('table').length){
                var $table=$(this).find('table'),
                    // checked_str=type==1?'':':checked',
                    $checkbox=$table.find('tbody input[type="checkbox"][name="id"]:checked'/*+checked_str*/),
                    allid='';
                $checkbox.each(function(index, el) {
                    allid+=allid?','+$(this).val():$(this).val();
                })
                if(!$(this).find('[name="allid"]').length) $(this).append(M.component.formWidget('allid',''));
                $(this).find('[name="allid"]').val(allid);
            }
        },
        // 表单更新验证
        metFormAddField:function(name){
            var $form=$(this)[0].tagName=='FORM'?$(this):$(this).parents('form');
            if($form.length){
                if(name){
                    if(!$.isArray(name)){
                        if(name.indexOf(',')>=0){
                            name=name.split(',');
                        }else name=[name];
                    }
                    metui.use('formvalidation',function(){
                        $.each(name, function(index, val) {
                            $form.data('formValidation').addField(val);
                        })
                    })
                }else{
                    var name_array=[],
                        $name=$('[name]',this);
                    metui.use('formvalidation',function(){
                        $name.each(function(index, el) {
                            var name=$(this).attr('name');
                            if($.inArray(name, name_array)<=0){
                                name_array.push(name);
                                if(typeof $(this).attr('required') !='undefined'){
                                    $form.data('formValidation').addField(name);
                                }else{
                                    $.each($(this).data(), function(index, val) {
                                        var third_str=index.substr(2,1);
                                        if(index.substr(0,2)=='fv' && index.length>2 && third_str >= 'A' && third_str <= 'Z'){
                                            $form.data('formValidation').addField(name);
                                            return false;
                                        }
                                    });
                                }
                            }
                        });
                    });
                }
            }
        },
	});
	// 点击保存按钮
    $(document).on('click', 'form .btn[type="submit"]', function(event) {
        if(($(this).data('plugin')=='alertify' && $(this).data('type')=='confirm')||$(this).data('url')) event.preventDefault();
        var $form=$(this).parents('form');
        $form.attr({'data-submited':1}).metSubmit($(this).data('submit_type'));
        if($(this).data('url')){
            $form.removeAttr('data-submited');
            var $table=$(this).parents('.dataTable');
            $.ajax({
                url: $(this).data('url'),
                type: 'POST',
                dataType: 'json',
                data: $form.serializeArray(),
                success:function(result){
                    if($table.length){
                        $table.tabelAjaxFun(result);
                    }else{
                        metAjaxFun({result:result});
                        $('.met-pageset').length && parseInt(result.status) && $('.page-iframe').attr({'data-reload':1});
                    }
                }
            });
        }
    });
    // 表单输入框回车时，触发提交按钮
    $(document).on('keydown', 'form input[type="text"]', function(event) {
        if(event.keyCode==13 && $(this).parents('form').find('[type="submit"].disabled,[type="submit"].disableds').length){
            event.preventDefault();
            // $(this).parents('form').submit();
        }
    });
    // 表单提交
    $(document).on('submit', 'form', function(event) {
        if($(this).attr('action').indexOf('http')<0) return;
        var $self=$(this);
        $(this).attr('data-submited')?setTimeout(function(){$self.removeAttr('data-submited')},500):$(this).metSubmit();
        $('.dataTable',this).attr({'data-scrolltop':0});
        // 提交删除时没有勾选时提示
        if($(this).find('[name="submit_type"]').length && $(this).find('table tbody tr td .checkall-item').length && $(this).find('[name="allid"]').val()==''){
            event.preventDefault();
            metui.use('alertify',function(){alertify.error(METLANG.jslang3||'请选择至少一项')});
            var $submit=$(M.component.submit_selctor,this);
            $submit.removeAttr('disabled').removeClass('disabled');
        }
        $(this).find('.has-danger').length && $(this).find('.has-danger:eq(0)').attr('tabindex',11).focus().removeAttr('tabindex').find('[name]:visible').focus();
    });
})();
// 表单提交后回调添加自定义方法
function formSaveCallback(order,fn){
    if(typeof validate_fun[order]!='undefined'){
        typeof fn.true_fun=='function' && validate_fun[order].success.true_fun.push(fn.true_fun);
        typeof fn.false_fun=='function' && validate_fun[order].success.false_fun.push(fn.false_fun);
        delete fn.true_fun;
        delete fn.false_fun;
        $.extend(true, validate_fun[order].success, fn);
    }else{
        validate_fun[order]={
            success:{
                true_fun:typeof fn.true_fun=='function'?[fn.true_fun]:[],
                false_fun:typeof fn.false_fun=='function'?[fn.false_fun]:[]
            }
        };
    }
}