<div id="divTxBank" style="height: 100%"></div>
<script>
    // Apply chart themes
    am4core.useTheme(am4themes_animated);

    // Create chart instance
    var chart = am4core.create("divTxBank", am4charts.XYChart3D);

    var data = <?= json_encode($data, true) ?>;
    // console.log(data, "bank");

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
</script>
