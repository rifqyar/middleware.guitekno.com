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

function getData(id){
    let perPage = $('select[name="perPage"] option:selected').val()
    let url = 'log-transaction/sipd/getData/'+id+'/'+perPage
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