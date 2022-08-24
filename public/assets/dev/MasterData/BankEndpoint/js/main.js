const mainComponent = $('#bEndpoint-component')
const addComponent = $('#add')
const editComponent = $('#edit')
const fAddComponent = $('#form-add')
const fEditComponent = $('#form-edit')

$(document).ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    
    $('.t-bankEndpoint').DataTable({
       processing: true,
       serverSide: true,
       ajax: `${$('meta[name="baseurl"]').attr('content')}master-data/bank-endpoint`,
       columns: [
            { data: 'dbs_id', name: 'dbs_id' },
            { data: 'dbe_endpoint', name: 'dbe_endpoint' },
            { data: 'code_bank', name: 'code_bank' },
            { data: 'bank_name', name: 'bank_name' },
            { data: 'ret_id', name: 'ret_id' },
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action' },
        ]
    });

    if (sessionStorage.getItem('component-be') == null){
        mainComponent.find('#list-data').fadeIn();
    } else {
        var component = mainComponent.children()
        var openedComponent = sessionStorage.getItem('component-be')
        for(var i = 0; i < component.length; i++){
            if (component[i].id == openedComponent){
                mainComponent.find(`#${openedComponent}`).fadeIn();
            } else {
                mainComponent.find(`#${component[i].id }`).fadeOut();
            }
        }

        if(openedComponent == 'edit'){
            if(sessionStorage.getItem('dataToEdit')){
                var data = sessionStorage.getItem('dataToEdit')
                data = JSON.parse(window.atob(data))
                mainComponent.find(fEditComponent).find('input[name="bank_secret"]').val(data.dbs_id)
                mainComponent.find(fEditComponent).find('input[name="endpoint"]').val(data.dbe_endpoint)
                mainComponent.find(fEditComponent).find('input[name="endpoint_type"]').val(data.ret_id)
            }
        } else if (openedComponent == 'add') {
            getBankSecret('add')
            getEndpointType('add')
        }
    }

})

mainComponent.find('#btn-add').on('click', function() {
    $(this).parent().parent().fadeOut();
    mainComponent.find(addComponent).fadeIn();
    sessionStorage.setItem('component-be', 'add')
    getBankSecret('add')
    getEndpointType('add')
    
    mainComponent.find(addComponent).find('.form-control').each((k, v) => {
        $(v).val('')
    })
});

function back(from, to){
    mainComponent.find('#'+from).fadeOut()
    mainComponent.find('#'+to).fadeIn()
    sessionStorage.clear();

    if (to == 'list-data'){
        $('.t-bankEndpoint').DataTable().ajax.reload();
    }
}

function getBankSecret(from){
    apiCall('master-data/bank-endpoint/get-banksecret', 'GET', '', () => {}, () => {}, null, (res) => {
        const selectComponent = from == 'add' ? mainComponent.find(fAddComponent).find('.bank_secret-select') :  mainComponent.find(fEditComponent).find('.bank_secret-select')
        var option = '<option></option>'
        res.data.map((val) => {
            option += `<option value="${val.id}">${val.client_id}<option/>` 
        })
        selectComponent.append(option)
    }, true);
}

function getEndpointType(from){
    apiCall('master-data/bank-endpoint/get-endpoint', 'GET', '', () => {}, () => {}, null, (res) => {
        const selectComponent = from == 'add' ? mainComponent.find(fAddComponent).find('.endpoint_type-select') :  mainComponent.find(fEditComponent).find('.endpoint_type-select')
        var option = '<option></option>'
        res.data.map((val) => {
            option += `<option value="${val.id}">${val.name}<option/>` 
        })

        selectComponent.append(option)
    }, true);
}

mainComponent.find(addComponent).find('#btn-save').on('click', function () {
    var required = mainComponent.find(fAddComponent).find('.required')
    var canInput = true
    var form = mainComponent.find(fAddComponent).find('.form-control')

    required.removeClass('is-invalid')
    
    for(var i = 0; i < required.length; i++){
        if (required[i].value == ''){
            canInput = false
            mainComponent.find(fAddComponent).find(`input[name="${required[i].name}"]`).addClass('is-invalid')
            mainComponent.find(fAddComponent).find(`select[name="${required[i].name}"]`).addClass('is-invalid')
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

    if (canInput == true){
        for (let i = 0; i < form.length; i++) {
            fillResData(form[i].name, form[i].value, 'bEndpoint_res_data')
        }

        apiCall(`master-data/bank-endpoint/`, 'POST',
        'bEndpoint_res_data', () => {
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
        },() => {},
        {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
        (res) => {
            if (res.status.code == 200){
                $.toast({
                    heading: 'Success Add Data Bank Endpoint',
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

function editBankEndpoint(data){
    sessionStorage.setItem('dataToEdit', data);
    data = JSON.parse(window.atob(data))
    mainComponent.find('#list-data').fadeOut();
    mainComponent.find(editComponent).fadeIn();
    sessionStorage.setItem('component-be', 'edit')

    // getBankSecret('edit')
    // getEndpointType('edit')

    mainComponent.find(fEditComponent).find('input[name="bank_secret"]').val(data.dbs_id)
    mainComponent.find(fEditComponent).find('input[name="endpoint"]').val(data.dbe_endpoint)
    mainComponent.find(fEditComponent).find('input[name="endpoint_type"]').val(data.ret_id)
}

mainComponent.find(fEditComponent).find('#btn-save').on('click', function(){
    var required = mainComponent.find(fEditComponent).find('.required')
    var canInput = true

    required.removeClass('is-invalid')
    
    for(var i = 0; i < required.length; i++){
        if (required[i].value == ''){
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
    if (canInput == true){
        var form = mainComponent.find(fEditComponent).find('.form-control')
        for (let i = 0; i < form.length; i++) {
            fillResData(form[i].name, form[i].value, 'bEndpoint_res_data')
        }

        apiCall(`master-data/bank-endpoint/`, 'PUT',
        'bEndpoint_res_data', () => {
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
        },() => {},
        {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")},
        (res) => {
            if (res.status.code == 200){
                $.toast({
                    heading: 'Success Edit Data Bank Secret',
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

function deleteBankEndpoint(data){
    data = JSON.parse(window.atob(data))
    swal({
        title: 'Are you sure want to delete this data?',
        text: 'Deleted data cannot be recovered',
        buttons: true
    }).then((confirm) => {
        if(confirm == true){
            apiCall(`master-data/bank-endpoint/${data.dbs_id}/delete`, 'GET', '', 
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
                if (res.status.code == 200){
                    $.toast({
                        heading: 'Success Delete Bank Data',
                        icon: 'success',
                        position: 'top-right'
                    })
                    swal.close()
                    sessionStorage.clear();
                    $('.t-bankEndpoint').DataTable().ajax.reload();
                }
            }, true)
        }
    })
}