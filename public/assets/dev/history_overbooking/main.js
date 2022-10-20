    const mainComponent = $('#overbooking-component')

$(document).ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    var tx_type = localStorage.getItem('tx-type') == 'Gaji' ? 'LS|GAJI' : 'LS|NONGAJI' 
    var filter = localStorage.getItem('tx-type') ? `tbk_type = '${tx_type}'` : ''

    filter = window.btoa(filter)
    showData(filter)
    
    localStorage.removeItem('tx-type')
})

function showData(filter = ''){
    mainComponent.find('#form-filter').fadeOut()

    if(mainComponent.find('#list-data').css('display') == 'none'){
        mainComponent.find('#list-data').fadeIn()
    }

    if(mainComponent.find('#form-filter').css('display') != 'none'){
        mainComponent.find('#form-filter').fadeOut()
        mainComponent.find('#filter').find('#setFilter').fadeOut()
    } 

    if(filter == ''){
        const url = `${$('meta[name="baseurl"]').attr('content')}history-overbooking`
        $('.t-overbooking').DataTable().destroy();
        getData(url)
    } else if (filter != ''){
        const url = `${$('meta[name="baseurl"]').attr('content')}history-overbooking?filter=${filter}`
        $('.t-overbooking').DataTable().destroy();
        getData(url)
    }

    function getData(url){
        $('.t-overbooking').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [
                // { data: 'action', name: 'action' },
                { data: 'status', name: 'status' },
                { data: 'tbk_partnerid', name: 'tbk_partnerid' },
                { data: 'sender_bank_name', name: 'sender_bank_name' },
                { data: 'tbk_sender_account', name: 'tbk_sender_account' },
                { data: 'sender_amount', name: 'sender_amount'},
                { data: 'tbk_notes', name: 'tbk_notes' },
                { data: 'recipient_bank_name', name: 'recipient_bank_name' },
                { data: 'tbk_recipient_account', name: 'tbk_recipient_account' },
                { data: 'recipient_amount', name: 'recipient_amount'},
                { data: 'tbk_execution_time', name: 'tbk_execution_time' },
                { data: 'tbk_sp2d_desc', name: 'tbk_sp2d_desc' },
                { data: 'status_message', name: 'status_message' }
            ],
            columnDefs: [
                { className: "text-center align-middle", targets: "_all" },
                {
                    searchable: false,
                    orderable: false,
                    targets: 0,
                },
            ],
            order: [[9, 'desc']],
            createdRow: function(row, data, dataIndex){
                if (data.status_cutoff == 'true'){
                    $(row).addClass('cutoff');
                }
            }
        });
    }
}

function addFilter(type){
    mainComponent.find('#form-filter').fadeIn()
    mainComponent.find('#filter').find('#setFilter').fadeIn()
    
    if (type == 'add'){
        apiCall('history-overbooking/render-filter', '', 'GET', () => {
            swal({
                title: 'Loading...',
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
        }, null, () => {}, (res) => {
            swal.close()
            mainComponent.find('#form-filter').append(res.html)
    
            let formContainer = mainComponent.find('#form-filter').find('.form-container')
            let filterLength = formContainer.length
    
            if (filterLength > 1) {
                for (let i = 1; i < filterLength; i++) {
                    $(formContainer[i]).find('.remove-filter').fadeIn()
                    $(formContainer[i]).find('.separator').fadeIn()
                }
            }
        }, true)
    } else {
        let formContainer = mainComponent.find('#form-filter').find('.form-container')
        let filterLength = formContainer.length
        if(filterLength == 0){
            addFilter('add')
        }
    }
}

function removeFilter(el){
    swal({
        title: 'Are you sure want to remove filter?',
        buttons: true
    }).then((confirm) => {
        if(confirm){
            $(el).parent().parent().remove()
        }
    })
}

function getValueColumn(el){
    const selectComponent = $(el).parentsUntil('.form-container').parent().find('.select-value')
    if ($(el).val() != ''){
        var column = window.btoa($(el).val())
        let url = `history-overbooking/column-data/${column}`
        apiCall(url, 'GET', '',null, null, () => {}, (res) => {
            swal.close()
            column = column.toLowerCase()
            var option = '<option><option>'
            $.each(res.data, (k, v) => {
                option += `<option value="${Object.values(v)[0]}">${Object.values(v)[0]}</option>`
            })
    
            selectComponent.html(option)
        }, true)
    } else {
        selectComponent.html('<option></option>')
    }
}

function setFilter(){
    const formContainer = mainComponent.find("#form-filter").find('.form-container')
    var required = mainComponent.find(formContainer).find('.required')
    var canInput = true

    required.removeClass('is-invalid')
    
    for(var i = 0; i < required.length; i++){
        if (required[i].value == ''){
            canInput = false
            mainComponent.find(formContainer).find(`input[name="${required[i].name}"]`).addClass('is-invalid')
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

    if (required){
        var filter = ''
        formContainer.find('.form-control').each((k, v) => {
            if ($(v).css('display') != 'none'){
                filter += $(v).attr('name') != 'value' ? `${$(v).val()} ` : `'${$(v).val()}' `
            }
        })

        filter = window.btoa(filter)
        showData(filter)
    }
}

function cutoffData(){
    swal({
        title: 'Yakin ingin melakukan cutoff data?',
        text: '',
        buttons: true
    }).then((confirm) => {
        if (confirm){
            swal({
                title: 'Mohon Tunggu...',
                text: 'Sedang melakukan cutoff pada data',
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

            apiCall('history-overbooking/cutoffData', 'GET', '',
            () => {},
            null,
            () => {},
            (res) => {
                swal('Cut Off Data Berhasil!', 'Berhasil melakukan cutoff data', 'success')
                showData()
            },true)
        }
    })
}