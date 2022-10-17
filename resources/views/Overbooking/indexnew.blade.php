@extends('layouts.app')

@section('page-title', __('Transaction - Overbooking'))
@section('page-heading', __('Transaction - Overbooking'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        @lang('Log Transaction')
    </li>
    <li class="breadcrumb-item active">
        @lang('SIPD')
    </li>
@stop
@section('content')
    <script type='text/javascript'
        src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <div id="overbooking-component">
        <div class="card" id="list-data">
            <div class="card-body">
                <h4>Transaksi</h4>
                <div>
                    <h6>Filter</h6>
                    <form class="form-group" method="post" action="/transaksi/export/excel">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <p>Bank Pengirim</p>
                                <select class="form-control filter datatable-input" data-col-index=0 name="sender_bank"
                                    id="sender_bank">
                                    <option value="">All</option>

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->code_bank }}">{{ $bank->bank->bank_name }}</option>
                                    @endforeach

                                </select>
                                {{-- {{ var_dump($param['rst_id']) }} --}}
                            </div>
                            <div class="col-md-4">
                                <p>Bank Penerima</p>
                                <select class="form-control filter datatable-input" data-col-index=1 name="recipient_bank"
                                    id="recipient_bank">
                                    <option value="">All</option>

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->code_bank }}">{{ $bank->bank->bank_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4">
                                <p>Type</p>
                                <select class="form-control filter datatable-input" data-col-index=2 name="type"
                                    id="type">
                                    <option value="">All</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->tbk_type }}">{{ $type->tbk_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mt-2">
                                <p>Status</p>
                                <select class="form-control filter datatable-input" data-col-index=2 name="ras_id"
                                    id="ras_id">
                                    <option value="">All</option>
                                    @foreach ($status as $list)
                                        <option value="{{ $list->ras_id }}">{{ $list->ras->ras_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <button type="button" class="btn btn-primary mb-2" id="kt_search">Filter</button>
                                <button type="button" class="btn btn-secondary mb-2" id="kt_reset">Reset</button>
                                <button type="submit" class="btn btn-warning mb-2" id="exportExcel">Export</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table t-overbooking" style="width: 100%;font-size:12px">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>Id Transaksi</th> --}}
                                <th>Bank Pengirim</th>
                                <th>Rekening Pengirim</th>
                                <th>Bank Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Total Transfer</th>
                                <th>Tipe</th>
                                <th>Tanggal Pengiriman</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Callback</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="modalCallback">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Callback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    <script>
        $(document).ready(function() {
            console.log("ready!");
            render()
            $('#exportExcel').on('click', function(e) {
                // window.location.replace('/transaksi/export/excel')

                // $(location).href('/transaksi/export/excel')

            })
        });

        function render() {
            var table = $('.table').DataTable({
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10', '25', '50', '100', 'All']
                ],

                pageLength: 10,

                language: {
                    'lengthMenu': 'Display _MENU_',
                },
                searchDelay: 500,

                processing: true,
                serverSide: true,
                ajax: {
                    url: '/transaksi/form',
                    method: 'post',
                    data: function(data) {
                        data.sender_bank = $('#sender_bank').val()
                        data.recipient_bank = $('#recipient_bank').val()
                        data.type = $('#type').val()
                        data.ras_id = $('#ras_id').val()

                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false
                    },
                    // {
                    //     data: 'tbk_partnerid'
                    // },
                    {
                        data: 'sender_bank.bank_name',
                        orderable: false,
                    },
                    {
                        data: 'tbk_sender_account'
                    },
                    {
                        data: 'receiver_bank.bank_name',
                        orderable: false,
                    },
                    {
                        data: 'tbk_recipient_account'
                    },
                    {
                        data: 'tbk_amount'
                    },
                    {
                        data: 'tbk_type'
                    },
                    {
                        data: 'tbk_execution_time'
                    },
                    {
                        data: 'tbk_sp2d_desc'
                    },
                    {
                        name: 'ras_id',
                        data: {
                            _: 'ras.ras_description',
                            sort: 'ras_id'
                        }
                        // orderable: false,
                    },
                    {
                        data: 'callback'
                    }
                    // {
                    //     data: 'Actions',
                    //     responsivePriority: -1
                    // },
                ],
            });

            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                // var params = {};
                // $('.datatable-input').each(function() {
                //     var i = $(this).data('col-index');
                //     console.log($(this).val())
                //     if (params[i]) {
                //         params[i] += '|' + $(this).val();
                //     } else {
                //         params[i] = $(this).val();
                //     }
                // });
                // $.each(params, function(i, val) {
                //     // apply search params to datatable
                //     table.column(i).search(val ? val : '', false, false);
                // });
                table.table().draw();
            });


            $('#kt_reset').on('click', function(e) {
                console.log(e)
                e.preventDefault();
                $('.datatable-input').each(function() {
                    $(this).val('');
                    table.column($(this).data('col-index')).search('', false, false);
                });
                table.table().draw();
            });
        }

        function openDetailCallback(id) {
            $.ajax({
                    url: "/transaksi/callback/" + id,
                })
                .done(function(data) {
                    res = data.data.lcb_request;
                    var res = JSON.parse(res);
                    var html = `<pre>${JSON.stringify(res, undefined, 4)}</pre>`
                    $('.modal-body').html(html)
                    $('#modalCallback').modal('show')
                    // swal("Data dari bank!", html);

                    console.log(data.data)
                });
        }
    </script>

@endsection
