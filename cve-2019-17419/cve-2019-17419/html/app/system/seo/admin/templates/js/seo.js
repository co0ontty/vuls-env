;(function() {
  var that = $.extend(true, {}, admin_module),
    obj = that.obj
  init()

  TEMPLOADFUNS[that.hash] = function() {
    init(1)
  }
  function init(refresh) {
    $.ajax({
      url: that.own_name + '&c=seo&a=doGetParameter',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if (item === 'met_title_type') {
            $(`.met_title_type-${data[item]}`).attr('checked', 'checked')
            return
          }
          if (item === 'met_301jump') {
            if (data[item] > 0 && $(`[name="${item}"]`).val() === '0') $(`[name="${item}"]`).click()
            return
          }
          $(`[name=${item}]`).val(data[item])
        })
        if (!refresh) {
          obj.metCommon()
          metui.use(['form', 'app_form'], function() {
            var validate_order = obj.find('.info-form').attr('data-validate_order')
            formSaveCallback(validate_order, {
              true_fun: function(result) {
                M.met_keywords = obj.find('.info-form [name="met_keywords"]').val()
                M.met_alt = obj.find('.info-form [name="met_alt"]').val()
                M.met_atitle = obj.find('.info-form [name="met_atitle"]').val()
                M.is_admin ? window.location.reload() : null
              }
            })
          })
        }
      }
    })
  }
})()
