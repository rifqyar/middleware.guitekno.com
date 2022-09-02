const mainComponent = $('#bSecret-component')
const addComponent = $('#add')
const editComponent = $('#edit')
const fAddComponent = $('#form-add')
const fEditComponent = $('#form-edit')

$(document).ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    
    $('.t-bankSecret').DataTable({
       processing: true,
       serverSide: true,
       ajax: `${$('meta[name="baseurl"]').attr('content')}master-data/bank-secret`,
       columns: [
                { data: 'id', name: 'id' },
                { data: 'code_bank', name: 'code_bank' },
                { data: 'bank_name', name: 'bank_name' },
                { data: 'client_id', name: 'client_id' },
                { data: 'client_secret', name: 'client_secret' },
                { data: 'username', name: 'username' },
                { data: 'password', name: 'password' },
                { data: 'action', name: 'action' },
             ]
    });

    if (sessionStorage.getItem('component-bs') == null){
        mainComponent.find('#list-data').fadeIn();
    } else {
        var component = mainComponent.children()
        var openedComponent = sessionStorage.getItem('component-bs')
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
    
                mainComponent.find(fEditComponent).find('input[name="id"]').val(data.id)
                mainComponent.find(fEditComponent).find('input[name="bank_id"].bank_id-default').val(data.code_bank)
                mainComponent.find(fEditComponent).find('input[name="client_id"]').val(data.client_id)
                mainComponent.find(fEditComponent).find('input[name="client_secret"]').val(data.client_secret)
                mainComponent.find(fEditComponent).find('input[name="username"]').val(data.username)
                mainComponent.find(fEditComponent).find('input[name="password"]').val(data.password)

                getAvailBank('edit')

            }
        } else if (openedComponent == 'add') {
            getAvailBank('add')
        }
    }

})

mainComponent.find('#btn-add').on('click', function() {
    $(this).parent().parent().fadeOut();
    mainComponent.find(addComponent).fadeIn();
    sessionStorage.setItem('component-bs', 'add')
    getAvailBank('add')
    
    mainComponent.find(addComponent).find('.form-control').each((k, v) => {
        console.log($(v))
        $(v).val('')
    })
});

function back(from, to){
    mainComponent.find('#'+from).fadeOut()
    mainComponent.find('#'+to).fadeIn()
    sessionStorage.clear();

    if (to == 'list-data'){
        $('.t-bankSecret').DataTable().ajax.reload();
    }
}

function getAvailBank(from){
    apiCall('master-data/bank-secret/get-avail', 'GET', '', () => {}, () => {}, null, (res) => {
        const selectComponent = from == 'add' ? mainComponent.find(fAddComponent).find('.bank_id-select') :  mainComponent.find(fEditComponent).find('.bank_id-select')
        var option = '<option></option>'
        selectComponent.append(option)
        
        res.data.map((val) => {
            option += `<option value="${val.bank_id}">${val.bank_id} - ${val.bank_name}<option/>` 
            // selectComponent.append(option)
        })

        selectComponent.append(option)
    }, true);
}

mainComponent.find(addComponent).find('#btn-save').on('click', function () {
    var required = mainComponent.find(fAddComponent).find('.required')
    var canInput = true

    required.removeClass('is-invalid')
    
    for(var i = 0; i < required.length; i++){
        if (required[i].value == ''){
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

    if (canInput == true){
        var formInput = mainComponent.find(fAddComponent).find('input')
        var formSelect = mainComponent.find(fAddComponent).find('select')

        for (let i = 0; i < formSelect.length; i++) {
            fillResData(formSelect[i].name, formSelect[i].value, 'bSecret_res_data')
        }
        for (let i = 0; i < formInput.length; i++) {
            fillResData(formInput[i].name, formInput[i].value, 'bSecret_res_data')
        }

        apiCall(`master-data/bank-secret/`, 'POST',
        'bSecret_res_data', () => {
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
                    heading: 'Success Add Data Bank Secret',
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

function editBankID(el, mode){
    var elemBankID = $(el).parent().parent().parent().children()
    elemBankID.each(function(k, v) {
        if (mode == 'edit'){
            if ($(v).attr('class').includes('edit')){
                $(v).css('display', '')
                $(v).find('.form-control').css('display', '')
            } else {
                $(v).css('display', 'none')
                $(v).find('.form-control').css('display', 'none')
            }
        } else {
            if ($(v).attr('class').includes('edit')){
                $(v).css('display', 'none')
                $(v).find('.form-control').css('display', 'none')
            } else {
                $(v).css('display', '')
                $(v).find('.form-control').css('display', '')
            }
        }
    })
}

function editBank(data){
    sessionStorage.setItem('dataToEdit', data);
    data = JSON.parse(window.atob(data))
    mainComponent.find('#list-data').fadeOut();
    mainComponent.find(editComponent).fadeIn();
    sessionStorage.setItem('component-bs', 'edit')

    getAvailBank('edit')

    mainComponent.find(fEditComponent).find('input[name="id"]').val(data.id)
    mainComponent.find(fEditComponent).find('input[name="bank_id"].bank_id-default').val(data.code_bank)
    mainComponent.find(fEditComponent).find('input[name="client_id"]').val(data.client_id)
    mainComponent.find(fEditComponent).find('input[name="client_secret"]').val(data.client_secret)
    mainComponent.find(fEditComponent).find('input[name="username"]').val(data.username)
    mainComponent.find(fEditComponent).find('input[name="password"]').val(data.password)
}

mainComponent.find(fEditComponent).find('#btn-save').on('click', function(){
    var required = mainComponent.find(fEditComponent).find('.required')
    var canInput = true

    required.removeClass('is-invalid')
    
    for(var i = 0; i < required.length; i++){
        if($(required[i]).css('display') != 'none'){
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
    } 
    if (canInput == true){
        var form = mainComponent.find(fEditComponent).find('.form-control')
        for (let i = 0; i < form.length; i++) {
            if ($(form[i]).css('display') != 'none'){
                fillResData(form[i].name, form[i].value, 'bSecret_res_data')
            }
        }

        apiCall(`master-data/bank-secret/`, 'PUT',
        'bSecret_res_data', () => {
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

function deleteBank(data){
    data = JSON.parse(window.atob(data))
    swal({
        title: 'Are you sure want to delete this data?',
        text: 'Deleted data cannot be recovered',
        buttons: true
    }).then((confirm) => {
        if(confirm == true){
            processDelete(data.id, 0, (res) => {
                console.log(res)
                if (res.count != 0 || res.count != '0'){
                    swal({
                        title: 'Warning!!',
                        text: 'Bank Secret you want to delete is used in Another data, deleting this data will delete another data',
                        icon: 'info',
                        buttons: true
                    }).then((next) => {
                        if (next == true){
                            processDelete(data.id, 1, (res) => {
                                $.toast({
                                    heading: 'Success Delete Bank Data',
                                    icon: 'success',
                                    position: 'top-right'
                                })
                                swal.close()
                                sessionStorage.clear();
                                $('.t-bankSecret').DataTable().ajax.reload();
                            })
                        }
                    })
                } else {
                    processDelete(data.id, 1, (res) => {
                        $.toast({
                            heading: 'Success Delete Bank Data',
                            icon: 'success',
                            position: 'top-right'
                        })
                        swal.close()
                        sessionStorage.clear();
                        $('.t-bankSecret').DataTable().ajax.reload();
                    })
                }
            })
        }
    })

    function processDelete(id, isChecked, callback){
        apiCall(`master-data/bank-secret/${id}/${isChecked}/delete`, 'GET', '', 
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
                if (res.status.code == 200){
                    callback(res)
                }
            }, true)
    }
}