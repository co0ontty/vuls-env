;(function() {
  var that = $.extend(true, {}, admin_module)
  init()
  TEMPLOADFUNS[that.hash] = function() {
    init()
  }
  function init() {
    const advanced_search_range_2 = $('.advanced_search_range_2 ')
    const advanced_search_range = $(`[name="advanced_search_range"]`)
    const checked = advanced_search_range.data('checked')
    if (checked === 'parent') {
      advanced_search_range_2.removeClass('hide')
    }
    advanced_search_range.change(function(e) {
      const value = e.target.value
      if (value === 'parent') {
        advanced_search_range_2.removeClass('hide')
      } else {
        advanced_search_range_2.addClass('hide')
      }
    })
  }
})()
