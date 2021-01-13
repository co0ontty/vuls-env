;(function() {
  var that = $.extend(true, {}, admin_module)
  fetch(that)
  TEMPLOADFUNS[that.hash] = function() {
    fetch(that)
  }
})()
function fetch(that) {
  metui.request(
    {
      url: that.own_name + '&c=admin_set&a=doGetemailSetup'
    },
    function(result) {
      let data = result.data
      Object.keys(data).map(item => {
        $(`[name=${item}]`).val(data[item])
      })
      that.obj.metCommon()
    }
  )
}
