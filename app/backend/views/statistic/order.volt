<link href="//www.amcharts.com/lib/4/plugins/export/export.css" rel="stylesheet" type="text/css"/>

<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                Akıllı Sipariş İstatistikleri
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div id="controls"></div>
        <div id="order_chart" style="height: 500px;"></div>
    </div>
</div>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/rangeSelector.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/kelly.js"></script>
<script src="//www.amcharts.com/lib/4/lang/tr_TR.js"></script>


    <script>
        am4core.ready(function() {
            am4core.useTheme(am4themes_animated);
            am4core.useTheme(am4themes_kelly);
            var chart = am4core.create("order_chart", am4charts.XYChart);
            chart.padding(0, 15, 0, 15);
            chart.dataSource.url = "api/v3/get/order";
            chart.dataSource.parser = new am4core.CSVParser();
            chart.language.locale = am4lang_tr_TR;
            chart.dataSource.parser.options.useColumnNames = true;
            chart.dataSource.parser.options.reverse = true;
            chart.leftAxesContainer.layout = "vertical";
            chart.exporting.menu = new am4core.ExportMenu();

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;
            dateAxis.renderer.ticks.template.length = 8;
            dateAxis.renderer.ticks.template.strokeOpacity = 0.1;
            dateAxis.renderer.grid.template.disabled = true;
            dateAxis.renderer.ticks.template.disabled = false;
            dateAxis.renderer.ticks.template.strokeOpacity = 0.2;
            dateAxis.renderer.minLabelPosition = 0.01;
            dateAxis.renderer.maxLabelPosition = 0.99;
            dateAxis.keepSelection = true;
            dateAxis.minHeight = 30;

            dateAxis.groupData = true;
            dateAxis.minZoomCount = 5;

            // these two lines makes the axis to be initially zoomed-in
            // dateAxis.start = 0.7;
            // dateAxis.keepSelection = true;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.zIndex = 1;
            valueAxis.renderer.baseGrid.disabled = true;
            // height of axis
            valueAxis.height = am4core.percent(65);

            valueAxis.renderer.gridContainer.background.fill = am4core.color("#000000");
            valueAxis.renderer.gridContainer.background.fillOpacity = 0.05;
            valueAxis.renderer.inside = true;
            valueAxis.renderer.labels.template.verticalCenter = "bottom";
            valueAxis.renderer.labels.template.padding(2, 2, 2, 2);

            //valueAxis.renderer.maxLabelPosition = 0.95;
            valueAxis.renderer.fontSize = "0.8em"

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "Date";
            series.dataFields.valueY = "Open";
            series.tooltipText = "{valueY.value}";
            series.tooltip.getFillFromObject = false;
            series.tooltip.getStrokeFromObject = true;
            series.tooltipText = "{name}: {valueY.value.formatNumber('[#0c0]+#|[#c00]#.##|0')}";
            series.name = "Onaylanan Sipariş";
            series.defaultState.transitionDuration = 0;
            series.tooltip.background.fill = am4core.color("#fff");
            series.tooltip.background.strokeWidth = 2;
            series.tooltip.label.fill = series.stroke;
            var series1 = chart.series.push(new am4charts.LineSeries());
            series1.dataFields.dateX = "Date";
            series1.dataFields.valueY = "High";
            series1.tooltipText = "{valueY.value}";
            series1.tooltip.getFillFromObject = false;
            series1.tooltip.getStrokeFromObject = true;
            series1.tooltipText = "{name}: {valueY.value.formatNumber('[#0c0]#|[#c00]#.##|0')}";
            series1.name = "Toplam Sipariş";
            series1.defaultState.transitionDuration = 0;
            series1.tooltip.background.fill = am4core.color("#fff");
            series1.tooltip.background.strokeWidth = 2;
            series1.tooltip.label.fill = series.stroke;

            var series3 = chart.series.push(new am4charts.LineSeries());
            series3.dataFields.dateX = "Date";
            series3.dataFields.valueY = "Low";
            series3.tooltipText = "{valueY.value}";
            series3.tooltip.getFillFromObject = false;
            series3.tooltip.getStrokeFromObject = true;
            series3.tooltipText = "{name}: {valueY.value.formatNumber('[#0c0]+#|[#c00]#.##|0')}";
            series3.name = "İade Sipariş";
            series3.defaultState.transitionDuration = 0;
            series3.tooltip.background.fill = am4core.color("#fff");
            series3.tooltip.background.strokeWidth = 2;
            series3.tooltip.label.fill = series.stroke;

            var series4 = chart.series.push(new am4charts.LineSeries());
            series4.dataFields.dateX = "Date";
            series4.dataFields.valueY = "Close";
            series4.tooltipText = "{valueY.value}";
            series4.tooltip.getFillFromObject = false;
            series4.tooltip.getStrokeFromObject = true;
            series4.tooltipText = "{name}: {valueY.value.formatNumber('[#0c0]#|[#c00]#.##|0')}";
            series4.name = "İptal Sipariş";
            series4.defaultState.transitionDuration = 0;
            series4.tooltip.background.fill = am4core.color("#fff");
            series4.tooltip.background.strokeWidth = 2;
            series4.tooltip.label.fill = series.stroke;
            var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis2.tooltip.disabled = true;
// height of axis
            valueAxis2.height = am4core.percent(35);
            valueAxis2.zIndex = 3
// this makes gap between panels
            valueAxis2.marginTop = 30;
            valueAxis2.renderer.baseGrid.disabled = true;
            valueAxis2.renderer.inside = true;
            valueAxis2.renderer.labels.template.verticalCenter = "bottom";
            valueAxis2.renderer.labels.template.padding(2, 2, 2, 2);
//valueAxis.renderer.maxLabelPosition = 0.95;
            valueAxis2.renderer.fontSize = "0.8em"

            valueAxis2.renderer.gridContainer.background.fill = am4core.color("#000000");
            valueAxis2.renderer.gridContainer.background.fillOpacity = 0.05;

            var series2 = chart.series.push(new am4charts.ColumnSeries());
            series2.dataFields.dateX = "Date";
            series2.dataFields.valueY = "Volume";
            series2.yAxis = valueAxis2;
            series2.tooltipText = "{valueY.value}";
            series2.name = "MSFT: Volume";
// volume should be summed
            series2.groupFields.valueY = "sum";
            series2.defaultState.transitionDuration = 0;

            chart.cursor = new am4charts.XYCursor();

            var scrollbarX = new am4charts.XYChartScrollbar();
            scrollbarX.series.push(series);
            scrollbarX.marginBottom = 20;
            scrollbarX.scrollbarChart.xAxes.getIndex(0).minHeight = undefined;
            chart.scrollbarX = scrollbarX;


// Add range selector
            var selector = new am4plugins_rangeSelector.DateAxisRangeSelector();
            selector.container = document.getElementById("controls");
            selector.axis = dateAxis;

        }); // end am4core.ready()
    </script>

