@extends('layouts.app')

@section('page-title', __('Dashboard'))
@section('page-heading', __('Dashboard'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Dashboard')
    </li>
@stop
@section('styles')
    <style>
        .hai {
            background-color: #feffdf
        }

        .Blink {
            animation: blinker 1.5s cubic-bezier(.5, 0, 1, 1) infinite alternate;
        }

        @keyframes blinker {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .caption-trx {
            font-size: 12px !important
        }
    </style>
@endsection
@section('content')

    @include('partials.messages')

    <!-- <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
    @if ($widget->width)
    <div class="col-md-{{ $widget->width }}">
    @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            {!! app()->call([$widget, 'render']) !!}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @if ($widget->width)
    </div>
    @endif
    @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </div> -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary">
                                <i class="fa fa-exchange fa-3x"></i>
                            </div>
                            <div class="pr-3 col-8">
                                <h2 class="text-right">{{ $data['countTransaksi'] }}</h2>
                                <span class="text-muted  text-right">
                                    <p>Jumlah Transaksi</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary">
                                <i class="fa fa-money fa-3x"></i>
                            </div>
                            <div class="pr-3 col-8">
                                <h2 class="text-right">{{ $data['jumlahTransaksi'] }}</h2>
                                <span class="text-muted  text-right">
                                    <p>Total Transaksi Berhasil</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary">
                                <i class="fa fa-university fa-3x"></i>
                            </div>
                            <div class="pr-3 col-8">
                                <h2 class="text-right">{{ $data['countBank']->total_prop }}</h2>
                                <span class="text-muted  text-right">
                                    <p>Jumlah Provinsi</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary">
                                <i class="fa fa-trophy fa-3x"></i>
                            </div>
                            <div class="pr-3 col-8">
                                @if ($data['countDati2'])
                                    <h2 class="text-right"> {{ $data['countDati2']->total_dati ?? '' }} </h2>
                                @else
                                    <h2 class="text-right"> - </h2>
                                @endif
                                <span class="text-muted  text-right">
                                    <p>Jumlah Kabupaten</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BARU EY -->
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="p-3 text-primary mb-3 ml-2">
                                <i class="fa fa-exchange fa-3x"></i>
                            </div>
                            <div class="pr-3 pb-0 col-8">
                                <h5 class="text-right mb-0">{{ $data['lastMontTrans'] }}</h5>
                                <span class="text-muted  text-right caption-trx">
                                    <p>Transaksi Bulan Lalu</p>
                                </span>
                                <div class="d-flex align-items-center" style="margin-top: -20px !important">
                                    <hr
                                        style="border-bottom: 2px solid rgb(113, 113, 113) !important; flex: 1; margin-right: 10px">
                                    <span
                                        class="
                                        @if ($data['percentageMonth'] > 0) text-success
                                        @else
                                        text-danger @endif
                                    ">
                                        {{ $data['percentageMonth'] }}% </span>
                                </div>
                                <h5 class="text-right mb-0">{{ $data['thisMontTrans'] }}
                                    @if ((int) $data['thisMontTrans'] - (int) $data['lastMontTrans'] > 0)
                                        <i class="fa fa-angle-double-up text-success Blink" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-angle-double-down text-danger Blink" aria-hidden="true"></i>
                                    @endif
                                </h5>
                                <span class="text-muted  text-right caption-trx">
                                    <p>Transaksi Bulan ini</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="p-3 text-primary mb-3 ml-2">
                                <i class="fa fa-exchange fa-3x"></i>
                            </div>
                            <div class="pr-3 pb-0 col-8">
                                <h5 class="text-right mb-0">{{ $data['lastYearTrans'] }}</h5>
                                <span class="text-muted  text-right caption-trx">
                                    <p>Transaksi Tahun Lalu</p>
                                </span>
                                <div class="d-flex align-items-center" style="margin-top: -20px !important">
                                    <hr
                                        style="border-bottom: 2px solid rgb(113, 113, 113) !important; flex: 1; margin-right: 10px">
                                    <span
                                        class="
                                        @if ($data['percentageYear'] > 0) text-success
                                        @else
                                        text-danger @endif
                                    ">
                                        {{ $data['percentageYear'] }}% </span>
                                </div>
                                <h5 class="text-right mb-0">{{ $data['thisYearTrans'] }}
                                    @if ((int) $data['thisYearTrans'] - (int) $data['lastYearTrans'] > 0)
                                        <i class="fa fa-angle-double-up text-success Blink" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-angle-double-down text-danger Blink" aria-hidden="true"></i>
                                    @endif
                                </h5>
                                <span class="text-muted  text-right caption-trx">
                                    <p>Transaksi Tahun ini</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary flex-1">
                                <i class="fa fa-exchange fa-3x"></i>
                            </div>
                            <div class="pr-3">
                                {{-- @if ($data['countDati2']) --}}
                                <h2 class="text-right"> {{ $data['countTransaksiToday'] }} </h2>
                                {{-- @else --}}
                                {{-- <h2 class="text-right"> - </h2>
                                @endif --}}
                                <div class="text-muted float-right">Total Transaksi Hari ini</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary flex-1">
                                <i class="fa fa-exchange fa-3x"></i>
                            </div>
                            <div class="pr-3">
                                {{-- @if ($data['countDati2']) --}}
                                <h2 class="text-right"> {{ $data['jumlahTransaksiToday'] }} </h2>
                                {{-- @else --}}
                                {{-- <h2 class="text-right"> - </h2>
                                @endif --}}
                                <div class="text-muted float-right">Nilai Transaksi Hari ini</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="height: 400px">
                    <h6 class="card-header"><b>Transaksi(Bank)</b></h6>
                    <div class="card-body p-0">
                        @if ($data['bank'])
                            <div id="chartTxBank" style="height: 100%"></div>
                        @else
                            <center>
                                <h5 class="card-text" style="margin-top: 150px;">Data Tidak Tersedia</h5>
                            </center>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row" style="height:400px;">
                    <div class="col-md-12">
                        <div class="card" style="height: 192px">
                            <h6 class="card-header"><b>Jenis Transaksi</b></h6>
                            <div class="card-body p-0">
                                @if ($data['jenis'])
                                    <div id="chartTxType" style="height: 100%"></div>
                                @else
                                    <center>
                                        <h5 class="card-text" style="margin-top: 50px;">Data Tidak Tersedia</h5>
                                    </center>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card" style="height: 190px">
                            <h6 class="card-header"><b>Status Transaksi</b></h6>
                            <div class="card-body p-0">
                                @if ($data['jenis'])
                                    <div id="chartTxStatus" style="height: 100%"></div>
                                @else
                                    <center>
                                        <h5 class="card-text" style="margin-top: 50px;">Data Tidak Tersedia</h5>
                                    </center>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card" style="height: 400px">
                    <h6 class="card-header"><b>Transaksi Harian</b></h6>
                    <div class="card-body p-0">
                        @if ($data['transaksi'])
                            <div id="chartTxDaily" style="height: 100%"></div>
                        @else
                            <center>
                                <h5 class="card-text" style="margin-top: 150px;">Data Tidak Tersedia</h5>
                            </center>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="display: none">
                <div class="card">
                    <div style="display: flex;justify-content:space-between">
                        <div>
                            <h6 class="card-header">10 Log Callback terakhir</h6>
                        </div>
                        <div class="card-header">
                            <a href="/log-callback">
                                <button class="btn btn-success ">
                                    Lihat Semua
                                </button>
                            </a>

                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table" id="lastOverBooking">
                            <thead>
                                <tr>
                                    <th>Partner Id</th>
                                    <th>Callback Pertama</th>
                                    <th>Callback Terakhir</th>
                                    <th>Sevice Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['logCallback'] as $value)
                                    <tr>
                                        <td>{{ $value->lcb_partnerid }}</td>
                                        <td>{{ Helper::getFormatWib($value->lcb_created) }} </td>
                                        <td>{{ Helper::getFormatWib($value->lcb_last_updated) }} </td>
                                        <td>{{ $value->rst->rst_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div>
                        <div class="card-header" style="display: flex;justify-content:space-between">
                            <div>
                                <h5>Data 10 Transaksi Terakhir</h5>
                            </div>
                            <a href="{{ route('transaksi-today') }}">
                                <button class="btn btn-success ">
                                    Lihat Semua</button>
                            </a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="table-log">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bank Pengirim</th>
                                        <th>Bank Penerima</th>
                                        <th>Nama Penerima</th>
                                        <th>Rekening Penerima</th>
                                        <th>Total Transfer</th>
                                        <th>NO SP2D</th>
                                        <th>Tipe</th>
                                        <th>Tanggal Request</th>
                                        <th>Tanggal Pengiriman</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data['trxOverbooking'] as $value)
                                    <tr>
                                        <td>{{ $value->tbk_partnerid }}</td>
                                <td>{{ $value->senderBank->bank_name }}</td>
                                <td>{{ Helper::getFormatWib($value->tbk_execution_time) }} </td>
                                <td> {{ Helper::getRupiah($value->tbk_amount) }}</td>
                                <td> {{ $value->tbk_type }}</td>
                                @if ($value->ras_id == '000')
                                <td><span class="badge badge-success">Success</span></td>
                                @elseif ($value->ras_id == '100')
                                <td><span class="badge badge-warning">Process</span></td>
                                @else
                                <td><span class="badge badge-danger">Failed</span></td>
                                @endif
                                </tr>
                                @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div>
                        <div class="card-header" style="display: flex;justify-content:space-between">
                            <div>
                                <h5>Data Transaksi Menunggu di Proses</h5>
                            </div>
                            <a href="{{ route('transaksi-today', ['set_id' => 'today']) }}">
                                <button class="btn btn-success ">
                                    Lihat Semua</button>
                            </a>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table" id="table-await-log">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bank Pengirim</th>
                                        <th>Bank Penerima</th>
                                        <th>Nama Penerima</th>
                                        <th>Rekening Penerima</th>
                                        <th>Total Transfer</th>
                                        <th>NO SP2D</th>
                                        <th>Tipe</th>
                                        <th>Tanggal Request</th>
                                        <th>Tanggal Pengiriman</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($data['trxOverbooking'] as $value)
                                    <tr>
                                        <td>{{ $value->tbk_partnerid }}</td>
                                <td>{{ $value->senderBank->bank_name }}</td>
                                <td>{{ Helper::getFormatWib($value->tbk_execution_time) }} </td>
                                <td> {{ Helper::getRupiah($value->tbk_amount) }}</td>
                                <td> {{ $value->tbk_type }}</td>
                                @if ($value->ras_id == '000')
                                <td><span class="badge badge-success">Success</span></td>
                                @elseif ($value->ras_id == '100')
                                <td><span class="badge badge-warning">Process</span></td>
                                @else
                                <td><span class="badge badge-danger">Failed</span></td>
                                @endif
                                </tr>
                                @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="height: 500px">
                            <div class="embed-responsive embed-responsive-21by9">
                                <iframe class="embed-responsive-item"
                                    src="https://middlewareapi.guitekno.com/monitoring"></iframe>
                            </div>
                            {{-- <div class="embed-responsive embed-responsive-21by9">
                            <iframe class="embed-responsive-item"
                                src="https://middlewareapi.guitekno.com/monitoring"></iframe>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function chartTxDaily() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: '/chart/tx-daily',
                    data: {
                        transaksi: <?= json_encode($data['transaksi'], true) ?>,
                    },
                    success: function(res) {
                        console.log(res)
                        $('#chartTxDaily').html(res)
                    }
                })
            }

            function chartTxType() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: '/chart/tx-type',
                    data: {
                        data: <?= json_encode($data['jenis'], true) ?>
                    },
                    success: function(res) {
                        console.log(res)
                        $('#chartTxType').html(res)
                    }
                })
            }

            function chartTxBank() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: '/chart/tx-bank',
                    data: {
                        data: <?= json_encode($data['bank'], true) ?>
                    },
                    success: function(res) {
                        console.log(res)
                        $('#chartTxBank').html(res)
                    }
                })
            }

            function chartTxStatus() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: '/chart/tx-status',
                    data: {
                        data: <?= json_encode($data['status'], true) ?>
                    },
                    success: function(res) {
                        console.log(res)
                        $('#chartTxStatus').html(res)
                    }
                })
            }

            function trxLog() {
                // alert('ok')
                var table = $('#table-log').DataTable({
                    responsive: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        ['5', '10', '20']
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
                        url: '/trx-log',
                        method: 'post',
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
                            name: 'tbk_created.display',
                            data: {
                                _: 'tbk_created.display',
                                sort: 'tbk_created.timestamp'
                            },
                        },
                        {
                            name: 'tbk_execution_time.display',
                            data: {
                                _: 'tbk_execution_time.display',
                                sort: 'tbk_execution_time.timestamp'
                            },
                        },
                        {
                            data: 'ras_id',
                            responsivePriority: -1
                        },
                    ],
                });
            }

            function awaitTrxLog() {
                var table = $('#table-await-log').DataTable({
                    responsive: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        ['5', '10']
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
                        url: '/await-trx-log',
                        method: 'post',
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
                            name: 'tbk_created.display',
                            data: {
                                _: 'tbk_created.display',
                                sort: 'tbk_created.timestamp'
                            },
                        },
                        {
                            name: 'tbk_execution_time.display',
                            data: {
                                _: 'tbk_execution_time.display',
                                sort: 'tbk_execution_time.timestamp'
                            },
                        },
                        {
                            data: 'ras_id',
                            responsivePriority: -1
                        },
                    ],
                });
            }
            $(document).ready(function() {
                chartTxDaily();
                chartTxType();
                chartTxBank();
                chartTxStatus();
                trxLog();
                awaitTrxLog();
            });
        </script>
    @stop

    @section('scripts')
        //
        <!-- @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
    // @if (method_exists($widget, 'scripts'))
    // {!! app()->call([$widget, 'scripts']) !!}
                                                                                                                        //
    @endif
                                                                                                                        //
    @endforeach -->
    @stop
