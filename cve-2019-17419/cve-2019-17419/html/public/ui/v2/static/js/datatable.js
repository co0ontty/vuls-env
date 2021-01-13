/*
表格插件调用功能（需调用datatables插件）
 */
$.fn.metDataTable=function(){
    var $datatable=$('.dataTable',this);
    if($datatable.length){
        if(!performance.navigation.type && location.search.indexOf('&turnovertext=')<0){// 如果是重新进入页面，则清除DataTable表格的Local Storage，清除本插件stateSave参数保存的表格信息
            for(var i=0;i<localStorage.length;i++){
                if(localStorage.key(i).indexOf('DataTables_')>=0) localStorage.removeItem(localStorage.key(i));
            }
        }
        var datatable_langurl= M['weburl']+'app/system/include/static2/vendor/datatables/language/';
        // datatable多语言选择
        if("undefined" != typeof M){
            switch(M['synchronous']){
                case 'sq':datatable_langurl+='AL';break;
                case 'ar':datatable_langurl+='MA';break;
                // case 'az':datatable_langurl+='az';break;
                // case 'ga':datatable_langurl+='ie';break;
                // case 'et':datatable_langurl+='ee';break;
                case 'be':datatable_langurl+='BE';break;
                case 'bg':datatable_langurl+='BG';break;
                case 'pl':datatable_langurl+='PL';break;
                case 'fa':datatable_langurl+='IR';break;
                // case 'af':datatable_langurl+='za';break;
                case 'da':datatable_langurl+='DK';break;
                case 'de':datatable_langurl+='DE';break;
                case 'ru':datatable_langurl+='RU';break;
                case 'fr':datatable_langurl+='FR';break;
                // case 'tl':datatable_langurl+='ph';break;
                case 'fi':datatable_langurl+='FI';break;
                // case 'ht':datatable_langurl+='ht';break;
                // case 'ko':datatable_langurl+='kr';break;
                case 'nl':datatable_langurl+='NL';break;
                // case 'gl':datatable_langurl+='es';break;
                case 'ca':datatable_langurl+='ES';break;
                case 'cs':datatable_langurl+='CZ';break;
                // case 'hr':datatable_langurl+='hr';break;
                // case 'la':datatable_langurl+='IT';break;
                // case 'lv':datatable_langurl+='lv';break;
                // case 'lt':datatable_langurl+='lt';break;
                case 'ro':datatable_langurl+='RO';break;
                // case 'mt':datatable_langurl+='mt';break;
                // case 'ms':datatable_langurl+='ID';break;
                // case 'mk':datatable_langurl+='mk';break;
                case 'no':datatable_langurl+='NO';break;
                case 'pt':datatable_langurl+='PT';break;
                case 'ja':datatable_langurl+='JP';break;
                case 'sv':datatable_langurl+='SE';break;
                case 'sr':datatable_langurl+='RS';break;
                case 'sk':datatable_langurl+='SK';break;
                // case 'sl':datatable_langurl+='si';break;
                // case 'sw':datatable_langurl+='tz';break;
                case 'th':datatable_langurl+='TH';break;
                // case 'cy':datatable_langurl+='wls';break;
                // case 'uk':datatable_langurl+='ua';break;
                // case 'iw':datatable_langurl+='';break;
                case 'el':datatable_langurl+='GR';break;
                case 'eu':datatable_langurl+='ES';break;
                case 'es':datatable_langurl+='ES';break;
                case 'hu':datatable_langurl+='HU';break;
                case 'it':datatable_langurl+='IT';break;
                // case 'yi':datatable_langurl+='de';break;
                // case 'ur':datatable_langurl+='pk';break;
                case 'id':datatable_langurl+='ID';break;
                case 'en':datatable_langurl+='English';break;
                case 'vi':datatable_langurl+='VN';break;
                case 'zh':datatable_langurl+='Chinese-traditional';break;
                default:datatable_langurl+='Chinese';break;
            }
        }else{
            datatable_langurl+='Chinese';
        }
        datatable_langurl+='.json';
        window.datatableOption=function(obj,datatable_order){
            // 列表class
            var cadcs = obj.find("th[data-table-columnclass]"),
                cjson=[];
            if(cadcs.length>0){
                cadcs.each(function(i){
                    var c = $(this).attr("data-table-columnclass"),n=$(this).index();
                    cjson[i] = [];
                    cjson[i]['className'] = c;
                    cjson[i]['targets']=[];
                    cjson[i]['targets'][0] = n;
                });
            }
            // 插件参数
            datatable_order=datatable_order||0;
            var option={
                    scrollX: M['device_type']=='m'?true:'',
                    sDom: 'tip',
                    responsive: true,
                    ordering: false, // 是否支持排序
                    searching: false, // 搜索
                    searchable: false, // 让搜索支持ajax异步查询
                    lengthChange: false,// 让用户可以下拉无刷新设置显示条数
                    pageLength:parseInt(obj.data('table-pagelength'))||30,// 每页显示数量
                    pagingType:'full_numbers',// 翻页按钮类型
                    serverSide: true, // ajax服务开启
                    stateSave:true,// 状态保存 - 再次加载页面时还原表格状态
                    sServerMethod:obj.data('table-type')||'POST',
                    language: {
                        url:datatable_langurl
                    },
                    ajax: {
                        url: obj.data('table-ajaxurl')||obj.data('ajaxurl'),
                        data: function ( para ) {
                            var para_other={};
                            if($("[data-table-search]").length){
                                $("[data-table-search]").each(function(index,val){
                                    para_other[$(this).attr('name')]=$(this).val();
                                });
                            }
                            return $.extend({},para,para_other);
                        }
                    },
                    initComplete: function(settings, json) {// 表格初始化回调函数
                        var $wrapper=$(this).parents('.dataTables_wrapper'),
                            $paginate=$wrapper.find('.dataTables_paginate'),
                            $info=$wrapper.find('.dataTables_info');
                        $wrapper.addClass('clearfix');
                        $paginate.addClass('pull-xs-left');
                        $info.addClass('pull-xs-right');
                        if(json.recordsTotal>settings._iDisplayLength){
                            // 跳转到某页
                            var gotopage_html='<div class="gotopage pull-xs-left m-t-15 m-l-10"><span>跳转到第</span> <input type="text" name="gotopage" class="form-control form-control-sm w-50 text-xs-center"/> 页 <input type="button" class="btn btn-default btn-sm gotopage-btn" value="跳转"/></div>';
                            $paginate.after(gotopage_html);
                            var $gotopage=$paginate.next('.gotopage');
                            $gotopage.find('.gotopage-btn').click(function(event) {
                                var gotopage=parseInt($gotopage.find('input[name=gotopage]').val());
                                if(!isNaN(gotopage)){
                                    gotopage--;
                                    datatable[datatable_order].page(gotopage).draw(false);
                                }
                            });
                        }
                    },
                    drawCallback: function(settings){// 表格重绘后回调函数
                        var $this_scroll=$(window),
                            $show_body=$(this).data('show_body')?$($(this).data('show_body')):$(this);
                        if($(this).data('show_body')){
                            $show_body.metCommon();
                        }else{
                            $('tbody',this).metCommon();
                        }
                        $show_body.parents().each(function(index, el) {
                            if($(this).height()>0 && $(this).css('overflow-y')=='auto' || $(this).css('overflow-y')=='scroll'){
                                $this_scroll=$(this);
                                return false;
                            }
                        });
                        var this_top=$show_body.offset().top-($this_scroll.offset()?$this_scroll.offset().top:0);
                        if($this_scroll.scrollTop()>this_top) $this_scroll.scrollTop(this_top);// 页面滚动回表格顶部
                        $('#'+$(this).attr('id')+'_paginate .paginate_button.active').addClass('disabled');
                        // 添加表单验证
                        if(typeof $.fn.metFormAddField !='undefined') $show_body.metFormAddField();
                    },
                    rowCallback: function(row,data){// 行class
                        if(data.toclass) $(row).addClass(data.toclass);
                    },
                    columnDefs: cjson// 单元格class
                };
            if(typeof datatable_option!='undefined'){
                if(typeof datatable_option[datatable_order]['dataSrc']!='undefined') option.ajax.dataSrc=datatable_option[datatable_order]['dataSrc']; // 自定义的表格返回数据处理
                if(typeof datatable_option[datatable_order]['columns']!='undefined') option.columns=datatable_option[datatable_order]['columns']; // 自定义表格单元格对应的数据名称
            }
            return option;
        };
        if($('.dataTable',this).length){
            /*动态事件绑定，无需重载*/
            if(typeof datatable =='undefined'){
                window.datatable=[];
                // 自定义搜索框
                $(document).on('change',"[data-table-search]",function(){
                    if($(this).parents('.form-group').hasClass('has-danger')) return false;
                    if(typeof datatable != 'undefined'){
                        var $this_datatable=$(this).parents('.dataTable'),
                            datatable_order=$this_datatable.index('.dataTable');
                            if(datatable_order<0) datatable_order=0;
                        typeof datatable[datatable_order]!='undefined' && datatable[datatable_order].ajax.reload();
                    }
                })
            }
            $datatable.each(function(index, el) {
                if($(this).data('table-ajaxurl')) datatable[index]=$(this).DataTable(datatableOption($(this),index));
            });
        }
    }
};
$(document).metDataTable();