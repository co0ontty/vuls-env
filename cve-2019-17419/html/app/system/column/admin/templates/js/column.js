/**
 * 栏目模块
 */
(function(){
    var that=$.extend(true,{}, admin_module),
        obj=that.obj,
        column_table='#column-list',
        $column_list=obj.find(column_table),
        delurl=that.own_name+'c=index&a=doDeleteColumn&id=',
        moveurl=that.own_name+'c=index&a=domove',
        edit_dataurl='?c=index&a=doGetColumn&id=',
        config={
            module_option:function(classtype,parent_module,fn){
                var html='',
                    parent_module=parent_module||'';
                metui.ajax({
                    url: that.own_name+'c=index&a=doGetModlist'
                },function(result){
                    $.each(result, function(index, val) {
                        val.mod=parseInt(val.mod);
                        val.num=parseInt(val.num);
                        if(classtype==3 && val.mod!=parent_module && val.mod) return true;
                        if((val.mod==6 && val.num && parent_module!=6) || (parent_module==6 && val.mod!=parent_module)) return true;
                        html+='<option value="'+val.mod+'">'+val.name+'</option>';
                    });
                    (typeof fn==='function')&&fn(html);
                });
            }
        },
        columnList=function(data){// 栏目列表数据渲染
            var new_data=[];
            $.each(data, function(index, val) {
                var list=[];
                val.module=parseInt(val.module);
                list.push(M.component.checkall('item',val.id)
                        +M.component.formWidget('bigclass-'+val.id,val.bigclass)
                        +M.component.formWidget('classtype-'+val.id,val.classtype)
                        +M.component.formWidget('index_num-'+val.id,val.index_num));
                list.push(M.component.formWidget('no_order-'+val.id,val.no_order,'text',1,'','text-center'));
                var name_html=M.component.formWidget('name-'+val.id,val.name,'text',1,1);
                if(val.subcolumn){
                    name_html='<div class="input-group">'
                        +'<div class="input-group-prepend">'
                            +'<a href="javascript:;" class="input-group-text px-2 btn-show-subcolumn"><i class="fa-angle-down h5 mb-0"></i></a>'
                        +'</div>'
                        +name_html
                    +'</div>'
                }
                list.push('<div class="form-group '+(val.classtype>1?'pl-'+(val.classtype==2?4:5):'')+'">'+name_html+'</div>');
                nav_option_val='<select name="nav-'+val.id+'" data-checked="'+val.nav+'" class="form-control">'+config.nav_option+'</select>';
                list.push('<span>'+nav_option_val+'</span>');
                list.push('<span>'+val.module_name+'</span>'+M.component.formWidget('module-'+val.id,val.module));
                list.push('<span class="text-break">'+val.foldername+'</span>'+M.component.formWidget((val.module?'foldername':'out_url')+'-'+val.id,(val.module?val.foldername:val.out_url)));
                var action_more='';
                if(val.action.add_subcolumn) action_more+='<a href="javascript:;" class="dropdown-item btn-add-column">'+METLANG.addsubcolumn+'</a>';
                if(val.action.columnmove){
                    var columnmove='';
                    if(val.classtype>1 && val.action.top_column) columnmove+='<a href="javascript:;" class="dropdown-item px-3" data-uplv="1" data-top_column="'+val.action.top_column+'">'+METLANG.columnerr7+'</a>';
                    if(val.action.move_columns){
                        if(val.classtype>1) columnmove+='<div class="dropdown-divider"></div>';
                        $.each(val.action.move_columns, function(index1, val1) {
                            columnmove+='<a href="javascript:;" class="dropdown-item px-3" data-id="'+val1.id+'">'+val1.name+'</a>';
                        });
                    }
                    action_more+='<div class="dropdown dropdown-submenu dropleft"><a href="javascript:;" class="dropdown-item dropdown-toggle btn-move-column" data-toggle="dropdown">'+METLANG.columnmove1+'</a>'
                    +'<div class="dropdown-menu move-column-list oya met-scrollbar">'
                        +columnmove
                    +'</div>'
                    +'</div>';
                }
                list.push('<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target=".column-details-modal" data-modal-title="'+METLANG.columnmeditor+'" data-modal-size="lg" data-modal-url="column/edit/'+edit_dataurl+val.id+'" data-modal-fullheight="1" data-modal-tablerefresh="'+column_table+'">'+METLANG.seting+'</button>'
                    +'<div class="dropdown d-inline-block">'
                        +'<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" data-submenu>'+METLANG.columnmore+'</button>'
                        +'<div class="dropdown-menu dropdown-menu-right">'
                            +action_more
                            +M.component.btn('del',{del_url:delurl+val.id,class:'dropdown-item btn-del-column',confirm_title:METLANG.delete_information+METLANG.jsx39})
                        +'</div>'
                    +'</div>');
                list['DT_RowClass']='class'+val.classtype;
                if(val.classtype>1) list['DT_RowClass']+=' hide';
                new_data[new_data.length]=list;
                if(val.subcolumn){
                    var new_datas=columnList(val.subcolumn);
                    new_data=new_data.concat(new_datas);
                }
            });
            return new_data;
        };
    // 栏目列表加载
    M.component.commonList(function(){
        return {
            ajax:{
                dataSrc:function(result){
                    config.nav_option='';
                    $.each(result.data.nav_list, function(index, val) {
                        config.nav_option+='<option value="'+index+'">'+val+'</option>';
                    });
                    var data=columnList(result.data.column_list);
                    return data;
                }
            }
        };
    });
    // 列表渲染后回调
    $column_list.on('draw.dt',function(event) {
        event.preventDefault();
        $column_list.find('tbody tr').each(function(index, el) {
            $(this).attr({'data-bigclass':$(this).find('[name*="bigclass"]').val(),'data-classtype':$(this).find('[name*="classtype"]').val()});
        });
        $column_list.find('.btn-show-allsubcolumn i').hasClass('rotate180') && obj.find('.btn-show-allsubcolumn2').click();
    });
    // 列表保存回调
    metui.use('app_form',function(){
        formSaveCallback($column_list.parents('form').attr('data-validate_order'),{
            true_fun:function(){
                window.column_refresh=1;
            }
        });
    });
    // 展开全部子栏目
    $column_list.find('.btn-show-allsubcolumn').click(function(event) {
        if(!$('i',this).hasClass('transition500')) $('i',this).addClass('transition500');
        $column_list.find('.btn-show-subcolumn i:not(.transition500)').addClass('transition500');
        obj.find('.btn-show-allsubcolumn2').html(METLANG[($('i.rotate180',this).length?'open':'close')+'_allchildcolumn_v6']);
        if($('i.rotate180',this).length){
            $column_list.find('tbody tr:not(.class1)').addClass('hide');
            $column_list.find('tbody tr').find('.btn-show-subcolumn i').removeClass('rotate180');
            obj.find('.btn-show-allsubcolumn2').html();
        }else{
            $column_list.find('tbody tr').removeClass('hide').find('.btn-show-subcolumn i').addClass('rotate180');
        }
        $('i',this).toggleClass('rotate180');
    });
    obj.find('.btn-show-allsubcolumn2').click(function(event) {
        $column_list.find('.btn-show-allsubcolumn').click();
    });
    // 展开子栏目
    $column_list.on('click', '.btn-show-subcolumn', function(event) {
        var toggleColumn=function(obj,hide){
                var $icon=obj.find('i[class*="fa-angle-"]');
                if(!$icon.hasClass('transition500')) $icon.addClass('transition500');
                if(hide){
                    $icon.removeClass('rotate180');
                }else $icon.toggleClass('rotate180');
                var $id=obj.parents('tr').find('[name="id"]'),
                    son_classtype=parseInt(obj.parents('tr').find('[name*="classtype-"]').val())+1,
                    $sub=$column_list.find('[name*="bigclass-"][value="'+$id.val()+'"]').parents('tr.class'+son_classtype);
                if($icon.hasClass('rotate180')){
                    $sub.stop().removeClass('hide');
                }else{
                    $sub.stop().addClass('hide');
                }
                if(son_classtype==2&&!$icon.hasClass('rotate180')){
                    $sub.each(function(index, el) {
                        toggleColumn($(this).find('.btn-show-subcolumn'),1);
                    });
                }
            };
        toggleColumn($(this));
    });
    // 添加一级栏目、子栏目
    obj.on('click', column_table+' .btn-add-column,[table-addlist="'+column_table+'"]', function(event) {
        var $self=$(this);
        if($(this).hasClass('btn-add-column')){
            var $tr=$(this).parents('tr'),
                id=$tr.find('[name="id"]').val(),
                son_classtype=parseInt($tr.find('[name*="classtype-"]').val())+1,
                module=parseInt($tr.find('[name*="module-"]').val()),
                $sub=$column_list.find('tbody [name*="bigclass-"][value="'+id+'"]').parents('tr.class'+son_classtype);
            if(!$tr.find('.btn-show-subcolumn i').hasClass('rotate180')) $tr.find('.btn-show-subcolumn').click();
            $tr.after($column_list.find('tfoot textarea[table-addlist-data]').val());
        }else{
            var $tr=$column_list.find('tbody tr[role="row"]:last-child'),
                id=0,
                son_classtype=1,
                $sub=$column_list.find('tbody tr').filter(function(){
                    return $('td',this).length>1;
                });
        }
        setTimeout(function(){
            var $new_tr=$tr.length?$tr.next('tr'):$column_list.find('tbody tr:last-child');
            $self.hasClass('btn-add-column') && $new_tr.find('td:last-child').append(M.component.btn('cancel'));
            $new_tr.attr({class:'class'+son_classtype}).find('[name="no_order"]').val($sub.length);
            $new_tr.find('[name="classtype"]').val(son_classtype);
            $new_tr.find('[name="bigclass"]').val(id);
            $new_tr.find('[name="nav"]').html(config.nav_option);
            config.module_option(son_classtype,module,function(module_option){
                $new_tr.find('[name="module"]').html(module_option);
                $self.hasClass('btn-add-column') && $new_tr.find('[name="module"]').val(module).change();
            });
            $new_tr.find('.td-column-name .form-group').addClass('pl-'+(son_classtype>1?(son_classtype==2?4:5):''));
            $self.hasClass('btn-add-column')?($new_tr.find('[name="module"]').val(module).change(),$new_tr.metFormAddField()):(!$self.parents('table').length && obj.parents('.met-scrollbar:eq(0)').animate({scrollTop:obj.height()-obj.parents('.met-scrollbar:eq(0)').height()+100}, 300));
            $column_list.find('[type="submit"]').addClass('disabled disableds');
        },0);
    });
    // 切换栏目类型
    $column_list.on('change', '[name="module"]', function(event) {
        var value=parseInt($(this).val()),
            $tr=$(this).parents('tr'),
            bigclass=$tr.find('[name="bigclass"]').val(),
            $bigclass=$column_list.find('tbody [name="id"][value="'+bigclass+'"]').parents('tr'),
            name=value?'foldername':'out_url',
            foldername='',
            readonly=false,
            $foldername=$tr.find('[name="foldername"],[name="out_url"]');
        switch(value){
            case 6:
                foldername='job';
                break;
            case 7:
                foldername='message';
                break;
            case 10:
                foldername='member';
                break;
            case 11:
                foldername='search';
                break;
            case 12:
                foldername='sitemap';
                break;
            case 13:
                foldername='tags';
                break;
        }
        if(value==6||value==7||value==10||value==11||value==12||value==13) readonly=true;
        if(value==$bigclass.find('[name*="module-"]').val()){
            foldername=$bigclass.find('[name*="foldername-"]').val();
            readonly=true;
        }
        $foldername.val(foldername).attr({name:name,readonly:readonly}).change();
    });
    // 选中一级栏目的回调
    $column_list.on('click', 'tbody tr input[name="id"]', function(event) {
        var checked=$(this).prop("checked");
        $column_list.find('tbody tr input[name^="bigclass-"][value="'+$(this).val()+'"]').parents('td').find('input[name="id"]').filter(function(index) {
            return checked!=$(this).prop("checked");
        }).click();
    });
    // 移动栏目
    $column_list.on('click', '.move-column-list a:not([data-uplv])', function(event) {
        $.ajax({
            url: moveurl,
            type: 'POST',
            dataType: 'json',
            data: {
                nowid: $(this).parents('tr').find('[name="id"]').val(),
                toid: $(this).data('id')
            },
            success:function(result){
                $column_list.tabelAjaxFun(result);
            }
        });
    });
    // 升为一级栏目
    var uplv=function(id,foldername){
            $.ajax({
                url: moveurl,
                type: 'POST',
                dataType: 'json',
                data: {nowid: id,uplv: 1,foldername:foldername},
                success:function(result){
                    $column_list.tabelAjaxFun(result);
                }
            });
        };
    $column_list.on('click', '.move-column-list a[data-uplv]', function(event) {
        var $tr=$(this).parents('tr'),
            id=$tr.find('[name="id"]').val();
        if(parseInt($(this).data('top_column'))==2){
            metui.use('alertify',function(){
                var confirm_text='<h5>'+METLANG.column_inputcolumnfolder_v6+'</h5><span class="text-danger">'+METLANG.js56+'</span><br /><input name="foldername" required class="form-control mt-2 mb-0"/>';
                alertify.confirm(confirm_text, function (ev) {
                    uplv(id,$('.alertify .dialog [name="foldername"]').val());
                });
            })
        }else{
            uplv(id,$tr.find('[name*="foldername-"]').val());
        }
    });
})();