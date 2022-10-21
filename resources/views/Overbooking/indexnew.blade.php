@extends('layouts.app')

@section('page-title', __('Transaction - Overbooking'))
@section('page-heading', __('Transaction - Overbooking'))

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
@endsection

@section('breadcrumbs')
    {{-- <li class="breadcrumb-item">
        @lang('Log Transaction')
    </li>
    <li class="breadcrumb-item active">
        @lang('SIPD')
    </li> --}}
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
                    <form class="form-group" method="post" action="/transaksi/export/file">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <p>Transaksi ID</p>
                                <input class="form-control filter datatable-input" placeholder="Invoice ID"
                                    name="tbk_partnerid" id="tbk_partnerid" />
                            </div>
                            <div class="col-md-3">
                                <p>Nama Penerima</p>
                                <input class="form-control filter datatable-input" placeholder="Nama Penerima"
                                    name="tbk_recipient_name" id="tbk_recipient_name" />
                            </div>
                            <div class="col-md-3">
                                <p>Rekening Penerima</p>
                                <input class="form-control filter datatable-input" placeholder="No Rekening Penerima"
                                    name="tbk_recipient_account" id="tbk_recipient_account" />
                            </div>
                            <div class="col-md-2">
                                <p>Bank Pengirim</p>
                                <select class="form-control filter datatable-input" data-col-index=0 name="sender_bank"
                                    id="sender_bank">
                                    <option value="">All</option>

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->code_bank }}">{{ $bank->bank->bank_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-2">
                                <p>Bank Penerima</p>
                                <select class="form-control filter datatable-input" data-col-index=1 name="recipient_bank"
                                    id="recipient_bank">
                                    <option value="">All</option>

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->code_bank }}">{{ $bank->bank->bank_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <p>Type</p>
                                <select class="form-control filter datatable-input" data-col-index=2 name="type"
                                    id="type">
                                    <option value="">All</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->tbk_type }}">{{ $type->tbk_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <p>Status</p>
                                <select class="form-control filter datatable-input" data-col-index=2 name="ras_id"
                                    id="ras_id">
                                    <option value="">All</option>
                                    @foreach ($status as $list)
                                        <option value="{{ $list->ras_id }}">{{ $list->ras->ras_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-7 mt-2">
                                <p>Tanggal Pengiriman</p>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-control filter" name="parameter" onchange="formDate()"
                                            id="parameter">
                                            <option value="">All</option>
                                            <option value="=">=</option>
                                            <option value="<=">
                                                <= </option>
                                            <option value=">="> >= </option>
                                            <option value="between">Between</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <input type="date" class="form-control filter datatable-input" name="start_date"
                                            id="start_date" readonly>
                                    </div>
                                    <div class="col-4">
                                        <input type="date" class="form-control filter datatable-input" name="end_date"
                                            id="end_date" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <button type="button" class="btn btn-primary mb-2" id="kt_search">Filter</button>
                                <button type="button" class="btn btn-secondary mb-2" id="kt_reset">Reset</button>
                                <button type="button" class="btn btn-warning mb-2 dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Export
                                </button>
                                <div class="dropdown-menu">
                                    <button type="submit" class="btn btn-warning dropdown-item" id="exportExcel"
                                        name="button" value="excel">Excel</button>
                                    <button type="submit" class="btn btn-warning dropdown-item" id="exportExcel"
                                        name="button" value="pdf">Pdf</button>
                                </div>
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
                                <th>Bank Penerima</th>
                                {{-- <th>Nama Pengirim</th> --}}
                                <th>Nama Penerima</th>
                                <th>Rekening Penerima</th>
                                <th>Total Transfer</th>
                                <th>NO SP2D</th>
                                <th>Tipe</th>
                                <th>Tanggal Pengiriman</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Callback</th>
                                <th>Action</th>
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
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="body-callback">
                </div>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="modalDetail">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Sender Info</h6>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputEmail4">Nama Pengirim</label>
                                <input type="email" class="form-control" id="detail_sender_bank" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">Rekening Pengirim</label>
                                <input type="email" class="form-control" id="detail_sender_account" readonly>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <h6>Penerima</h6>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputEmail4">Nama Penerima</label>
                                <input type="email" class="form-control" id="detail_recipient_bank" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">Rekening Penerima</label>
                                <input type="email" class="form-control" id="detail_recipient_account" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log("ready!");
            render()
            $('#exportExcel').on('click', function(e) {
                // window.location.replace('/transaksi/export/excel')

                // $(location).href('/transaksi/export/excel')

            })
            var recepientName = `{{ $name }}`;
            console.log(recepientName, 'rn')
            $("#tbk_recipient_name").autocomplete({
                source: recepientName.split(',')
            });
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
                searching: false,
                ajax: {
                    url: '/transaksi/form',
                    method: 'post',
                    data: function(data) {
                        data.tbk_partnerid = $('#tbk_partnerid').val()
                        data.tbk_recipient_name = $('#tbk_recipient_name').val()
                        data.tbk_recipient_account = $('#tbk_recipient_account').val()
                        data.sender_bank = $('#sender_bank').val()
                        data.recipient_bank = $('#recipient_bank').val()
                        data.type = $('#type').val()
                        data.ras_id = $('#ras_id').val()
                        data.parameter = $('#parameter').val()
                        data.start_date = $('#start_date').val()
                        data.end_date = $('#end_date').val()

                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        responsivePriority: -1
                    },
                    // {
                    //     data: 'tbk_partnerid'
                    // },
                    {
                        data: 'sender_bank.bank_name',
                        orderable: false,
                    },
                    {
                        data: 'receiver_bank.bank_name',
                        orderable: false,
                    },
                    {
                        data: 'tbk_recipient_name',
                        responsivePriority: -1
                    },

                    {
                        data: 'tbk_recipient_account',
                        responsivePriority: -1

                    },
                    {
                        data: 'tbk_amount'
                    },
                    {
                        data: 'tbk_sp2d_no',
                        responsivePriority: -1
                    },
                    {
                        data: 'tbk_type'
                    },
                    {
                        data: 'tbk_execution_time'
                    },
                    {
                        data: 'tbk_sp2d_desc',
                        responsivePriority: -1

                    },
                    {
                        name: 'ras_id',
                        data: {
                            _: 'ras.ras_description',
                            sort: 'ras_id'
                        },
                        responsivePriority: -1
                        // orderable: false,
                    },
                    {
                        data: 'Callback',

                    },
                    {
                        data: 'Actions',
                        responsivePriority: -1
                    },
                ],
            });

            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });

            // $('.datatable-input').on('change', function(e) {
            //     console.log(e)
            //     e.preventDefault();
            //     table.table().draw();
            // window.location.replace('/transaksi/export/excel')

            // $(location).href('/transaksi/export/excel')

            // })

            $('#kt_reset').on('click', function(e) {
                console.log(e)
                e.preventDefault();
                $('.datatable-input').each(function() {
                    $(this).val('');
                    table.column($(this).data('col-index')).search('', false, false);
                });
                table.table().draw();
            });

            $
        }

        function openDetailCallback(id) {
            $.ajax({
                    url: "/transaksi/callback/" + id,
                })
                .done(function(data) {
                    res = data.data.lcb_request;
                    var res = JSON.parse(res);
                    var html = `<pre>${JSON.stringify(res, undefined, 4)}</pre>`
                    $('#body-callback').html(html)
                    $('#modalCallback').modal('show')
                    // swal("Data dari bank!", html);

                    console.log(data.data)
                });
        }

        function openDetailTransaksi(data) {
            var aa = JSON.parse(atob(data));
            console.log(aa)
            $('#modalDetail').modal('show')
            $('#detail_sender_bank').val(aa.sender_info.account_bank_name)
            $('#detail_sender_account').val(aa.sender_info.account_number)
            $('#detail_recipient_bank').val(aa.recipient_info.account_bank_name)
            $('#detail_recipient_account').val(aa.recipient_info.account_number)
        }

        function formDate() {
            var value = $('#parameter').val()
            if (value == 'between') {
                $('#end_date').attr("readonly", false);
                $('#start_date').attr("readonly", false);
            } else if (value == '<=' ||
                value == '>=') {
                $('#start_date').attr("readonly", false);
            } else {
                $('#end_date').attr("readonly", true);
                $('#start_date').attr("readonly", true);
            }
        }

        // $(function() {

        // });
    </script>

@endsection
