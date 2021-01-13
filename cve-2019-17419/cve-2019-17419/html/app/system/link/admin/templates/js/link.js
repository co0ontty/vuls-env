;(function() {
  var that = $.extend(true, {}, admin_module)
  renderTable()
  TEMPLOADFUNS[that.hash] = function() {
    renderTable(1)
    that.table.ajax.reload()
  }
  function renderTable(refresh) {
    metui.use(['table', 'alertify'], function() {
      const table = that.obj.find(`#link-table`)
      table.attr({ 'data-table-ajaxurl': table.data('ajaxurl') })
      datatable_option[`#link-table`] = {
        ajax: {
          dataSrc: function(result) {
            that.data = result.data
            let newData = []
            that.data &&
              that.data.map((val, index) => {
                let list = [
                  `<div class="custom-control custom-checkbox">
                  <input class="checkall-item custom-control-input" type="checkbox" name="id" value="${val.id}"/>
                  <label class="custom-control-label"></label>
                </div>`,
                  `${val.orderno}`,
                  `${val.link_type > 0 ? METLANG.linkType5 : METLANG.linkType4}`,
                  `${val.webname}`,
                  `${val.weburl}`,
                  `${val.show_ok > 0 ? METLANG.yes : METLANG.no}`,
                  `${val.com_ok > 0 ? METLANG.yes : METLANG.no}`,
                  `<button
                class="btn btn-primary btn-edit"
                data-index="${index}"
                data-toggle="modal"
                data-target=".link-edit-modal"
                data-modal-url="link/add/?n=link&c=link_admin&a=doGetColumnList&nocommon=1"
                data-modal-size="lg"
                data-modal-loading="1"
                data-modal-title="${METLANG.editor}"
                data-modal-tablerefresh="#link-table"
                >${METLANG.editor}</button>
                <button class="btn btn-default btn-delete ml-2" data-id="${val.id}">${METLANG.delete}</button>`
                ]
                newData.push(list)
              })
            return newData
          }
        }
      }

      that.obj.metDataTable(function() {
        that.table = datatable[`#link-table`]
        if (!refresh) {
          del()
          delAll()
          edit()
        }
      })
    })
  }
  function del() {
    $(document).on('click', `#link-table .btn-delete`, function() {
      let ids = [$(this).data('id')]
      alertify
        .okBtn(METLANG.confirm)
        .cancelBtn(METLANG.cancel)
        .confirm(METLANG.delete_information, function(ev) {
          handleDel(ids)
        })
    })
  }
  function delAll() {
    $(document).on('click', `#link-table .btn-delete-all`, function() {
      let ids = []
      const $ids = $("[name='id']:checked")
      if ($ids.length === 0) {
        alertify.error(`${METLANG.js23}`)
        return
      }
      $ids.each(function() {
        ids.push($(this).val())
      })
      alertify
        .okBtn(METLANG.confirm)
        .cancelBtn(METLANG.cancel)
        .confirm(METLANG.delete_information, function(ev) {
          handleDel(ids)
        })
    })
  }
  function handleDel(ids) {
    $.ajax({
      url: that.own_name + 'c=link_admin&a=doDelLinks',
      type: 'POST',
      dataType: 'json',
      data: {
        id: ids
      },
      success: function(result) {
        metAjaxFun({
          result: result,
          true_fun: function() {
            that.obj.find('.checkall-all').removeAttr('checked')
            that.table.ajax.reload()
          }
        })
      }
    })
  }

  function edit() {
    $(document).on('click', '.link-table .btn-edit', function(e) {
      that.activeData = that.data[e.target.getAttribute('data-index')]
    })
    M.component.modal_options['.link-edit-modal'] = {
      callback: function() {
        const modal = $('.link-edit-modal')
        setTimeout(function() {
          renderEditModal(modal)
          modal.metCommon()
          modal.find('.modal-loader').addClass('hide')
          modal.find('.modal-html').removeClass('hide')
          modal.scrollTop(0)
        }, 300)
      }
    }
    function renderEditModal(modal) {
      Object.keys(that.activeData).map(item => {
        if (item === 'link_type') {
          modal.find(`#link_type-${that.activeData[item]}`).attr('checked', 'checked')
          return
        }
        if (item === 'show_ok' || item === 'com_ok' || item === 'nofollow') {
          that.activeData[item] > 0 && modal.find(`#${item}`).attr('checked', 'checked')
          return
        }
        if (item === 'module') {
          that.activeData[item].map(val => {
            $('.module-' + val).attr('checked', 'checked')
          })
          return
        }
        const active = modal.find(`[name="${item}"]`)
        if (active.attr('type') == 'file') {
          active.attr('value', that.activeData[item])
          return
        }
        active.val(that.activeData[item])
      })
    }
  }
})()
