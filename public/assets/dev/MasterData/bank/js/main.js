const mainComponent = $('#bank-component')
const addComponent = $('#add')
const editComponent = $('#edit')
const fAddComponent = $('#form-add')
const fEditComponent = $('#form-edit')

$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('.t-refBank').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${$('meta[name="baseurl"]').attr('content')}master-data/bank`,
        columns: [
            { data: 'bank_id', name: 'bank_id' },
            { data: 'bank_name', name: 'bank_name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ]
    });

    if (!sessionStorage.getItem('component-rb')) {
        mainComponent.find('#list-data').fadeIn();
    } else {
        var component = mainComponent.children()
        var openedComponent = sessionStorage.getItem('component-rb')
        for (var i = 0; i < component.length; i++) {
            if (component[i].id == openedComponent) {
                mainComponent.find(`#${openedComponent}`).fadeIn();
            } else {
                mainComponent.find(`#${component[i].id}`).fadeOut();
            }
        }

        if (openedComponent == 'edit') {
            if (sessionStorage.getItem('dataToEdit')) {
                var data = sessionStorage.getItem('dataToEdit')
                data = JSON.parse(window.atob(data))

                mainComponent.find(fEditComponent).find('input[name="bank_id"]').val(data.bank_id)
                mainComponent.find(fEditComponent).find('input[name="bank_name"]').val(data.bank_name)
                mainComponent.find(fEditComponent).find(`select[name="bank_status"] option[value="${data.rrs_id}"]`).attr('selected', 'selected')
            }
        }
    }

})

mainComponent.find('#btn-add').on('click', function () {
    $(this).parent().parent().fadeOut();
    mainComponent.find(addComponent).fadeIn();
    sessionStorage.setItem('component-rb', 'add')

    mainComponent.find(addComponent).find('.form-control').each((k, v) => {
        $(v).val('')
    })
});

function back(from, to) {
    mainComponent.find('#' + from).fadeOut()
    mainComponent.find('#' + to).fadeIn()
    sessionStorage.clear();

    if (to == 'list-data') {
        $('.t-refBank').DataTable().ajax.reload();
    }
}

function getRefBank(el) {
    var text = $(el).val()
    mainComponent.find(addComponent).find('#btn-save').addClass('disabled').prop('disabled', true).css('cursor', 'not-allowed')
    if (text.length == 3 && !text.includes('_')) {
        apiCall(`master-data/bank/get/${text}`, 'GET', '', () => { }, () => { }, null, (res) => {
            if (res.status.code = 200) {
                var data = res.data[0].totaldata
                if (data > 0) {
                    mainComponent.find(addComponent).find('#maxCharBank').fadeOut()
                    mainComponent.find(addComponent).find('#bankIDUsed').fadeIn()
                    mainComponent.find(addComponent).find('input[name="bank_id"]').addClass('is-invalid')
                    mainComponent.find(addComponent).find('#btn-save').addClass('disabled').prop('disabled', true).css('cursor', 'not-allowed')
                } else {
                    mainComponent.find(addComponent).find('#maxCharBank').fadeIn()
                    mainComponent.find(addComponent).find('#bankIDUsed').fadeOut()
                    mainComponent.find(addComponent).find('input[name="bank_id"]').removeClass('is-invalid')
                    mainComponent.find(addComponent).find('#btn-save').removeClass('disabled').prop('disabled', false).css('cursor', 'pointer')
                }
            }
        }, false)
    }
}

mainComponent.find(addComponent).find('#btn-save').on('click', function () {
    var required = mainComponent.find(fAddComponent).find('.required')
    var canInput = true

    required.removeClass('is-invalid')

    for (var i = 0; i < required.length; i++) {
        if (required[i].value == '') {
            canInput = false
            mainComponent.find(fAddComponent).find(`input[name="${required[i].name}"]`).addClass('is-invalid')
            var form_name = required[i].name.replace('_', ' ').toUpperCase()
            $.toast({
                heading: 'Warning',
                text: `Form ${form_name} is Required`,
                icon: 'warning',
                loader: true,
                loaderBg: '#9EC600',
                position: 'top-right',
            })
        }
    }

    if (canInput == true) {
        var form = mainComponent.find(fAddComponent).find('.form-control')
        for (let i = 0; i < form.length; i++) {
            fillResData(form[i].name, form[i].value, 'bank_res_data')
        }

        apiCall(`master-data/bank`, 'POST',
            'bank_res_data', () => {
                swal({
                    title: 'Saving Data...',
                    content: {
                        element: "i",
                        attributes: {
                            className: "fas fa-spinner fa-spin text-large",
                        },
                    },
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            }, () => { },
            { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            (res) => {
                if (res.status.code == 200) {
                    $.toast({
                        heading: 'Success Add Bank Data',
                        icon: 'success',
                        position: 'top-right'
                    })
                    swal.close()

                    mainComponent.find(addComponent).find('.btn-back').trigger('click')
                    sessionStorage.clear();
                }
            }, true)
    }
});

function editBank(data) {
    sessionStorage.setItem('dataToEdit', data);
    data = JSON.parse(window.atob(data))
    mainComponent.find('#list-data').fadeOut();
    mainComponent.find(editComponent).fadeIn();
    sessionStorage.setItem('component-rb', 'edit')

    mainComponent.find(fEditComponent).find('input[name="bank_id"]').val(data.bank_id)
    mainComponent.find(fEditComponent).find('input[name="bank_name"]').val(data.bank_name)
    mainComponent.find(fEditComponent).find(`select[name="bank_status"] option[value="${data.rrs_id}"]`).attr('selected', 'selected')
}

mainComponent.find(fEditComponent).find('#btn-save').on('click', function () {
    var required = mainComponent.find(fEditComponent).find('.required')
    var canInput = true

    required.removeClass('is-invalid')

    for (var i = 0; i < required.length; i++) {
        if (required[i].value == '') {
            canInput = false
            mainComponent.find(fEditComponent).find(`input[name="${required[i].name}"]`).addClass('is-invalid')
            var form_name = required[i].name.replace('_', ' ').toUpperCase()
            $.toast({
                heading: 'Warning',
                text: `Form ${form_name} is Required`,
                icon: 'warning',
                loader: true,
                loaderBg: '#9EC600',
                position: 'top-right',
            })
        }
    }

    if (canInput == true) {
        var form = mainComponent.find(fEditComponent).find('.form-control')
        for (let i = 0; i < form.length; i++) {
            fillResData(form[i].name, form[i].value, 'bank_res_data')
        }

        apiCall(`master-data/bank`, 'PUT',
            'bank_res_data', () => {
                swal({
                    title: 'Updating Data...',
                    content: {
                        element: "i",
                        attributes: {
                            className: "fas fa-spinner fa-spin text-large",
                        },
                    },
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            }, () => { },
            { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            (res) => {
                if (res.status.code == 200) {
                    $.toast({
                        heading: 'Success Edit Bank Data',
                        icon: 'success',
                        position: 'top-right'
                    })
                    swal.close()

                    mainComponent.find(editComponent).find('.btn-back').trigger('click')
                    sessionStorage.clear();
                }
            }, true)
    }
})

function deleteBank(data) {
    data = JSON.parse(window.atob(data))

    swal({
        title: 'Are you sure want to delete this data?',
        text: 'Deleted data cannot be recovered',
        buttons: true
    }).then((confirm) => {
        if (confirm == true) {
            processDelete(data.bank_id, 0, (res) => {
                if (res.count != 0 || res.count != '0') {
                    swal({
                        title: 'Warning!!',
                        text: 'Code Bank you want to delete is used in Another data, deleting this data will delete another data',
                        icon: 'info',
                        buttons: true
                    }).then((next) => {
                        if (next == true) {
                            processDelete(data.bank_id, 1, (res) => {
                                $.toast({
                                    heading: 'Success Delete Bank Data',
                                    icon: 'success',
                                    position: 'top-right'
                                })
                                swal.close()
                                sessionStorage.clear();
                                $('.t-refBank').DataTable().ajax.reload();
                            })
                        }
                    })
                } else {
                    processDelete(data.bank_id, 1, (res) => {
                        $.toast({
                            heading: 'Success Delete Bank Data',
                            icon: 'success',
                            position: 'top-right'
                        })
                        swal.close()
                        sessionStorage.clear();
                        $('.t-refBank').DataTable().ajax.reload();
                    })
                }
            })
        }
    })

    function processDelete(id, isChecked, callback) {
        apiCall(`master-data/bank/${id}/${isChecked}/delete`, 'GET', '',
            isChecked == 0 ? () => {
                swal({
                    title: 'Checking Data...',
                    content: {
                        element: "i",
                        attributes: {
                            className: "fas fa-spinner fa-spin text-large",
                        },
                    },
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            } : () => {
                swal({
                    title: 'Deleting Data...',
                    content: {
                        element: "i",
                        attributes: {
                            className: "fas fa-spinner fa-spin text-large",
                        },
                    },
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });
            }, null, null,
            (res) => {
                if (res.status.code == 200) {
                    callback(res)
                }
            }, true)
    }
}
