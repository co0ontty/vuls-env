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
      url: that.own_name + '&c=map&a=doGetSiteMap'
    },
    function(result) {
      let data = result.data
      Object.keys(data).map(item => {
        if (item === 'met_sitemap_auto') {
          if (data[item] > 0 && $(`[name="${item}"]`).val() === '0') $(`[name="${item}"]`).click()
          return
        }
        if (item === 'met_sitemap_lang') {
          $(`#met_sitemap_lang-${data[item]}`).attr('checked', 'checked')
          return
        }
        if (data[item] > 0) {
          $(`[name=${item}]`).attr('checked', 'checked')
        }
      })
    }
  )
}
