;(function() {
  var that = $.extend(true, {}, admin_module)
  renderList(that)
  TEMPLOADFUNS[that.hash] = function() {
    renderList(that)
  }
  function renderList(that) {
    const list = that.obj.find('.met-partner .list')
    that.obj.find('.tab-pane').removeClass('p-4')
    list.html(M.component.loader({ height: '300px', class_name: 'w-100' }))
    $.ajax({
      url: that.own_name + '&c=index&a=doindex',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data.data
        let html = ''
        list.find('.msg').html()
        data.map(item => {
          const card = `<div class="col-xl-4 col-xll-3 col" >
        <div class="media" >
        <div class="body">
        <img class="mr-3" src="${item.logo}">
        <div class="media-body ">
          <h5 class="mt-0 mb-1">
          <a href="${item.homepage ? item.homepage : ''}" class="link d-block" target="_blank">${item.user_name}</a>
          </h5>
          <p class="card-text">${item.service}</p>
        </div>
        </div>

      </div>
      </div>`
          html = html + card
        })
        list.html(html)

        that.obj.find('.msg').html(result.msg)
      }
    })
  }
})()
