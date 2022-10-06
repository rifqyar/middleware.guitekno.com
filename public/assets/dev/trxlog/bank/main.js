const mainComponent = $('#logBank-component')
function collapse(id){
    if($(`#data-${id}`).css('display') == 'none'){
        $(`#data-${id}`).slideDown()
        if ($(`#data-${id}`).children().length <= 1)
        getData(id)
    } else {
        $(`#data-${id}`).slideUp()
    }
    $(`.data-log-bank:not(#data-${id})`).slideUp()

}

function getData(id, filter = null){
    let perPage = $('select[name="perPage"] option:selected').val()
    let url = filter != null ? 'log-transaction/bank/getData/'+id+'/'+perPage+'/'+filter : 'log-transaction/bank/getData/'+id+'/'+perPage
    apiCall(url, 'GET', null, () => {
        $(`#data-${id}`).html(`
            <div class="row justify-content-center">   
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `)
    },null,null,(res) => {
        $(`#data-${id}`).html(res.blade)
        $(`#data-${id}`).find('th').css('white-space', 'nowrap')
        $(`#data-${id}`).find('td').css('white-space', 'nowrap')

        $(`#data-${id}`).find('#filter').fadeIn()
        $(`#data-${id}`).find('.btn-filter').attr(`onclick`, `addFilter('${id}')`)
        $(`#data-${id}`).find('.btn-showAllData').attr(`onclick`, `getData('${id}')`)
        $(`#data-${id}`).find('#setFilter').attr(`onclick`, `setFilter('${id}')`)
    }, true)
}

$('select[name="perPage"]').on('change', function(){
    $('#list-data').find('.data-log-bank').slideUp()
    $('#list-data').find('.data-log-bank').html('')
})

function showDetail(res, req, status){
    $('#detail-log-bank').modal('show')

    $('.nav-link').removeClass('active')
    $('.tab-pane').hide()

    let resData = res != '' ? JSON.parse(JSON.parse(window.atob(res))) : null
    let reqData = req != '' ? JSON.parse(JSON.parse(window.atob(req))) : null
    
    $('#request-raw').find('.prettyprint').html(JSON.stringify(reqData, undefined, 4))
    $('#response-raw').find('.prettyprint').html(JSON.stringify(resData, undefined, 4))

    reqData = Array.isArray(reqData) == false ? [reqData] : reqData
    resData = Array.isArray(resData) == false ? [resData] : resData

    renderTable(reqData, '#table-request')
    renderTable(resData, '#table-response')

}

function copyClipboard(el){
    var text = $(el).parent().children()[1]
    text = $(text).html()
    navigator.clipboard.writeText(text).then(
        function() {
            $.toast({
                heading: 'Coppied!',
                text: `Content Coppied to clipboard`,
                icon: 'info',
                loader: true,       
                loaderBg: '#9EC600', 
                position: 'top-right',
            })
        }, 
        function() {
            $.toast({
                heading: 'Error',
                text: `Your browser doesn't support`,
                icon: 'error',
                loader: true,       
                loaderBg: '#9EC600', 
                position: 'top-right',
            })
        }
      )
}

function renderTable(data, containerID, detail = false, detailTitle = ''){
    $('#detail-log-bank').find(containerID).html('')
    $('#detail-log-bank').find('.detail-data').html('')
    $('#detail-log-bank').find('#'+containerID.split('-').slice(-1)[0]).find('.close-detail').fadeOut()
    $('#detail-log-bank').find('.title-detail').html('')

    data = typeof data == 'string' ? JSON.parse(window.atob(data)) : data
    var tagHead = Headers(data); 
    let cols = tagHead[0]
    var elRow = "<tbody>"

    for (var i = 0; i < data.length; i++) {
        elRow += '<tr>';
        for (let x = 0; x < cols.length; x++) {
            var value = data[i][cols[x]];
            value = value == null ? '' : value;
            if (typeof value == 'object'){
                var childVal = Array.isArray(value) == false ? [value] : value
                childVal = window.btoa(JSON.stringify(childVal))
                
                var detailContainer = detail == false ? containerID.split('-').join('-detail-') : containerID
                value = `<button class="btn btn-sm btn-primary" onclick="renderTable('${childVal}', '${detailContainer}', ${true}, '${cols[x]}')">Detail</button>`;
            }
            elRow += '<td>'+value+'</td>'
        }
        elRow += '</tr>';
    }
    elRow += '</tbody>'
    
    let table = data[0] != null ? tagHead[1] + elRow : '<center><h4 class="text-danger">There in an error on data</h4></center>'

    $('#detail-log-bank').find(containerID).html(table)
    if (detail == true){
        detailTitle = detailTitle.split('_').join(' ')
        detailTitle = detailTitle.toLowerCase().replace(/\b[a-z]/g, (text) => {
            return text.toUpperCase();
        })

        $('#detail-log-bank').find('#'+containerID.split('-').slice(-1)[0]).find('.close-detail').fadeIn()
        $('#detail-log-bank').find('#'+containerID.split('-').slice(-1)[0]).find('.title-detail').html(detailTitle)
    }

    $('#detail-log-bank').find('th').css('white-space', 'nowrap')
    $('#detail-log-bank').find('td').css('white-space', 'nowrap')

    function Headers(list) {
        var columns = [];
        var header = '<thead><tr>';
         
        for (var i = 0; i < list.length; i++) {
            var row = list[i];
            for (var k in row) {
                if ($.inArray(k, columns) == -1) {
                    columns.push(k);
                    var name = k.split('_').join(' ')
                    name = name.toLowerCase().replace(/\b[a-z]/g, (text) => {
                        return text.toUpperCase();
                    })
                    header += `<th>${name}</th>`;
                }
            }
        }

        header += '</tr></thead>';
        return [columns, header];
    }      
}

function closeDetailData(el){
    $(el).parent().find('.detail-data').html('')
    $(el).parentsUntil('#detail-log-bank').find('.title-detail').html('')
    $(el).fadeOut()
}

function addFilter(rst_id){
    let filterContainer = $(`#data-${rst_id}`).find('#filter').find('#form-filter')

    if(filterContainer.children().length == 0){
        apiCall('log-transaction/bank/render-filter', '', 'GET', () => {
            swal({
                title: 'Render Filter...',
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
        }, null, null, (res) => {
            filterContainer.html(res.blade)
            $(`#data-${rst_id}`).find('#filter').find('#setFilter').fadeIn()
            
            let arrRst = ['012', '022']
            if (!arrRst.includes(rst_id)){
                $(`#data-${rst_id}`).find('#form_bpd').fadeOut(100)
                $(`#data-${rst_id}`).find('#form_bpd').find('.required').each((k, v) => {
                    $(v).removeClass('required')
                })
            }

            filterContainer.slideDown()
            swal.close()
        })
    }
}

function changeOperatorTgl(e){
    if ($(e).val() != '0'){
        $('input[name="tgl"]').addClass('required')
        $('input[name="tgl"]').removeAttr('disabled')
    } else {
        $('input[name="tgl"]').removeClass('required')
        $('input[name="tgl"]').prop('disabled', 'disabled')
    }
}

function setFilter(id){
    const formContainer = $(`#data-${id}`).find('#filter').find('#form-filter').find('.form-container')
    let required = formContainer.find('.required')
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

    if (canInput){
        var bpd = typeof $('select[name="bpd"] option:selected').val() == 'undefined' ? null : $('select[name="bpd"] option:selected').val();
        var tgl = typeof $('input[name="tgl"]').val() == "undefined" ? null : $('input[name="tgl"]').val();
        var operator_tgl = $('select[name="operator_tanggal"] option:selected').val()

        var filter = window.btoa(`{"bpd": "${bpd}", "tgl": "${tgl}", "operator_tgl": "${operator_tgl}"}`)
        
        getData(id, filter)
    }
}