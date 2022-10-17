
function beforeAjaxSend(){
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
}

function onAjaxError(er, statusCode = null){
    if (statusCode == null){
        swal(
            "Something when error!",
            "Please check your internet connection and try again.",
            "error"
        );
        console.log(er);
    } else {
        swal(
            "Error",
            er,
            "error"
        );
    }
}

function fillResData(n, v, form_id){
    var resdata = $(`#${form_id}`);
    var html = `<input type='hidden' name='${n}' value='${v}'>`;

    var inputdata = resdata.find("input[name='"+n+"']")
    if(inputdata.val() == undefined){
        resdata.append(html);
    } else {
        inputdata.val(v)
    }
}

function fillResData2(n, v, form_id){
    var resdata = $(`#${form_id}`);
    var html = `<input type='hidden' name='${n}' value='${v}'>`;

    var inputdata = resdata.find("input[name='"+n+"']")
    resdata.append(html);
}

function apiCall(url, type, form_id, beforeAjax = null, errorAjax = null, header = null, callback, thrownError = true){
    var resData = form_id == '' ? null : $(`#${form_id}`).find("input[type='hidden']")
    var arr = new Array();
    $(resData).each(function(k,v){
        arr.push({"name":v.name,"value":v.value})
    })

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        }
    });

    var data ='';
    if (type == 'POST'){
        data = {resData: arr}
    } else if(type == 'PUT'){
        data = {
            resData: arr,
            _method: 'PUT'
        }
    } else {
        data = {}
    }

    $.ajax({
        url: `${$('meta[name="baseurl"]').attr('content')}${url}`,
        method: type,
        dataType: 'JSON',
        headers: header,
        data: data,
        beforeSend: () => {
            beforeAjax == null ? beforeAjaxSend() : beforeAjax()
        },
        success: (res) => {
            if (!res.status.code){
                if (res.status){
                    callback(res)
                } else {
                    errorAjax == null ? onAjaxError('There is an Error while fetching data') : errorAjax(res)
                }
            } else if(res.status.code == 200){
                callback(res)
            } else {
                errorAjax == null ? onAjaxError(res.status.msg, res.status.code) : errorAjax (res)
            }
        },
        error: (err) => {
            thrownError == true ? (errorAjax == null ? onAjaxError(err) : errorAjax(err)) : false;
        }
    })
}
