const mainComponent = $('#overbooking-component')

$(document).ready(function(){
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    
    $('.t-overbooking').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${$('meta[name="baseurl"]').attr('content')}history-overbooking`,
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
            { data: 'amount', name: 'amount'},
            { data: 'tbk_execution_time', name: 'tbk_execution_time' },
            { data: 'tbk_sp2d_desc', name: 'tbk_sp2d_desc' },
            { data: 'tbk_internal_status', name: 'tbk_internal_status' },
            { data: 'ras_message', name: 'ras_message' }
        ],
        columnDefs: [
            { className: "text-center align-middle", targets: "_all" }
        ]
    });
})