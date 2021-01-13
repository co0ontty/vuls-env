;(function() {
  var that = $.extend(true, {}, admin_module)
  init()
  TEMPLOADFUNS[that.hash] = function() {
    init()
  }
  function init() {
    const checked = $('#global_search_range_1').data('checked')
    const module_collapse = $('#module-collapse')
    const column_collapse = $('#column-collapse')
    $(`[name="global_search_range"]`).change(function(e) {
      module_collapse.removeClass('show')
      column_collapse.removeClass('show')
      const value = e.target.value
      if (value === 'all') {
        module_collapse.removeClass('show')
        column_collapse.removeClass('show')
      }
      if (value === 'module') {
        module_collapse.addClass('show')
      }
      if (value === 'column') {
        column_collapse.addClass('show')
      }
    })
    if (checked === 'all') {
      module_collapse.removeClass('show')
      column_collapse.removeClass('show')
    }
    if (checked === 'module') {
      module_collapse.addClass('show')
    }
    if (checked === 'column') {
      column_collapse.addClass('show')
    }
  }
})()
