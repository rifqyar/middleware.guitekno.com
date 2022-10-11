const mainComponent = $('#apiStatus-component')
const addComponent = $('#add')
const editComponent = $('#edit')
const fAddComponent = $('#form-add')
const fEditComponent = $('#form-edit')
$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('.t-refapiStatus').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${$('meta[name="baseurl"]').attr('content')}master-data/api-status`,
        columns: [
            { data: 'ras_id', name: 'ras_id' },
            { data: 'ras_message', name: 'ras_message' },
            { data: 'ras_description', name: 'ras_description' },
            { data: 'action', name: 'action' },
        ]
    });
    
    if (!sessionStorage.getItem('component-ras')) {
        mainComponent.find('#list-data').fadeIn();
    } else {
        var component = mainComponent.children()
        var openedComponent = sessionStorage.getItem('component-ras')
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

                mainComponent.find(fEditComponent).find('input[name="ras_id"]').val(data.ras_id)
                mainComponent.find(fEditComponent).find('input[name="ras_message"]').val(data.ras_message)
                mainComponent.find(fEditComponent).find('input[name="ras_description"]').val(data.ras_description)
            }
        }
    }

})

mainComponent.find('#btn-add').on('click', function () {
    $(this).parent().parent().fadeOut();
    mainComponent.find(addComponent).fadeIn();
    sessionStorage.setItem('component-ras', 'add')

    mainComponent.find(addComponent).find('.form-control').each((k, v) => {
        $(v).val('')
    })
});

function back(from, to) {
    mainComponent.find('#' + from).fadeOut()
    mainComponent.find('#' + to).fadeIn()
    sessionStorage.clear();

    if (to == 'list-data') {
        $('.t-refapiStatus').DataTable().ajax.reload();
    }
}

function getApiStatus(el){
    const val = $(el).val()
    mainComponent.find(addComponent).find('#btn-save').addClass('disabled').prop('disabled', true).css('cursor', 'not-allowed')

    if (val.length == 3 && !val.includes('_')) {
        apiCall(`master-data/api-status/get/${val}`, 'GET', '', () => { }, () => { }, null, (res) => {
            if (res.status.code = 200) {
                var data = res.data
                if (data > 0) {
                    mainComponent.find(addComponent).find('#maxCharRAS').fadeOut()
                    mainComponent.find(addComponent).find('#RasIDUsed').fadeIn()
                    mainComponent.find(addComponent).find('input[name="bank_id"]').addClass('is-invalid')
                    mainComponent.find(addComponent).find('#btn-save').addClass('disabled').prop('disabled', true).css('cursor', 'not-allowed')
                } else {
                    mainComponent.find(addComponent).find('#maxCharRAS').fadeIn()
                    mainComponent.find(addComponent).find('#RasIDUsed').fadeOut()
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
            var form_name = required[i].name.replace('_', ' ').replace('ras', 'Api Status')
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
            fillResData(form[i].name, form[i].value, 'apiStatus_res_data')
        }

        apiCall(`master-data/api-status`, 'POST',
            'apiStatus_res_data', () => {
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
                        heading: 'Success Add Api Status Data',
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

function editApiStatus(data) {
    sessionStorage.setItem('dataToEdit', data);
    data = JSON.parse(window.atob(data))
    mainComponent.find('#list-data').fadeOut();
    mainComponent.find(editComponent).fadeIn();
    sessionStorage.setItem('component-ras', 'edit')

    mainComponent.find(fEditComponent).find('input[name="ras_id"]').val(data.ras_id)
    mainComponent.find(fEditComponent).find('input[name="ras_message"]').val(data.ras_message)
    mainComponent.find(fEditComponent).find('input[name="ras_description"]').val(data.ras_description)
}

mainComponent.find(fEditComponent).find('#btn-save').on('click', function () {
    var required = mainComponent.find(fEditComponent).find('.required')
    var canInput = true

    required.removeClass('is-invalid')

    for (var i = 0; i < required.length; i++) {
        if (required[i].value == '') {
            canInput = false
            mainComponent.find(fEditComponent).find(`input[name="${required[i].name}"]`).addClass('is-invalid')
            var form_name = required[i].name.replace('_', ' ').replace('ras', 'Api Status')
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
            fillResData(form[i].name, form[i].value, 'apiStatus_res_data')
        }

        apiCall(`master-data/api-status`, 'PUT',
            'apiStatus_res_data', () => {
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
                        heading: 'Success Edit Api Status Data',
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

function deleteApiStatus(data) {
    data = JSON.parse(window.atob(data))
    const id = data.ras_id
    swal({
        title: 'Are you sure want to delete this data?',
        text: 'Deleted data cannot be recovered',
        buttons: true
    }).then((confirm) => {
        if (confirm == true) {
            apiCall(`master-data/api-status/${id}/delete`, 'GET', '',
                () => {
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
                        $.toast({
                            heading: 'Success Delete Api Status Data',
                            icon: 'success',
                            position: 'top-right'
                        })
                        swal.close()
                        sessionStorage.clear();
                        $('.t-refapiStatus').DataTable().ajax.reload();
                    }
                }, true)
        }
    })
}
