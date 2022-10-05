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

function getData(id){
    let perPage = $('select[name="perPage"] option:selected').val()
    let url = 'log-transaction/bank/getData/'+id+'/'+perPage
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

        // Show Filter if in array of rst
        let arrRst = ['012', '011', '021', '022']
        if (arrRst.includes(id)){
            $(`#data-${id}`).find('#filter').fadeIn()
            $(`#data-${id}`).find('.btn-filter').attr(`onclick`, `addFilter('${id}')`)
            $(`#data-${id}`).find('.btn-showAllData').attr(`onclick`, `getData('${id}')`)
            $(`#data-${id}`).find('#setFilter').attr(`onclick`, `setFilter('${id}')`)
        }
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
    reqData = Array.isArray(reqData) == false ? [reqData] : reqData
    resData = Array.isArray(resData) == false ? [resData] : resData

    renderTable(reqData, '#table-request')
    renderTable(resData, '#table-response')
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
            swal.close()
            filterContainer.html(res.blade)
            filterContainer.slideDown()
            $(`#data-${rst_id}`).find('#filter').find('#setFilter').fadeIn()
        })
    }
}

function changeOperatorTgl(e){
    if ($(e).val() != '0'){
        $('input[name="tgl"]').addClass('required')
    } else {
        $('input[name="tgl"]').removeClass('required')
    }
}

function setFilter(id){
    const formContainer = $(`#data-${id}`).find('#filter').find('#form-filter').find('.form-container')
    let required = formContainer.find('.required')
    console.log(required)
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
        console.log(required)
        console.log($(required[0]).val())
        var filter = `(lst_request like '%"bank_code":"${$(required[0]).val()}"%' or lst_response like '%"bank_code":"${$(required[0]).val()}"%')`
        if (0 != $(required[1]).val()){
            filter += `and lst_created = '${$(required[2]).val()}'`
        }
        // console.log(filter)
        // filter = window.btoa(filter)
        // // showData(filter)
    }
}