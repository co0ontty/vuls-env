;(function() {
  var that = $.extend(true, {}, admin_module)
  init()
  TEMPLOADFUNS[that.hash] = function() {
    init()
  }
  function init() {
    $.ajax({
      url: that.own_name + '&c=thirdparty&a=doGetThirdparty',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          $(`[name=${item}]`).val(data[item])
        })
      }
    })
  }
})()
