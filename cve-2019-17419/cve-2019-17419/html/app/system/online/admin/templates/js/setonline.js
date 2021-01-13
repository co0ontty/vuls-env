;(function() {
  var that = $.extend(true, {}, admin_module)
  fetch()

  TEMPLOADFUNS[that.hash] = function() {

  }
  function fetch() {
    $.ajax({
      url: that.own_name + '&c=online&a=doGetSetup',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if (item === 'met_online_type') {
            $(`#met_online_type-${data[item]}`).attr('checked', 'checked')
            return
          }
          if (item === 'met_onlinenameok') {
            if (data[item] > 0 && $(`[name="${item}"]`).val() === '0') $(`[name="${item}"]`).click()
            return
          }
          if (item === 'met_online_skin') {
            var html = ''
            $.each(data.online_skin_options, function(index, val) {
              html += '<option value="' + val.value + '" data-view="' + val.view + '">' + val.name + '</option>'
            })
            that.obj
              .find('select[name="met_online_skin"]')
              .html(html)
              .attr({ 'data-checked': data[item] })
            return
          }
          $(`[name=${item}]`).val(data[item])
        })
        that.obj.metCommon()
        setTimeout(function(){
          that.obj.find('select[name="met_online_skin"]').change();
        },0)
      }
    })
  }
  that.obj.on('change', 'select[name="met_online_skin"]', function(event) {
    var view = $('option[value="' + $(this).val() + '"]', this).data('view')
    $(this)
      .parent()
      .find('a')
      .attr('href', view)
      .find('img')
      .attr('src', view)
  })
})()
