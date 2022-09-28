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
                                <div class="text-muted">Jumlah Proses Transaksi</div>
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
                                <div class="text-muted">Total Transaksi</div>
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
                                    <h2 class="text-right"> {{ $data['mostActiveBank']->bank_name }} </h2>
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
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="height: 400px">
                    <h6 class="card-header"><b>Transaksi(Bank)</b></h6>
                    <div class="card-body p-0">
                        @if ($data['bank'])
                            <div id="divTxBank" style="height: 100%"></div>
                        @else
                            <h5 class="card-text" style="margin-top: 150px;">Data Tidak Tersedia</h5>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="height: 400px">
                    <h6 class="card-header"><b>Transaksi</b></h6>
                    <div class="card-body p-0">
                        <div id="divTxDaily" style="height: 100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row" style="height:400px;">
                    <div class="col-md-12">
                        <div class="card text-center" style="height: 192px">
                            {{-- <h6 class="card-header">Jenis Transaksi</h6> --}}
                            <div class="card-body p-0">
                                {{-- <p>Jenis Transaksi</p> --}}
                                @if ($data['jenis'])
                                    <div id="divTxType"style="height: 100%"></div>
                                @else
                                    <h5 class="card-text" style="margin-top: 80px;">Data Tidak Tersedia</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card text-center" style="height: 190px">
                            {{-- <h6 class="card-header">Status Transaksi</h6> --}}
                            <div class="card-body p-0">
                                @if ($data['jenis'])
                                    <div id="divTxStatus" style="height: 100%"></div>
                                @else
                                    <h5 class="card-text" style="margin-top: 80px;">Data Tidak Tersedia</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
            {{-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h6 class="card-header">Transaksi</h6>
                    <div class="card-body p-0">

                        @if ($data['transaksi'])
                            <div id="divTxDaily" style="height: 400px"></div>
                        @else
                            <center>
                                <h5>Data Tidak Tersedia</h5>
                            </center>
                        @endif
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-md-12">
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
                            <h6 class="card-header">Data Transaksi Ongoing</h6>
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
                                    <th>Partner Id</th>
                                    <th>Nama Bank</th>
                                    <th>Tanggal pengiriman</th>
                                    <th>Jumlah</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['trxOverbooking'] as $value)
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <?php //echo phpinfo();
    ?> -->
    <script>
        function createTxDailyChart(data) {
            am4core.useTheme(am4themes_animated);
            var chart = am4core.create("divTxDaily", am4charts.XYChart);
            var bank = <?= json_encode($data['bank'], true) ?>;
            var data = <?= json_encode($data['transaksi'], true) ?>;
            let chartData = []
            for (i in data) {
                var tempData = {
                    tanggal: data[i].tanggal
                }
                for (j in data[i].data) {
                    var valueName = `value${data[i].data[j].tbk_sender_bank_id}`
                    // console.log(valueName, 'value')
                    tempData[valueName] = data[i].data[j].total
                }
                console.log(tempData)
                chartData.push(tempData);
            }
            console.log(chartData, 'result')
            // Add data
            chart.data = chartData;

            // Create axes
            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;
            dateAxis.renderer.minGridDistance = 30;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

            // Create series
            function createSeries(field, name) {
                var series = chart.series.push(new am4charts.LineSeries());
                series.dataFields.valueY = field;
                series.dataFields.dateX = "tanggal";
                series.name = name;
                series.tooltipText = "{dateX}: [b]{valueY}[/]";
                series.strokeWidth = 2;

                series.smoothing = "monotoneX";

                var bullet = series.bullets.push(new am4charts.CircleBullet());
                bullet.circle.stroke = am4core.color("#fff");
                bullet.circle.strokeWidth = 2;

                return series;
            }

            for (i in bank) {
                createSeries(`value${bank[i].bank_id}`, bank[i].name);
            }


            chart.legend = new am4charts.Legend();
            chart.legend.position = "bottom";
            chart.legend.scrollable = true;
            chart.cursor = new am4charts.XYCursor();

            // Add scrollbar
            chart.scrollbarX = new am4core.Scrollbar();
            chart.scrollbarX.parent = chart.topAxesContainer;
        }

        function createTxType(data) {
            var chart = am4core.create("divTxType", am4charts.PieChart);

            var data = <?= json_encode($data['jenis'], true) ?>;

            // Add data
            // chart.data = [{
            //     "type": "Gaji",
            //     "amount": 50
            // }, {
            //     "type": "Non Gaji",
            //     "amount": 50
            // }];

            chart.data = data;

            // Add and configure Series
            var pieSeries = chart.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "amount";
            pieSeries.dataFields.category = "type";
            pieSeries.innerRadius = am4core.percent(35);
            pieSeries.ticks.template.disabled = true;
            pieSeries.labels.template.disabled = true;

            var rgm = new am4core.RadialGradientModifier();
            rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
            pieSeries.slices.template.fillModifier = rgm;
            pieSeries.slices.template.strokeModifier = rgm;
            pieSeries.slices.template.strokeOpacity = 0.4;
            pieSeries.slices.template.strokeWidth = 0;

            chart.legend = new am4charts.Legend();
            chart.legend.position = "right";
            var markerTemplate = chart.legend.markers.template;
            markerTemplate.width = 12;
            markerTemplate.height = 12;
        }

        function createTxBank(data) {

            // Apply chart themes
            am4core.useTheme(am4themes_animated);

            // Create chart instance
            var chart = am4core.create("divTxBank", am4charts.XYChart3D);

            var data = <?= json_encode($data['bank'], true) ?>;
            console.log(data, "bank");

            // Add data
            {{-- chart.data = [
                {
                    "country": "Lithuania",
                    "litres": 501.9,
                    "units": 250
                },
                {
                    "country": "Czech Republic",
                    "litres": 301.9,
                    "units": 222
                },
                {
                    "country": "Ireland",
                    "litres": 201.1,
                    "units": 170
                },
                {
                    "country": "Germany",
                    "litres": 165.8,
                    "units": 122
                },
                {
                    "country": "Australia",
                    "litres": 139.9,
                    "units": 99
                },
                {
                    "country": "Austria",
                    "litres": 128.3,
                    "units": 85
                },
                {
                    "country": "UK",
                    "litres": 99,
                    "units": 93
                },
                {
                    "country": "Belgium",
                    "litres": 60,
                    "units": 50
                },
                {
                    "country": "The Netherlands",
                    "litres": 50,
                    "units": 42
                }
            ]; --}}

            chart.data = data;

            // Create axes
            let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.width = 10
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.labels.template.rotation = 270;
            categoryAxis.renderer.labels.template.hideOversized = false;
            categoryAxis.renderer.minGridDistance = 20;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.tooltip.label.rotation = 270;
            categoryAxis.tooltip.label.horizontalCenter = "right";
            categoryAxis.tooltip.label.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.disabled = true;

            let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.title.text = "Bank";
            valueAxis.title.fontWeight = "bold";

            // Create series
            var series = chart.series.push(new am4charts.ColumnSeries3D());
            series.dataFields.valueY = "value";
            series.dataFields.categoryX = "name";
            series.name = "Value";
            series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
            series.columns.template.fillOpacity = .8;
            series.columns.template.width = 80
            var columnTemplate = series.columns.template;
            columnTemplate.strokeWidth = 2;
            columnTemplate.strokeOpacity = 1;
            columnTemplate.stroke = am4core.color("#FFFFFF");

            columnTemplate.adapter.add("fill", function(fill, target) {
                return chart.colors.getIndex(target.dataItem.index);
            })

            columnTemplate.adapter.add("stroke", function(stroke, target) {
                return chart.colors.getIndex(target.dataItem.index);
            })

            chart.cursor = new am4charts.XYCursor();
            chart.cursor.lineX.strokeOpacity = 0;
            chart.cursor.lineY.strokeOpacity = 0;

        }

        function createTxStatus(data) {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end
            var data = <?= json_encode($data['status'], true) ?>;
            console.log(data, "stack");
            // Create chart instance
            var chart = am4core.create("divTxStatus", am4charts.XYChart);
            let obj = {
                year: ""
            }
            data.forEach(e => {
                obj = {
                    ...obj,
                    [e.keterangan]: e.value
                }
            })
            console.log(obj, 'obj')
            // Add data
            chart.data = [obj]

            chart.legend = new am4charts.Legend();
            chart.legend.position = "right";
            var markerTemplate = chart.legend.markers.template;
            markerTemplate.width = 12;
            markerTemplate.height = 12;
            // Create axes
            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "year";
            categoryAxis.renderer.grid.template.opacity = 0;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;
            valueAxis.renderer.grid.template.opacity = 0;
            valueAxis.renderer.ticks.template.strokeOpacity = 0.5;
            valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
            valueAxis.renderer.ticks.template.length = 10;
            valueAxis.renderer.line.strokeOpacity = 0.5;
            valueAxis.renderer.baseGrid.disabled = true;
            valueAxis.renderer.minGridDistance = 40;

            // Create series
            function createSeries(field, name) {
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueX = field;
                series.dataFields.categoryY = "year";
                series.columns.template.height = 50
                series.stacked = true;
                series.name = name;

                var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                labelBullet.locationX = 0.5;
                labelBullet.label.text = "{valueX}";
                labelBullet.label.fill = am4core.color("#fff");
            }
            for (const property in obj) {
                if (property != "year") createSeries(property, property)
            }
            // obj(e => {
            // })

        }
        // function createTxStatus(data) {
        //     // Themes begin
        //     am4core.useTheme(am4themes_animated);
        //     // Themes end

        //     var chart = am4core.create("divTxStatus", am4charts.PieChart3D);
        //     var data = <?= json_encode($data['status'], true) ?>;
        //     console.log(data, "status");


        //     {{-- chart.data = [
        //         {
        //             country: "Lithuania",
        //             litres: 501.9
        //         },
        //         {
        //             country: "Czech Republic",
        //             litres: 301.9
        //         },
        //         {
        //             country: "Ireland",
        //             litres: 201.1
        //         },
        //         {
        //             country: "Germany",
        //             litres: 165.8
        //         },
        //         {
        //             country: "Australia",
        //             litres: 139.9
        //         },
        //         {
        //             country: "Austria",
        //             litres: 128.3
        //         },
        //         {
        //             country: "UK",
        //             litres: 99
        //         },
        //         {
        //             country: "Belgium",
        //             litres: 60
        //         },
        //         {
        //             country: "The Netherlands",
        //             litres: 50
        //         }
        //     ]; --}}

        //     chart.data = data;

        //     chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

        //     chart.legend = new am4charts.Legend();
        //     chart.legend.position = "right";
        //     var markerTemplate = chart.legend.markers.template;
        //     markerTemplate.width = 12;
        //     markerTemplate.height = 12;
        //     chart.innerRadius = 25;

        //     var series = chart.series.push(new am4charts.PieSeries3D());
        //     series.dataFields.value = "value";
        //     series.dataFields.category = "keterangan";
        //     series.labels.template.disabled = true;

        // }

        $(document).ready(function() {
            createTxDailyChart(null);
            createTxType(null);
            createTxBank(null);
            createTxStatus(null);
            // $('#lastOverBooking').DataTable();
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
