$(document).ready(function(){
    $('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',

        onNext: function(tab, navigation, index) {
            var formID = $(tab).children().attr('href')
            var valid = validation(formID)
            if (valid){
                var form_name = $(formID).find('form').attr('class')
                var form = $(formID).find('form').find('.form-control')
                var bank_id = $(formID).find('form').find('select[name="bank_id"] option:selected').val()
                var bank_name = $(formID).find('form').find('select[name="bank_id"] option:selected').html()
                $('#bEndpoint_res_data').html('')

                for (let i = 0; i < form.length; i++) {
                    if (formID == '#data-bank'){
                        if ($(form[i]).css('display') != 'none'){
                            fillResData(form[i].name, form[i].value, form_name)
                        }
                    } else {
                        fillResData2(form[i].name, form[i].value, form_name)
                    }
                }

                if(formID == '#data-bank'){
                    $('#endpoint-bank').find('form').find('input[name="bank_secret_show"]').val(bank_name)
                }

                if (formID == '#endpoint-bank'){
                    $('#konfirm').find('#bank_id').html($('#bEndpoint_res_data').find('input[name="bank_secret_show"]').val())
                    $('#konfirm').find('#client_id').html($('#bank_res_data').find('input[name="client_id"]').val())
                    $('#konfirm').find('#client_secret').html($('#bank_res_data').find('input[name="client_secret"]').val())
                    $('#konfirm').find('#username').html($('#bank_res_data').find('input[name="username"]').val())
                    $('#konfirm').find('#password').html($('#bank_res_data').find('input[name="password"]').val())

                    $('#konfirm').find('#status').html($('#bEndpoint_res_data').find('input[name="status"]').val() == '00' ? 'staging' : 'production')

                    $('#konfirm').find('#endpoint_getToken').html($('#bEndpoint_res_data').find('input[name="endpoint"]')[0].value)
                    $('#konfirm').find('#endpoint_inquiry').html($('#bEndpoint_res_data').find('input[name="endpoint"]')[1].value)
                    $('#konfirm').find('#endpoint_overbooking').html($('#bEndpoint_res_data').find('input[name="endpoint"]')[2].value)
                    $('#konfirm').find('#endpoint_checkstatus').html($('#bEndpoint_res_data').find('input[name="endpoint"]')[3].value)
                    $('#konfirm').find('#endpoint_getHistory').html($('#bEndpoint_res_data').find('input[name="endpoint"]')[4].value)
                    $('#konfirm').find('#endpoint_callbackSIPD').html($('#bEndpoint_res_data').find('input[name="endpoint"]')[5].value)
                }

                return true;


                // var method = $(formID).find('form').attr('method')
                // postData(formID, form_name, method, (res) => {
                //     if (res){
                //         if (formID == '#data-bank'){
                //             var selectedBankId = $(formID).find('form').find('select[name="bank_id"] option:selected').val()
                //             $('input[name="bank_id"]').val(selectedBankId).fadeIn()
                //             $('input[name="id"]').parent().parent().fadeIn()
                //             $('input[name="id"]').val(res).fadeIn()

                //             $(formID).find('form').find('#select_bank').hide()
                //             $(formID).find('form').find('select[name="bank_id"]').hide()

                //             $('#bank_res_data').html('')
                //         }

                //         $(formID).find('form').attr('method', 'PUT')
                //         $(tab).removeClass('active')
                //         $(tab).children().children().addClass('checked')
                //     }
                // })
            } else {
                return false;
            }
        },
        onInit : function(tab, navigation, index){
            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            $width = 100/$total;

            navigation.find('li').css('width',$width + '%');


            var formID = $(tab).children().attr('href')

            if(formID == '#data-bank'){
                getAvailBank(formID)
            }

            //check number of tabs and fill the entire row
            var $total = navigation.find('li').length;
            $width = 100/$total;

            navigation.find('li').css('width',$width + '%');

        },

        onTabClick : function(tab, navigation, index){
            return false
        },

        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index+1;

            var $wizard = navigation.closest('.wizard-card');

            // If it's the last tab then hide the last button and show the finish instead
            if($current >= $total) {
                $($wizard).find('.btn-next').hide();
                $($wizard).find('.btn-finish').show();
            } else {
                $($wizard).find('.btn-next').show();
                $($wizard).find('.btn-finish').hide();
            }

            //update progress
            var move_distance = 100 / $total;
            move_distance = move_distance * (index) + move_distance / 2;

            $wizard.find($('.progress-bar')).css({width: move_distance + '%'});
            //e.relatedTarget // previous tab
            var id = $(tab).attr('id')
            $(tab).parent().find(`li:not(#${id})`).removeClass('active')
            $(tab).addClass('active')
            $(tab).children().children().addClass('checked')
        },
    });
})

function getAvailBank(formID){
    const selectComponent = $(formID).find('form').find('.bank_id-select')
    selectComponent.html('')
    apiCall('master-data/bank-secret/get-avail', 'GET', '', () => {}, () => {}, null, (res) => {
        var option = '<option></option>'
        selectComponent.append(option)

        res.data.map((val) => {
            option += `<option value="${val.bank_id}">${val.bank_id} - ${val.bank_name}<option/>`
            // selectComponent.append(option)
        })

        selectComponent.append(option)
    }, true);
}

function validation(formID){
    var required = $(formID).find('form').find('.required')
    var canInput = true

    required.removeClass('is-invalid')

    for (var i = 0; i < required.length; i++) {
        if (required[i].value == '') {
            canInput = false
            $(formID).find('form').find(`input[name="${required[i].name}"]`).addClass('is-invalid')
            $(formID).find('form').find(`select[name="${required[i].name}"]`).addClass('is-invalid')

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

    return canInput
}

// $('.btn-finish').on('click', function() {
//     postData('master-data/bank-secret', 'bank_res_data', 'POST', (res) => {
//     })
// })

function saveData(){
    $('#endpointData').html('')

    postData('master-data/bank-secret', 'bank_res_data', 'POST', (res) => {
        var dbs_id = res

        fillResData2('bank_secret', dbs_id, 'endpointData')
        var html = $('#bEndpoint_res_data').html()
        $('#endpointData').append(html)

        var formData  = new FormData()
        let endpoint = $('#endpointData').find('input[name="endpoint"]')
        let endpointType = $('#endpointData').find('input[name="endpoint_type"]')

        for (let i = 0; i < endpoint.length; i++) {
            formData.append(`endpoint[${i}]`, $(endpoint[i]).val())
        }

        for (let i = 0; i < endpointType.length; i++) {
            formData.append(`endpoint_type[${i}]`, $(endpointType[i]).val())
        }

        formData.append('status', $('input[name="status"]').val())
        formData.append('bank_secret', $('input[name="bank_secret"]').val())

        $.ajax({
            url: `${$('meta[name=baseurl]').attr('content')}master-data/bank-endpoint/add-wizard`,
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: () => {
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
            }, success: (res) => {
                swal.close()
                console.log(res)
                if (res.status.code == 200){
                    swal(
                        "Sukses menambahkan integrasi bank!",
                        "Berhasil menambahkan integrasi bank, halaman akan di reload",
                        "success"
                    );

                    window.location.reload()
                }
            }
        })
        // postData('master-data/bank-endpoint/add-wizard', 'endpointData', 'POST', (res) => {
        //     console.log(res)
        // })
    })
}

function postData(url, form_name, method, callback){

    apiCall(url, method,form_name,
    () => {
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
    }, () => { return false },
    { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    (res) => {
        if (res.status.code == 200) {
            $.toast({
                heading: 'Success Saving Bank Data',
                icon: 'success',
                position: 'top-right'
            })
            swal.close()

            callback(res.id)
        }
    }, true)
}

function getBankSecret(){
    const selectComponent = $('#endpoint-bank').find('form').find('.bank_secret-select')
    selectComponent.html('')
    apiCall('master-data/bank-endpoint/get-banksecret', 'GET', '', () => {}, () => {}, null, (res) => {
        var option = '<option></option>'
        res.data.map((val) => {
            option += `<option value="${val.id}">${val.bank_name}<option/>`
        })
        selectComponent.append(option)
    }, true);
}
