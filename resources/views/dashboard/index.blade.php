@extends('layouts.app')

@section('page-title', __('Dashboard'))
@section('page-heading', __('Dashboard'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Dashboard')
    </li>
@stop

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
                            <div class="p-3 text-primary flex-1">
                                <i class="fa fa-exchange fa-3x"></i>
                            </div>
                            <div class="pr-3">
                                <h2 class="text-right">{{ $data['countTransaksi'] }}</h2>
                                <div class="text-muted">Jumlah Transaksi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary flex-1">
                                <i class="fa fa-money fa-3x"></i>
                            </div>
                            <div class="pr-3">
                                <h2 class="text-right">{{ $data['jumlahTransaksi'] }}</h2>
                                <div class="text-muted">Total Transaksi Berhasil</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary flex-1">
                                <i class="fa fa-university fa-3x"></i>
                            </div>
                            <div class="pr-3">
                                <h2 class="text-right">{{ $data['countBank'] }}</h2>
                                <div class="text-muted">Jumlah Bank</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget">
                    <div class="card-body">
                        <div class="row">
                            <div class="p-3 text-primary flex-1">
                                <i class="fa fa-trophy fa-3x"></i>
                            </div>
                            <div class="pr-3">
                                @if ($data['mostActiveBank'])
                                    <h2 class="text-right"> {{ $data['mostActiveBank']->bank_name ?? '' }} </h2>
                                @else
                                    <h2 class="text-right"> - </h2>
                                @endif
                                <div class="text-muted float-right">Bank Teraktif</div>
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
                            <h5 class="card-text" style="margin-top: 150px;">Data Tidak Tersedia</h5>
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
                                    <h5 class="card-text" style="margin-top: 80px;">Data Tidak Tersedia</h5>
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
                                    <h5 class="card-text" style="margin-top: 80px;">Data Tidak Tersedia</h5>
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
                    <div style="display: flex;justify-content:space-between">
                        <div>
                            <h6 class="card-header" id="transaksi_terkini"><b>Transaksi Hari Ini</b></h6>
                            </a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div style="display: flex;justify-content:space-between">
                        <div>
                            <h6 class="card-header"><b>Transaksi Dalam Proses Bank</b></h6>
                        </div>
                        <div class="card-header">
                            <a href="/history-overbooking">
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
                                    <th>Status</th>
                                    {{-- <th>Partner Id</th> --}}
                                    <th>Nama Bank</th>
                                    <th>Tanggal pengiriman</th>
                                    <th>Jumlah</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['trxOverbooking'] as $value)
                                    <tr>
                                        @if ($value->ras_id == '000')
                                            <td><span class="badge badge-success">Success</span></td>
                                        @elseif ($value->ras_id == '100')
                                            <td><span class="badge badge-warning">Process</span></td>
                                        @else
                                            <td><span class="badge badge-danger">Failed</span></td>
                                        @endif
                                        {{-- <td>{{ $value->tbk_partnerid }}</td> --}}
                                        <td>{{ $value->senderBank->bank_name }}</td>
                                        <td>{{ Helper::getFormatWib($value->tbk_execution_time) }} </td>
                                        <td> {{ Helper::getRupiah($value->tbk_amount) }}</td>
                                        <td> {{ $value->tbk_type }}</td>
                                    </tr>
                                @endforeach
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
        $('#transaksi_terkini').on('click', function(e) {
            // if (e) {
            //     const year = new Date().getFullYear()
            //     const month = ("0" + (new Date().getMonth() + 1)).slice(-2)
            //     const date = ("0" + new Date().getDate()).slice(-2)
            //     const tanggal = `${year}-${month}-${date}`
            //     console.log(tanggal)
            //     localStorage.setItem('tanggal', tanggal)
            //     window.location = '/transaksi'
            // } else {
            //     window.localStorage.removeItem('tanggal')
            // }
            const year = new Date().getFullYear()
            const month = ("0" + (new Date().getMonth() + 1)).slice(-2)
            const date = ("0" + new Date().getDate()).slice(-2)
            const tanggal = `${year}-${month}-${date}`
            console.log(tanggal)

            localStorage.setItem('tanggal', tanggal)
            window.location = '/transaksi'

        })

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

        $(document).ready(function() {
            chartTxDaily();
            chartTxType();
            chartTxBank();
            chartTxStatus();
        });
    </script>
@stop

@section('scripts')
    <!-- @foreach (\Vanguard\Plugins\Vanguard::availableWidgets(auth()->user()) as $widget)
    @if (method_exists($widget, 'scripts'))
    {!! app()->call([$widget, 'scripts']) !!}
    @endif
    @endforeach -->
@stop
