;(function() {
  var that = $.extend(true, {}, admin_module)
  getSystemInfo()
  renderPage()
  TEMPLOADFUNS[that.hash] = function() {
    renderPage()
    getSystemInfo()
  }
  function getSystemInfo() {
    $.ajax({
      url: that.own_name + 'c=about&a=doInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        if (!result.data) return
        const data = result.data
        Object.keys(data).map(item => {
          if (item === 'log_url') {
            $(`.${item}`).attr('href', data[item])
            return
          }
          $(`.${item}`)
            .children()
            .text(data[item])
        })
      }
    })
  }
  function renderPage() {
    $.ajax({
      url: that.own_name + 'c=about&a=doCheckUpdate',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            checkUpdate(result)
          },
          false_fun: function() {
            const div = that.obj.find('.update')
            let html = `${METLANG.latest_version}`
            div.children().html(html)
          }
        })
      }
    })
  }
  function checkUpdate(result) {
    const div = that.obj.find('.update')
    const version = (that.version = result.data.version)
    const install = (that.install = result.data.install)
    if (result.data) {
      let html = `${install ? METLANG.already_update_package : METLANG.be_updated + version}
      <button class="btn btn-update btn-primary ml-2" >${install ? METLANG.appinstall : METLANG.langexplain5}</button>`
      div.children().html(html)
      let btn = $('.btn-update')
      let modalHTML = ''
      $.ajax({
        url: that.own_name + 'c=about&a=doDownloadWarning',
        data: {
          type: install ? 'install' : 'update'
        },
        type: 'POST',
        dataType: 'json',
        success: function(result) {
          modalHTML = result.data
          btn.off().click(function() {
            let modal = $('.update-warning-modal')
            if (modal.length === 0) {
              $('body').append(
                M.component.modalFun({
                  modalTitle: METLANG.metinfoappinstallinfo4,
                  modal_class: '.update-warning-modal',
                  modalBody: `<strong style="color:red;">${modalHTML}</strong>
                  <div class="modal-footer clearfix d-block mt-2">
                      <div class="float-right">
                  <button type="button" class="btn btn-default mr-2" data-dismiss="modal">${METLANG.cancel}</button>
                  ${install ? `<button type="button" class="btn btn-success mr-2 btn-backup" >${METLANG.databackup4}</button>` : ''}
                  <button type="button" class="btn btn-primary" data-ok>${METLANG.confirm}</button>'
                  </div></div>
                  `,
                  modalFooterok: 0
                })
              )
              modal = $('.update-warning-modal')
              modal.modal()
            } else {
              modal.modal()
            }
            const btn_ok = $('.update-warning-modal [data-ok]')
            const btn_backup = $('.update-warning-modal .btn-backup')
            btn_ok.off().on('click', function(event) {
              btn_ok.attr('disabled', true)
              if (install) {
                installSystem(modal)
                return
              }
              that.piece = 0
              that.precent = 0
              let body = modal.find('.modal-body')
              modal.find('.modal-footer').addClass('hide')
              renderProgress(body, { title: '下载中，请不要操作。' })
              downloadUpdate(modal)
            })
            btn_backup.off().on('click', function(event) {
              btn_ok.attr('disabled', true)
              btn_backup.attr('disabled', true)
              backup(modal)
            })
          })
        }
      })
      return
    }
    setTimeout(() => {
      let html = `${result.msg}`
      div.children().html(html)
    }, 500)
  }
  function downloadUpdate(modal) {
    const body = modal.find('.modal-body')
    $.ajax({
      url: that.own_name + 'c=about&a=doDownloadUpdate',
      type: 'POST',
      data: {
        version: that.version,
        piece: that.piece
      },
      dataType: 'json',
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            that.precent = that.precent + Math.floor(100 / result.data.total)
            renderProgress(body, { precent: that.precent })
            if (that.piece < result.data.total - 1) {
              that.piece++
              downloadUpdate(modal)
            } else {
              setTimeout(() => {
                modal.remove()
                renderPage()
              }, 300)
            }
          },
          false_fun: function() {
            setTimeout(() => {
              modal.remove()
            }, 300)
          }
        })
      }
    })
  }
  function installSystem(modal) {
    const body = modal.find('.modal-body')
    let html = `
    <div class="p-2">
    <h4>${METLANG.installing}</h4>
    </div>
    ${M.component.loader({ class_name: 'w-100' })}
  `
    body.html(html)
    $.ajax({
      url: that.own_name + 'c=about&a=doInstall',
      type: 'POST',
      dataType: 'json',
      data: {
        version: that.version
      },
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            setTimeout(() => {
              window.location.reload()
            }, 300)
          },
          false_fun: function() {
            setTimeout(() => {
              window.location.reload()
            }, 300)
          }
        })
      }
    })
  }
  function backup(modal) {
    const body = modal.find('.modal-body')
    let html = `
    <div class="p-2">
    <h4>${METLANG.databacking}</h4>
    </div>
    ${M.component.loader({ class_name: 'w-100' })}
  `
    body.html(html)
    metui.request(
      {
        url: M.url.admin + '?n=databack&c=index&a=dopackdata'
      },
      function(result) {
        continueBack(result, modal)
      }
    )
  }
  function continueBack(result, modal) {
    if (result.status === 1) {
      installSystem(modal)
    }
    if (result.status === 2) {
      metui.request(
        {
          url: `${M.url.admin}?${result.call_back}`
        },
        function(result) {
          continueBack(result, modal)
        }
      )
    }
  }
  function renderProgress(body, params) {
    if (params.precent) {
      body
        .find('.progress-bar')
        .text(params.precent + '%')
        .css('width', `${params.precent}%`)
    } else {
      let html = `
      <div class="p-2">
      <h4>${params.title}</h4>
      <div class="progress">
      <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%">0%</div>
      </div>
      </div>
    `
      body.html(html)
    }
  }
})()
