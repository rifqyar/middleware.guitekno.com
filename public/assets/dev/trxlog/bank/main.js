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