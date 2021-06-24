<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css"/>
<style>
    #chart_pro .amcharts-amexport-menu-level-0.amcharts-amexport-top {top:-75px !important;}
</style>
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                Aylık ciro verileri
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div id="chart_pro" style="height: 500px;"></div>
    </div>
</div>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/rangeSelector.js"></script>
<script src="//www.amcharts.com/lib/4/lang/tr_TR.js"></script>

<script>
    am4core.ready(function() {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create("chart_pro", am4charts.XYChart);
        chart.dataSource.url = "api/v3/get/pro";
        chart.dataSource.parser = new am4core.CSVParser();
        chart.dataSource.parser.options.useColumnNames = true;
        chart.language.locale = am4lang_tr_TR;
        chart.dataSource.parser.options.reverse = true;
        chart.leftAxesContainer.layout = "vertical";

// Export
        chart.exporting.menu = new am4core.ExportMenu();

// Data for both series


        /* Create axes */
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "moon";
        categoryAxis.renderer.minGridDistance = 30;

        /* Create value axis */
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        /* Create series */
        var columnSeries = chart.series.push(new am4charts.ColumnSeries());
        columnSeries.name = "Ciro";
        columnSeries.dataFields.valueY = "price";
        columnSeries.dataFields.categoryX = "moon";

        columnSeries.columns.template.tooltipText = "[#fff font-size: 15px] {categoryX} ayı {name} Rakamları:\n[/][#fff font-size: 20px]{valueY}[/] ₺ [#fff]{additional}[/]"
        columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
        columnSeries.columns.template.propertyFields.stroke = "stroke";
        columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
        columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
        columnSeries.tooltip.label.textAlign = "middle";

        var lineSeries = chart.series.push(new am4charts.LineSeries());
        lineSeries.name = "Satılan Ürün";
        lineSeries.dataFields.valueY = "piece";
        lineSeries.dataFields.categoryX = "moon";

        lineSeries.stroke = am4core.color("#fdd400");
        lineSeries.strokeWidth = 3;
        lineSeries.propertyFields.strokeDasharray = "lineDash";
        lineSeries.tooltip.label.textAlign = "middle";

        var bullet = lineSeries.bullets.push(new am4charts.Bullet());
        bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
        bullet.tooltipText = "[#fff font-size: 15px]{categoryX} ayında {name}  :\n[/][#fff font-size: 20px]{valueY}[/] [#fff]{additional}[/]"
        var circle = bullet.createChild(am4core.Circle);
        circle.radius = 4;
        circle.fill = am4core.color("#fff");
        circle.strokeWidth = 3;

        chart.data = data;


    }); // end am4core.ready()
</script>