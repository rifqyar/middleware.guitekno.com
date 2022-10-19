const mainComponent = $('#logSIPD-component')

function collapse(id){
    if($(`#data-${id}`).css('display') == 'none'){
        $(`#data-${id}`).slideDown()
        if ($(`#data-${id}`).children().length <= 1)
        getData(id)
    } else {
        $(`#data-${id}`).slideUp()
    }
    $(`.data-log-sipd:not(#data-${id})`).slideUp()
}

function getData(id, filter = null){
    let perPage = $('select[name="perPage"] option:selected').val()
    let url = filter != null ? 'log-transaction/sipd/getData/'+id+'/'+perPage+'/'+filter : 'log-transaction/sipd/getData/'+id+'/'+perPage
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
    $('#list-data').find('.data-log-sipd').slideUp()
    $('#list-data').find('.data-log-sipd').html('')
})

function showDetail(res, req){
    $('#detail-log-sipd').modal('show')

    $('.nav-link').removeClass('active')
    $('.tab-pane').hide()

    let resData = JSON.parse(JSON.parse(window.atob(res)))
    let reqData = JSON.parse(JSON.parse(window.atob(req)))
    reqData = Array.isArray(reqData) == false ? [reqData] : reqData
    resData = Array.isArray(resData) == false ? [resData] : resData

    renderTable(reqData, '#table-request')
    renderTable(resData, '#table-response')
}

function renderTable(data, containerID, detail = false, detailTitle = ''){
    $('#detail-log-sipd').find(containerID).html('')
    $('#detail-log-sipd').find('.detail-data').html('')
    $('#detail-log-sipd').find('#'+containerID.split('-').slice(-1)[0]).find('.close-detail').fadeOut()
    $('#detail-log-sipd').find('.title-detail').html('')

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

    let table = tagHead[1] + elRow
    $('#detail-log-sipd').find(containerID).html(table)
    if (detail == true){
        detailTitle = detailTitle.split('_').join(' ')
        detailTitle = detailTitle.toLowerCase().replace(/\b[a-z]/g, (text) => {
            return text.toUpperCase();
        })

        $('#detail-log-sipd').find('#'+containerID.split('-').slice(-1)[0]).find('.close-detail').fadeIn()
        $('#detail-log-sipd').find('#'+containerID.split('-').slice(-1)[0]).find('.title-detail').html(detailTitle)
    }

    $('#detail-log-sipd').find('th').css('white-space', 'nowrap')
    $('#detail-log-sipd').find('td').css('white-space', 'nowrap')

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
    $(el).parentsUntil('#detail-log-sipd').find('.title-detail').html('')
    $(el).fadeOut()
}

function addFilter(rst_id){
    let filterContainer = $(`#data-${rst_id}`).find('#filter').find('#form-filter')

    if(filterContainer.children().length == 0){
        apiCall('log-transaction/sipd/render-filter', '', 'GET', () => {
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
            
            let arrRst = ['011', '021']
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
        $('input[name="tgl"]').removeAttr('readonly')

        if ($(e).val() == 'between'){
            $('.date-end').fadeIn()
            $('input[name="tgl2"]').addClass('required')
            $('input[name="tgl2"]').removeAttr('readonly')
        } else {
            $('.date-end').fadeOut()
            $('input[name="tgl2"]').val('')
            $('input[name="tgl2"]').removeClass('required')
            $('input[name="tgl2"]').prop('readonly', 'readonly')
        }
    } else {
        $('.date-end').fadeOut()
        $('input[name="tgl"]').val('')
        $('input[name="tgl"]').removeClass('required')
        $('input[name="tgl"]').prop('readonly', 'readonly')

        $('input[name="tgl2"]').val('')
        $('input[name="tgl2"]').removeClass('required')
        $('input[name="tgl2"]').prop('readonly', 'readonly')
    }
}

function setFilter(id){
    const formContainer = $(`#data-${id}`).find('#filter').find('#form-filter').find('.form-container')
    let required = formContainer.find('.required')
    let form = formContainer.find('.form-control')
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
        var tgl = $('input[name="tgl"]').val() == '' ? null : $('input[name="tgl"]').val();
        var operator_tgl = $('select[name="operator_tanggal"] option:selected').val()
        var tgl2 = $('input[name="tgl2"]').val() == '' ? null : $('input[name="tgl2"]').val();

        var filter = `{"bpd": "${bpd}", "tgl": "${tgl}", "operator_tgl": "${operator_tgl}", "tgl2": "${tgl2}"}`

        var filter = window.btoa(filter)
        
        getData(id, filter)
    }
}