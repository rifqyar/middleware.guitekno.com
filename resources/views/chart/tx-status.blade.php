<div id="divTxStatus"></div>
<script>
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    var data = <?= json_encode($data, true) ?>;
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
    // Add data
    chart.data = [obj]

    chart.legend = new am4charts.Legend();
    chart.legend.position = "right";
    var markerTemplate = chart.legend.markers.template;
    markerTemplate.width = 12;
    markerTemplate.height = 12;
    // Create axes
    var category = chart.yAxes.push(new am4charts.CategoryAxis());
    category.dataFields.category = "year";
    category.renderer.grid.template.opacity = 0;

    var value = chart.xAxes.push(new am4charts.ValueAxis());
    value.min = 0;
    value.renderer.grid.template.opacity = 0;
    value.renderer.ticks.template.strokeOpacity = 0.5;
    value.renderer.ticks.template.stroke = am4core.color("#495C43");
    value.renderer.ticks.template.length = 10;
    value.renderer.line.strokeOpacity = 0.5;
    value.renderer.baseGrid.disabled = true;
    value.renderer.minGridDistance = 40;

    // Create series
    function createSeries(field, name) {
        console.log(name, "name")
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueX = field;
        series.dataFields.categoryY = "year";
        series.columns.template.height = 50
        series.stacked = true;
        series.name = name;

        series.columns.template.tooltipText = "{name}: [bold]{valueX}[/]";

        console.log(field, "field")

        if (field === 'Failed') {
            series.stroke = am4core.color("#fc031c")
            series.fill = am4core.color("#fc031c")
        }

        var labelBullet = series.bullets.push(new am4charts.LabelBullet());
        labelBullet.locationX = 0.5;
        labelBullet.label.text = "{valueX}";
        labelBullet.label.fill = am4core.color("#fff");
    }
    for (const property in obj) {
        if (property != "year") createSeries(property, property)
    }
</script>