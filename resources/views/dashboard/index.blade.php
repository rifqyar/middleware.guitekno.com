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
                <div class="card widget" style="cursor: pointer" onclick="showConnectedProvince()">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary">
                                <i class="fa fa-globe fa-3x"></i>
                            </div>
                            <div class="pr-3 col-8">
                                <h2 class="text-right">{{ $data['countBank'] }}</h2>
                                <span class="text-muted  text-right">
                                    <p>Jumlah Provinsi Terkoneksi</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget" style="cursor: pointer" onclick="showConnectedCity()">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary">
                                <i class="fa fa-building fa-3x"></i>
                            </div>
                            <div class="pr-3 col-8">
                                @if ($data['countDati2'])
                                    <h2 class="text-right"> {{ $data['countDati2']}} </h2>
                                @else
                                    <h2 class="text-right"> - </h2>
                                @endif
                                <span class="text-muted  text-right">
                                    <p>Jumlah Kabupaten Kota Terkoneksi</p>
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
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="p-3 text-primary mb-3 ml-2">
                                <i class="fa fa-exchange fa-3x"></i>
                            </div>
                            <div class="pr-3 pb-0 col-8">
                                <h5 class="text-right mb-0">{{ $data['countTransaksiYesterday'] }}</h5>
                                <span class="text-muted  text-right caption-trx">
                                    <p>Total Transaksi Kemarin</p>
                                </span>
                                <div class="d-flex align-items-center" style="margin-top: -20px !important">
                                    <hr
                                        style="border-bottom: 2px solid rgb(113, 113, 113) !important; flex: 1; margin-right: 10px">
                                    <span
                                        class="
                                        @if ($data['percentageCountTrx'] > 0) text-success
                                        @else
                                        text-danger @endif
                                    ">
                                        {{ $data['percentageCountTrx'] }}%
                                    </span>
                                </div>
                                <h5 class="text-right mb-0">{{ $data['countTransaksiToday'] }}
                                    @if ((int) $data['countTransaksiToday'] - (int) $data['countTransaksiYesterday'] > 0)
                                        <i class="fa fa-angle-double-up text-success Blink" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-angle-double-down text-danger Blink" aria-hidden="true"></i>
                                    @endif
                                </h5>
                                <span class="text-muted text-right caption-trx">
                                    <p>Total Transaksi Hari ini</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-12">
                <div class="card widget">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="p-3 text-primary mb-3 ml-2">
                                <i class="fa fa-money fa-3x"></i>
                            </div>
                            <div class="pr-3 pb-0 col-8">
                                <h5 class="text-right mb-0">{{ $data['jumlahTransaksiYesterday'] }}</h5>
                                <span class="text-muted  text-right caption-trx">
                                    <p>Nilai Transaksi Berhasil Kemarin</p>
                                </span>
                                <div class="d-flex align-items-center" style="margin-top: -20px !important">
                                    <hr
                                        style="border-bottom: 2px solid rgb(113, 113, 113) !important; flex: 1; margin-right: 10px">
                                    <span
                                        class="
                                        @if ($data['percentageTrxToday'] > 0) text-success
                                        @else
                                        text-danger @endif
                                    ">
                                        {{ $data['percentageTrxToday'] }}%
                                    </span>
                                </div>
                                <h5 class="text-right mb-0">{{ $data['jumlahTransaksiToday'] }}
                                    @if ((int) $data['percentageTrxToday'] > 0)
                                        <i class="fa fa-angle-double-up text-success Blink" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-angle-double-down text-danger Blink" aria-hidden="true"></i>
                                    @endif
                                </h5>
                                <span class="text-muted text-right caption-trx">
                                    <p>Nilai Transaksi Berhasil Hari ini</p>
                                </span>
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
                            <h5 class="card-text" style="margin:150px 0 0 20px;">Data Tidak Tersedia</h5>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row" style="height:400px;">
                    <div class="col-md-12">
                        <div class="card" style="height: 190px">
                            <h6 class="card-header"><b>Jenis Transaksi</b></h6>
                            <div class="card-body p-0">
                                @if ($data['jenis'])
                                    <div id="chartTxType" style="height: 100%"></div>
                                @else
                                    <h5 class="card-text" style="margin:55px 0 0 20px;">Data Tidak Tersedia</h5>
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
                                    <h5 class="card-text" style="margin:55px 0 0 20px;">Data Tidak Tersedia</h5>
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
                        <div id="chartTxDaily" style="height: 100%"></div>
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
                            <a href="{{ route('transaksi-today', ['set_id' => 'today']) }}">
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" style="height:500px">
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

    @include('dashboard.modal')
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
                    // console.log(res)
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
                    // console.log(res)
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
                    // console.log(res)
                    $('#chartTxStatus').html(res)
                }
            })
        }

        function datatable({
            ras_status
        }) {
            return {
                responsive: true,
                dom: "lfrti",
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
                    url: '/transaksi/form',
                    method: 'post',
                    data: function(data) {
                        data.ras_status = ras_status

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
            }
        }

        function trxLog() {
            var table2 = $('#table-log').DataTable(datatable({
                ras_status: ''
            }))
        }

        function awaitTrxLog() {
            var table = $('#table-await-log').DataTable(datatable({
                ras_status: 'process'
            }))
        }

        $(document).ready(function() {
            chartTxDaily();
            chartTxType();
            chartTxBank();
            chartTxStatus();
            awaitTrxLog();
            trxLog();
        });

        function showConnectedProvince(){
            $("#detail-connected").modal('show')
        }

        function showConnectedCity(){
            $("#detail-connected").modal('show')
        }

        function showDaerah(id){
            if ($('#detail-connected').find(`#daerah-${id}`).css('display') == 'none'){
                $('#detail-connected').find(`#daerah-${id}`).slideDown()
                $('#detail-connected').find(`#icon-header-${id}`).addClass('fa-rotate-180')
            } else {
                $('#detail-connected').find(`#daerah-${id}`).slideUp()
                $('#detail-connected').find(`#icon-header-${id}`).removeClass('fa-rotate-180')
            }
        }
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
