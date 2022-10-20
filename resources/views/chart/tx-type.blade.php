<div id="divTxType" style="height: 100%"></div>
<script>
    var chart = am4core.create("divTxType", am4charts.PieChart);
    var data = <?= json_encode($data, true) ?>;
    // Add data
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

    pieSeries.slices.template.events.on("hit", function(ev) {
        localStorage.setItem("tx-type", ev.target.dataItem.category);
        window.location.href = '/history-overbooking'
    }, this)
    
    chart.legend = new am4charts.Legend();
    chart.legend.position = "right";
    var markerTemplate = chart.legend.markers.template;
    markerTemplate.width = 12;
    markerTemplate.height = 12;
</script>
