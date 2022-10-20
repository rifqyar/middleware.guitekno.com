<div id="divTxDaily" style="height: 100%"></div>
<script>
    am4core.useTheme(am4themes_animated);
    var chart = am4core.create("divTxDaily", am4charts.XYChart);
    var data = <?= json_encode($transaksi, true) ?>;
    console.log(data.trx[5].data, 'ddd')
    let chartData = []
    for (i in data.trx) {
        // console.log(i, 'i')
        var tempData = {
            tanggal: data.trx[i].tanggal
        }
        for (j in data.trx[i].data) {
            var valueName = `value${data.trx[i].data[j].bank_name}`
            // console.log(valueName, 'value')
            tempData[valueName] = data.trx[i].data[j].total
        }
        console.log(tempData, 'ooo')
        chartData.push(tempData);
    }
    // console.log(chartData, 'result')
    // Add data
    chart.data = chartData;
    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    dateAxis.renderer.grid.template.location = 0;
    dateAxis.renderer.minGridDistance = 30;
    var value = chart.yAxes.push(new am4charts.ValueAxis());

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

    data.bank.forEach((e) => {
        createSeries(`value${e}`, e);
    })
    chart.legend = new am4charts.Legend();
    chart.legend.position = "bottom";
    chart.legend.scrollable = true;
    chart.cursor = new am4charts.XYCursor();
    // Add scrollbar
    chart.scrollbarX = new am4core.Scrollbar();
    chart.scrollbarX.parent = chart.topAxesContainer;
</script>
