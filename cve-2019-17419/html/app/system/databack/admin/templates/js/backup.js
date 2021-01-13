;(function() {
  var that = $.extend(true, {}, admin_module)
  backData()
  backUpload()
  backSite()
  TEMPLOADFUNS[that.hash] = function() {}

  function backData() {
    that.obj
      .find('.btn-backdata')
      .off()
      .click(function() {
        const btn = $(this)
        btn.append(`<i class="fa fa-spinner fa-spin ml-2"></i>`).attr('disabled', true)
        metui.request(
          {
            url: that.own_name + '&c=index&a=dopackdata'
          },
          function(result) {
            metui.use('alertify', function() {
              if (result.status !== 403) {
                continueBack(result, btn)
              } else {
                alertify.error(result.msg)
                btn.find('.fa').remove()
                btn.removeAttr('disabled')
              }
            })
          }
        )
      })
  }
  function backUpload() {
    that.obj
      .find('.btn-backupload')
      .off()
      .click(function() {
        const btn = $(this)
        btn.append(`<i class="fa fa-spinner fa-spin ml-2"></i>`).attr('disabled', true)
        metui.request(
          {
            url: that.own_name + '&c=index&a=dopackupload'
          },
          function(result) {
            metui.use('alertify', function() {
              if (result.status !== 403) {
                continueBack(result, btn)
              } else {
                alertify.error(result.msg)
                btn.find('.fa').remove()
                btn.removeAttr('disabled')
              }
            })
          }
        )
      })
  }
  function backSite() {
    that.obj.find('.btn-backsite').click(function() {
      const btn = $(this)
      btn.append(`<i class="fa fa-spinner fa-spin ml-2"></i>`).attr('disabled', true)
      metui.request(
        {
          url: that.own_name + '&c=index&a=doallfile'
        },
        function(result) {
          metui.use('alertify', function() {
            if (result.status !== 403) {
              continueBack(result, btn)
            } else {
              alertify.error(result.msg)
              btn.find('.fa').remove()
              btn.removeAttr('disabled')
            }
          })
        }
      )
    })
  }
  function continueBack(result, btn) {
    if (result.status === 2) {
      metui.request(
        {
          url: `${M.url.admin}?${result.call_back}`
        },
        function(result) {
          continueBack(result, btn)
        }
      )
    }
    if (result.status === 1) {
      btn.find('.fa').remove()
      btn.removeAttr('disabled')
      setTimeout(() => {
        M.is_admin ? (window.location.href = `${M.url.admin}#/databack/recovery`) : that.obj.find('.met-headtab a:eq(1)').click()
      }, 230)
    }
  }
})()
