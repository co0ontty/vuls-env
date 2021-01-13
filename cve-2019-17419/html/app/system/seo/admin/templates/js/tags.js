;
(function() {
    var that = $.extend(true, {}, admin_module)
    renderTable()
    TEMPLOADFUNS[that.hash] = function() {
        that.obj
            .find('.select-groupid')
            .val('0')
        that.obj
            .find('.select-cid')
            .val('-1')
        that.obj.find('[name="keyword"]').val('')
        that.table.ajax.reload()
    }

    function renderTable(refresh) {
        metui.use(['table', 'alertify'], function() {
            const table = that.obj.find(`#tags_table`)
            table.attr({
                'data-table-ajaxurl': table.data('ajaxurl')
            })
            datatable_option[`#tags_table`] = {
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
                                    `${val.sort}`,
                                    `${val.tag_name}`,
                                    `${val.tag_pinyin}`,
                                    `${val.tag_size > 0 ? val.tag_size : METLANG.default_values}`,
                                    `${val.tag_color ? val.tag_color : METLANG.default_values}`,
                                    `${val.source}`,
                                    `${val.cid}`,
                                    `<button
                class="btn btn-primary btn-edit"
                data-toggle="modal"
                data-target=".tags-edit-modal"
                data-modal-url="tags/edit/?n=tags&c=index&a=doGetTags&id=${val.id}"
                data-modal-size="lg"
                data-modal-title="${METLANG.editor}"
                data-modal-tablerefresh="#tags_table"
                >${METLANG.editor}</button>
                  <button
                class="btn btn-default ml-2"
                ><a href="${val.url}" target="_blank">${METLANG.preview}</a></button>
                <button class="btn btn-default btn-delete ml-2" data-id="${val.id}">${METLANG.delete}</button>`
                                ]
                                newData.push(list)
                            })

                        return newData
                    }
                }
            }

            that.obj.metDataTable(function() {
                that.table = datatable[`#tags_table`]
                setTimeout(() => {
                    inputChange()
                    if (!refresh) {
                        del()
                        delAll()
                    }
                    that.obj.metCommon()
                }, 230)
            })
        })
    }

    function del() {
        $(document).on('click', `#tags_table .btn-delete`, function() {
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
        $(document).on('click', `#tags_table .btn-delete-all`, function() {
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
            url: M.url.admin + '?n=tags&c=index&a=doDelTags',
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

    function inputChange() {
        that.obj.on('change', ':text', function(e) {
            $(this)
                .parents('tr')
                .find('[name="id"]')
                .attr('checked', 'checked')
        })
        that.obj.on('change', 'status-input', function(e) {
            const price = $(this)
                .parents('td')
                .find('.price')
            $(this)
                .parents('tr')
                .find('[name="id"]')
                .attr('checked', 'checked')
            if (e.target.value > 0) {
                price.hide()
            } else {
                price.show()
            }
        })
    }
})()