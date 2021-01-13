;(function() {
  var that = $.extend(true, {}, admin_module),
    obj = that.obj

  metui.use(['form', 'formvalidation'], function() {
    var order = $('.login-form').attr('data-validate_order')
    validate[order].success(function(res) {
      metAjaxFun({
        result: res,
        true_fun: function() {
          let source = getCookie('app_href_source')
          var href = M.url.admin + '#/'+source;
          M.is_admin?window.location.href =href:$('.btn-pageset-common-page').attr({'data-url':source}).trigger('clicks');
          if(!M.is_admin){
            setTimeout(function(){
              var title=$('.pageset-head-nav [data-url="'+source+'"]').text()||$('.pageset-nav-modal .nav-modal-item .met-headtab a[href="#/'+source+'"]').html();
              $('.pageset-nav-modal .modal-title').html(title);
            },500);
          }
        }
      })
    })
  })
  TEMPLOADFUNS[that.hash] = function() {}
})()