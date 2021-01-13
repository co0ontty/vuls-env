;(function() {
  var that = $.extend(true, {}, admin_module)

  renderList(that)
  getUserInfo(that)
  TEMPLOADFUNS[that.hash] = function() {
    renderList(that)
    getUserInfo(that)
  }
  function renderList(that) {
    const loginTips = `<div class="tips">
    <h3>${METLANG.please_login}</h3>
    <div class="mt-2"><a href="#/myapp/login" onClick="setCookie('app_href_source','${that.hash}')" class="btn btn-primary">${METLANG.loginconfirm}</a></div>
    </div>`
    const row = $('.met-myapp-list-row')
    const list = that.obj.find('.met-myapp-list')
    const detail = that.obj.find('.app-detail')
    that.obj.find('.tab-pane').removeClass('p-4')
    row.html(M.component.loader({ height: '300px', class_name: 'w-100' }))
    $.ajax({
      url: that.own_name + '&c=index&a=doindex',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (!result.data) {
          row.html(loginTips)
          return
        }
        let data = result.data
        let html = ''
        data.map(item => {
          const card = `<div class="col-xl-4 col-xll-3 col" >
        <div class="media ${item.url ? 'install' : ''}" data-no="${item.no}" data-m_name="${item.m_name}" data-new_ver="${item.new_ver ? item.new_ver : ''}">
        <div class="body">
        <a href="${item.url ? item.url : 'javascript:;'}" ${parseInt(item.target) ? 'target="_blank"' : ''} class="link w-100" data-version="${item.version ? item.version : ''}">
        <img class="mr-3" src="${item.icon}">
        <div class="media-body ">
          <h5 class="mt-0 mb-1">
         ${item.appname}
          </h5>
          <p class="card-text">${item.info}</p>
        </div>
        </a>
        </div>
        ${
          !item.install
            ? `<ul class="actions">
            <li class="btn-install"><i class="fa fa-cloud-download"><span class="ml-2">${METLANG.appinstall}</span></i>
            </li>
          </ul>`
            : `<ul class="actions">
            ${item.new_ver ? `<li class="text-blue"><i class="fa fa-arrow-up"><span class="ml-2">${METLANG.appupgrade}</span></i></li>` : ``}
            ${item.system ? `<li class="">${METLANG.system_plugin_uninstall}</li>` : `<li class=""><i class="fa fa-trash"><span class="ml-2">${METLANG.dlapptips6}</span></i></li>`}
          </ul>`
        }
      </div>
      </div>`
          html = html + card
        })
        row.html(html)
        list.show()
        detail.hide()
        row.off().on('click','.link:not([target])',function() {
          const url = $(this).attr('href')
          const version = $(this).data('version')
          if (url && url !== 'javascript:;') {
            if (version) {
              M.is_admin?(window.location.href =url):$('.btn-pageset-common-page').attr({'data-url':url.replace(M.url.admin+'#/','')}).trigger('clicks');
            } else {
              detail.html(`<iframe src="${url}" ></iframe>`)
            }
            list.hide()
            detail.show()
          } else {
            metui.use(['alertify'], function() {
              alertify.error(METLANG.install_first)
            })
          }
          return false
        })
        installApp(that)
        deleteApp(that)
        updateApp(that)
      }
    })
  }
  function installApp(that) {
    that.obj.find('.btn-install').click(function() {
      $(this)
        .html(`<i class="fa fa-circle-o-notch fa-spin"></i> ${METLANG.updateinstallnow}`)
        .attr('disabled', true)

      $.ajax({
        url: that.own_name + '&c=index&a=doAction',
        type: 'POST',
        dataType: 'json',
        data: {
          m_name: $(this)
            .parents('.media')
            .data('m_name'),
          no: $(this)
            .parents('.media')
            .data('no'),
          handle: 'install'
        },
        success: function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              renderList(that)
            },
            false_fun: function() {
              renderList(that)
            }
          })
        }
      })
    })
  }
  function updateApp(that) {
    that.obj.find('.fa-arrow-up').click(function() {
      $(this).parents('.media').append(`<div class="overlay">
      <button class="btn btn-default btn-install w-100">${METLANG.upgrade}</button>
    </div>`)
      $.ajax({
        url: that.own_name + '&c=index&a=doAction',
        type: 'POST',
        dataType: 'json',
        data: {
          m_name: $(this)
            .parents('.media')
            .data('m_name'),
          no: $(this)
            .parents('.media')
            .data('no'),
          handle: 'install'
        },
        success: function(result) {
          metAjaxFun({
            result: result,
            true_fun: function() {
              renderList(that)
            },
            false_fun: function() {
              renderList(that)
            }
          })
        }
      })
    })
  }
  function deleteApp(that) {
    that.obj.find('.fa-trash').click(function() {
      const btn = $(this)
      metui.use('alertify', function() {
        alertify
          .okBtn(METLANG.confirm)
          .cancelBtn(METLANG.cancel)
          .confirm(METLANG.delete_information, function(ev) {
            $.ajax({
              url: that.own_name + 'c=index&a=doAction',
              data: {
                no: btn.parents('.media').data('no'),
                handle: 'uninstall'
              },
              dataType: 'json',
              success: function(result) {
                metAjaxFun({
                  result: result,
                  true_fun: function() {
                    renderList(that)
                  },
                  false_fun: function() {
                    renderList(that)
                  }
                })
              },
              error: function(result) {
                renderList(that)
              }
            })
          })
      })
    })
  }
  function getUserInfo(that) {
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
            <button class="btn btn-logout btn-default">${METLANG.indexloginout}</button>
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
                    window.location.reload()
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
