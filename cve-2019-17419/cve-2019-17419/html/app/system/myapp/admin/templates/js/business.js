;(function() {
  var that = $.extend(true, {}, admin_module)
  init()
  getUserInfo()
  TEMPLOADFUNS[that.hash] = function() {
    init()
    getUserInfo()
  }
  function init() {
    const row = that.obj.find('.met-myapp-list-row')
    that.obj.find('.tab-pane').removeClass('p-4')
    row.html(M.component.loader({ height: '300px', class_name: 'w-100' }))
    $.ajax({
      url: that.own_name + '&c=index&a=doAppList&type=business',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = (that.data = result.data.data)
        renderList(data)
        installApp()
        search()
      }
    })
  }
  function renderList(data) {
    const row = that.obj.find('.met-myapp-list-row')
    let html = ''
    data.length > 0
      ? data.map(item => {
          const card = `<div class="col-xl-4 col-xll-3 col" >
    <div class="media" data-no="${item.product_code}" data-m_name="${item.m_name}">
    <div class="body">
    <a href="${item.show_url}" class="link w-100" target="_blank">
    <img class="mr-3" src="${item.product_image}">
    <div class="media-body ">
      <h5 class="mt-0 mb-1">
        ${item.product_name}
      </h5>
      <p class="card-text">${item.product_desc}</p>
    </div>
    </a>
    </div>
    <ul class="actions">
    <li class="btn-install"><i class="fa fa-cloud-download"><span class="ml-2">${METLANG.appinstall}</span></i>
  </ul>
  </div>
  </div>`
          html = html + card
        })
      : (html = `<div class="text-center w-100">${METLANG.no_data}</div>`)

    row.html(html)
  }
  function installApp() {
    const btn_install = that.obj.find('.btn-install')
    btn_install.off().click(function() {
      const btn = $(this)
      const beforeHTML = btn.html()
      btn.html(`<i class="fa fa-circle-o-notch fa-spin"></i> ${METLANG.updateinstallnow}`).attr('disabled', true)
      $.ajax({
        url: that.own_name + '&c=index&a=doAction',
        type: 'POST',
        dataType: 'json',
        data: {
          m_name: btn.parents('.media').data('m_name'),
          no: btn.parents('.media').data('no'),
          handle: 'install'
        },
        success: function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              if (M.is_admin) {
                window.location.href = M.url.admin + '#/myapp'
                return
              }
              $('.pageset-nav-modal .nav-modal-item .met-headtab a[href="#/myapp"]').click()
            },
            false_fun: function() {
              btn.html(beforeHTML).attr('disabled', false)
            }
          })
        }
      })
    })
  }
  function search() {
    const btn_search = that.obj.find('.input-group-text')
    const input = that.obj.find('.form-control')
    btn_search.off().click(function() {
      const value = input.val()
      const newData = that.data.filter(item => {
        return item.product_name.indexOf(value) > -1
      })
      renderList(newData)
    })
    input.off().keypress(function(e) {
      let keycode = e.keyCode ? e.keyCode : e.which
      if (keycode == '13') {
        const value = input.val()
        const newData = that.data.filter(item => {
          return item.product_name.indexOf(value) > -1
        })
        renderList(newData)
      }
    })
  }
  function getUserInfo() {
    $.ajax({
      url: that.own_name + '&c=index&a=doUserInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (result.status) {
          const user = $('.met-myapp-right')
          const userHtml = `<div class="flex user">
            <div class="user-name">${result.data.username}</div>
            <a href="https://u.mituo.cn/#/user/login" target="_blank">${METLANG.account_Settings}</a>
            <button class="btn btn-logout">${METLANG.indexloginout}</button>
            </div>`
          user.html(userHtml)
          that.obj.find('.btn-logout').click(function() {
            $.ajax({
              url: that.own_name + '&c=index&a=doLogout',
              type: 'GET',
              dataType: 'json',
              success: function(result) {
                metAjaxFun({
                  result: result,
                  true_fun: function() {
                    getUserInfo(that)
                  }
                })
              }
            })
          })
        } else {
          const user = that.obj.find('.met-myapp-right')
          const userHtml = `<a href="#/myapp/login" onClick="setCookie('app_href_source','${that.hash}')" class="mr-2">
          <button class="btn btn-default" >
          ${METLANG.loginconfirm}
          </button>
          </a>
          <a href="https://u.mituo.cn/#/user/register" target="_blank"><button class="btn btn-success">${METLANG.registration}</button></a>`
          user.html(userHtml)
        }
      }
    })
  }
})()
