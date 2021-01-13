;(function() {
  var that = $.extend(true, {}, admin_module),
    obj = that.obj
  init()
  TEMPLOADFUNS[that.hash] = function() {
    init(1)
  }
  function init(refresh) {
    $.ajax({
      url: that.own_name + '&c=info&a=doGetInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if (item === 'data_key') {
            $(`[name="met_ico"]`).attr(
              'data-url',
              $(`[name="met_ico"]`)
                .attr('data-url')
                .split('data_key=')[0] +
                'data_key=' +
                data[item]
            )
            return
          }
          if (item === 'met_footother') {
            $(`[name="met_footother"]`).html(data[item])
            return
          }
          $(`[name=${item}]`).attr('type') == 'file' ? $(`[name=${item}]`).attr('value', data[item]) : $(`[name=${item}]`).val(data[item])
        })
        if (!refresh) {
          that.obj.metCommon()
        }
      }
    })
  }
})()
