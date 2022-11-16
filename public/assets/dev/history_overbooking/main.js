    const mainComponent = $('#overbooking-component')

$(document).ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    var tx_type = localStorage.getItem('tx-type') == 'Gaji' ? 'LS|GAJI' : 'LS|NONGAJI' 

    if (localStorage.getItem('tx-type')){    
        $('#formFilter').html(`<input type='hidden' name='field_name' value='tbk_type'>`)
        $('#formFilter').html(`<input type='hidden' name='operator' value='='>`)
        $('#formFilter').html(`<input type='hidden' name='value' value='${tx_type}'>`)
    }
    
    showData()
    
    localStorage.removeItem('tx-type')
})

function showData(){
    mainComponent.find('#form-filter').fadeOut()

    if(mainComponent.find('#list-data').css('display') == 'none'){
        mainComponent.find('#list-data').fadeIn()
    }

    if(mainComponent.find('#form-filter').css('display') != 'none'){
        mainComponent.find('#form-filter').fadeOut()
        mainComponent.find('#filter').find('#setFilter').fadeOut()
    } 

    $('.t-overbooking').DataTable().destroy();
    const url = `${$('meta[name="baseurl"]').attr('content')}history-overbooking`
    getData(url)

    function getData(url){
        $('.t-overbooking').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: url,
                method: 'post',
                data: function(d){
                    var filterVal = new Array()
                    var name = $('#formFilter').find('input[name="field_name"]')
                    var operator = $('#formFilter').find('input[name="operator"]')
                    var value = $('#formFilter').find('input[name="value"]')
                    var separator = $('#formFilter').find('input[name="separator"]')

                    for (let i = 0; i < $("#formFilter").find('input').length; i++) {
                        filterVal.push({
                            'separator' : $(separator[i-1]).val(),
                            'name' : $(name[i]).val(),
                            'operator' : $(operator[i]).val(),
                            'value' : $(value[i]).val(),
                        })
                    }
                    d.filter = filterVal
                }
            },
            columns: [
                // { data: 'action', name: 'action' },
                { data: 'status' },
                { data: 'tbk_partnerid' },
                { data: 'sender_bank_name' },
                { data: 'tbk_sender_account' },
                { data: 'sender_amount'},
                { data: 'tbk_notes' },
                { data: 'recipient_bank_name' },
                { data: 'tbk_recipient_account' },
                { data: 'recipient_amount'},
                { data: 'tbk_execution_time' },
                { data: 'tbk_sp2d_desc' },
                { data: 'status_message' }
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
        if($(el).val() != 'tbk_created'){
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

            $(el).parentsUntil('.form-container').parent().find("#value").fadeIn()
            $(el).parentsUntil('.form-container').parent().find("select[name='value']").fadeIn()
            $(el).parentsUntil('.form-container').parent().find("#date-value").fadeOut()
            $(el).parentsUntil('.form-container').parent().find("input[name='tgl']").fadeOut()
            $(el).parentsUntil('.form-container').parent().find(".select-operator").find('option[value="between"]').fadeOut()
        } else {
            $(el).parentsUntil('.form-container').parent().find("#value").fadeOut()
            $(el).parentsUntil('.form-container').parent().find("select[name='value']").fadeOut()
            $(el).parentsUntil('.form-container').parent().find("#date-value").fadeIn()
            $(el).parentsUntil('.form-container').parent().find("input[name='tgl']").fadeIn()
            $(el).parentsUntil('.form-container').parent().find(".select-operator").find('option[value="between"]').fadeIn()

        }
    } else {
        selectComponent.html('<option></option>')
    }
}

function changeOperator(el){
    if ($(el).val() == 'between'){
        $(el).parentsUntil('.form-container').parent().find('.date-end').fadeIn()
        $(el).parentsUntil('.form-container').parent().find('input[name="tgl2"]').fadeIn()
        $(el).parentsUntil('.form-container').parent().find('input[name="tgl2"]').removeAttr('readonly')
        $(el).parentsUntil('.form-container').parent().find('input[name="tgl2"]').addClass('required')
    } else {
        $(el).parentsUntil('.form-container').parent().find('.date-end').fadeOut()
        $(el).parentsUntil('.form-container').parent().find('input[name="tgl2"]').fadeOut()
        $(el).parentsUntil('.form-container').parent().find('input[name="tgl2"]').prop('readonly', true)
        $(el).parentsUntil('.form-container').parent().find('input[name="tgl2"]').removeClass('required')
    }
}

function setFilter(type = 'table'){
    const formContainer = mainComponent.find("#form-filter").find('.form-container')
    var required = mainComponent.find(formContainer).find('.required')
    var canInput = true

    required.removeClass('is-invalid')
    
    if (type == 'table'){
        for(var i = 0; i < required.length; i++){
            if($(required[i]).css('display') != 'none'){
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
        }
    }

    if (canInput){
        var filter = ''
        $('#formFilter').html('')
        formContainer.find('.form-control').each((k, v) => {
            if ($(v).css('display') != 'none'){
                fillResData2($(v).attr('name'), $(v).val(), 'formFilter')

                // Buat punya si daniel, males ngerubah
                if ($(v).attr('name') != 'value' && $(v).attr('name') != 'tgl' && $(v).attr('name') != 'tgl2'){
                    filter += `${$(v).val()} `
                } else {
                    if ($(v).attr('name') == 'tgl2'){
                        filter += `and '${$(v).val()}' `
                    } else {
                        filter += `'${$(v).val()}' `
                    }
                }
            }
        })
        if (type == 'table'){
            showData()
        } else {
            swal({
                title: 'Now loading',
                allowEscapeKey: false,
                allowOutsideClick: false,
                content: {
                    element: "i",
                    attributes: {
                        className: "fas fa-spinner fa-spin text-large",
                    },
                },
                buttons: !1,
                closeOnClickOutside: !1,
                closeOnEsc: !1,
                onOpen: () => {
                    swal.showLoading();
                }
            })

            window.open(
                '/overbooking-pdf/' + filter,
                '_blank'
            )
        }
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