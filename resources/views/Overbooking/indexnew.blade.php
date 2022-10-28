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
                            @if (env('APP_ENV') == 'development')
                                <div class="col-md-3">
                                    <p>Transaksi ID</p>
                                    <input class="form-control filter datatable-input" placeholder="Invoice ID"
                                        name="tbk_partnerid" id="tbk_partnerid" />
                                </div>
                            @endif
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
                            <div class="col-md-3">
                                <p>No SP2D</p>
                                <input class="form-control filter datatable-input" placeholder="No SP2D" name="tbk_sp2d_no"
                                    id="tbk_sp2d_no" />
                            </div>
                            <div class="col-md-3 mt-2">
                                <p>Bank Pengirim</p>
                                <select class="form-control filter datatable-input" data-col-index=0 name="sender_bank"
                                    id="sender_bank">
                                    <option value="">All</option>

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->code_bank }}">{{ $bank->bank->bank_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
                                <p>Bank Penerima</p>
                                <select class="form-control filter datatable-input" data-col-index=1 name="recipient_bank"
                                    id="recipient_bank">
                                    <option value="">All</option>

                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->code_bank }}">{{ $bank->bank->bank_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-3 mt-2">
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
                                <select class="form-control filter datatable-input" data-col-index=2 name="ras_status"
                                    id="ras_status">
                                    <option value="">All</option>
                                    {{-- @foreach ($status as $list) --}}
                                    <option value="success">Success</option>
                                    <option value="process">Process</option>
                                    <option value="failed">Failed</option>
                                    {{-- @endforeach --}}
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
                            <div class="col-md-3 mt-2">
                                <p>Tanggal Transaksi</p>
                                <input type="date" class="form-control filter datatable-input" name="created"
                                    id="created">
                            </div>
                            @if (env('APP_ENV') == 'development')
                                <div class="col-md-3 mt-2">
                                    <p>State</p>
                                    <select class="form-control filter datatable-input" data-col-index=2 name="state"
                                        id="state">
                                        <option value="">All</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->rrs_id }}">{{ $state->rrs_desc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if (auth()->user()->present()->role_id == '1' ||
                                auth()->user()->present()->role_id == '3' ||
                                auth()->user()->present()->role_id == '4')
                                <div class="col-md-3 mt-2">
                                    <p>Province</p>
                                    <select class="form-control filter datatable-input" data-col-index=1 name="province"
                                        id="province">
                                        <option value="">All</option>

                                        @foreach ($province as $p)
                                            <option value="{{ $p->prop_id }}">{{ $p->prop_nama }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            @endif
                            @if (auth()->user()->present()->role_id == '1' ||
                                auth()->user()->present()->role_id == '3' ||
                                auth()->user()->present()->role_id == '5')
                                <div class="col-md-3 mt-2">
                                    <p>Regency</p>
                                    <select class="form-control filter datatable-input" data-col-index=1 name="regency"
                                        id="regency">

                                        {{-- @foreach ($regency as $r)
                                            <option value="{{ $r->dati2_id }}">{{ $r->dati2_nama }}</option>
                                        @endforeach --}}

                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="row mt-4">
                            <div class="col">
                                <button type="button" class="btn btn-primary mb-2" id="kt_search">Filter</button>
                                <button type="button" class="btn btn-secondary mb-2" id="kt_reset">Reset</button>
                                <button type="button" class="btn btn-warning mb-2 dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <table class="table table-striped t-overbooking" style="width: 100%;font-size:12px">
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
                                <input type="text" class="form-control" id="detail_sender_bank" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">Rekening Pengirim</label>
                                <input type="text" class="form-control" id="detail_sender_account" readonly>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <h6>Penerima</h6>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputEmail4">Nama Penerima</label>
                                <input type="text" class="form-control" id="detail_recipient_bank" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">Rekening Penerima</label>
                                <input type="text" class="form-control" id="detail_recipient_account" readonly>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <h6>Detail</h6>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="inputEmail4">Invoice Id</label>
                                <input type="text" class="form-control" id="detail_invoice_id" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="inputEmail4">Type</label>
                                <input type="text" class="form-control" id="detail_type" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">No SP2D</label>
                                <input type="text" class="form-control" id="detail_sp2d_no" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label for="inputEmail4">Nominal SP2D</label>
                                <input type="text" class="form-control" id="detail_nominal_sp2d" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">Desc SP2D</label>
                                <input type="text" class="form-control" id="detail_desc_sp2d" readonly>
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
            // const tanggal = localStorage.getItem('tanggal') ? localStorage.getItem('tanggal') : '';
            // console.log(tanggal, 'test2')
            // $('#state').val(tanggal)

            $('#province').on('change', function() {
                var provID = $(this).val();

                if (provID === '0') {

                } else {
                    $.get("{{ route('trx.regency') }}?provID=" + provID, function(data) {
                        console.log(data, 'data')
                        $('#regency').html(data)
                    })
                }
            })

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
            // const tanggal = localStorage.getItem('tanggal')
            const tanggal = localStorage.getItem('tanggal') ? localStorage.getItem('tanggal') : '';
            console.log(tanggal, 'tanggal')
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
                        data.tbk_sp2d_no = $('#tbk_sp2d_no').val()
                        data.sender_bank = $('#sender_bank').val()
                        data.recipient_bank = $('#recipient_bank').val()
                        data.type = $('#type').val()
                        data.ras_status = $('#ras_status').val()
                        data.parameter = $('#parameter').val()
                        data.start_date = $('#start_date').val()
                        data.end_date = $('#end_date').val()
                        data.state = $('#state').val()
                        data.province = $('#province').val()
                        data.regency = $('#regency').val()
                        data.created = $('#created').val()
                        data.tanggal = tanggal

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
                        data: 'ras_id',
                        // data: {
                        //     _: 'ras_id',
                        //     sort: 'ras_id'
                        // },
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
                localStorage.removeItem('tanggal')
                console.log($('#start_date').val())
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
                localStorage.removeItem('tanggal')
                $('.datatable-input').each(function() {
                    $(this).val('');
                    table.column($(this).data('col-index')).search('', false, false);
                });
                table.table().draw();
            });

            $
        }

        function openDetailCallback(data) {
            var res = JSON.parse(atob(data));
            var html = `<pre>${JSON.stringify(res, undefined, 4)}</pre>`
            $('#body-callback').html(html)
            $('#modalCallback').modal('show')
        }

        function openDetailTransaksi(data) {
            var aa = JSON.parse(atob(data));
            console.log(aa)
            $('#modalDetail').modal('show')
            $('#detail_sender_bank').val(aa.sender_info.account_bank_name)
            $('#detail_sender_account').val(aa.sender_info.account_number)
            $('#detail_recipient_bank').val(aa.recipient_info.account_bank_name)
            $('#detail_recipient_account').val(aa.recipient_info.account_number)
            $('#detail_sp2d_no').val(aa.tx_additional_data.no_sp2d)
            $('#detail_nominal_sp2d').val(aa.tx_additional_data.nominal_sp2d)
            $('#detail_type').val(aa.tx_type)
            $('#detail_invoice_id').val(aa.tx_partner_id)
            $('#detail_desc_sp2d').val(aa.tx_additional_data.desc_sp2d)
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
