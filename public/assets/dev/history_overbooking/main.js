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
            { data: 'tbk_sender_bank_id', name: 'tbk_sender_bank_id' },
            { data: 'tbk_sender_account', name: 'tbk_sender_account' },
            { 
                data: 'sender_amount', 
                name: 'sender_amount' //,
                // render: (data, type) => {
                //     var number = $.fn.dataTable.render.number(',', '.', 0, 'Rp. ').display(data)

                //     return number;
                // }
            },
            { data: 'tbk_notes', name: 'tbk_notes' },
            { data: 'tbk_recipient_bank_id', name: 'tbk_recipient_bank_id' },
            { data: 'tbk_recipient_account', name: 'tbk_recipient_account' },
            { data: 'recipient_amount', name: 'recipient_amount'},
            // render: (data, type) => {
            //     var number = $.fn.dataTable.render.number(',', '.', 0, 'Rp. ').display(data)

            //     return number;
            // } },
            { data: 'amount', name: 'amount'},
            // render: (data, type) => {
            //     var number = $.fn.dataTable.render.number(',', '.', 0, 'Rp. ').display(data)

            //     return number;
            // } },
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