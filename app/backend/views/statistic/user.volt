<style>
    #chartdiv { width: 100%; height: 500px; }
    #users_chart .amcharts-amexport-menu-level-0.amcharts-amexport-top {top:-90px !important;}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/rangeSelector.js"></script>
<script src="//www.amcharts.com/lib/4/lang/tr_TR.js"></script>
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                En çok sipariş veren kullanıcılar
            </h3>
        </div>
    </div>


    <div class="card-body">
        <div id="user_chart" style="height: 500px;"></div>
    </div>
</div>
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                Tarih tabanlı kullanıcı analizi
            </h3>
        </div>
    </div>


    <div class="card-body">
        <div id="controls"></div>
        <div id="users_chart" style="height: 500px;"></div>
    </div>
</div>
<script>
    am4core.ready(function() {
        am4core.useTheme(am4themes_animated);
        var chart = am4core.create("user_chart", am4charts.XYChart);
        chart.scrollbarX = new am4core.Scrollbar();
        chart.dataSource.url = "api/v3/get/user";
        chart.dataSource.parser = new am4core.CSVParser();
        chart.dataSource.parser.options.useColumnNames = true;
        chart.dataSource.parser.options.reverse = true;
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "Name";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.renderer.labels.template.horizontalCenter = "right";
        categoryAxis.renderer.labels.template.verticalCenter = "middle";
        categoryAxis.renderer.labels.template.rotation = 270;
        categoryAxis.tooltip.disabled = true;
        categoryAxis.renderer.minHeight = 110;
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.minWidth = 50;
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.sequencedInterpolation = true;
        series.dataFields.valueY = "Count";
        series.dataFields.categoryX = "Name";
        series.tooltipText = "[{categoryX}: bold]{valueY}[/] Sipariş";
        series.columns.template.strokeWidth = 0;
        series.tooltip.pointerOrientation = "horizontal";
        series.columns.template.column.cornerRadiusTopLeft = 10;
        series.columns.template.column.cornerRadiusTopRight = 10;
        series.columns.template.column.fillOpacity = 0.8;
        var hoverState = series.columns.template.column.states.create("hover");
        hoverState.properties.cornerRadiusTopLeft = 0;
        hoverState.properties.cornerRadiusTopRight = 0;
        hoverState.properties.fillOpacity = 1;
        series.columns.template.adapter.add("fill", function(fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
        });
        chart.cursor = new am4charts.XYCursor();

    }); // end am4core.ready()
</script>




<script>
    am4core.ready(function() {

// Themes begin
        am4core.useTheme(am4themes_animated);

        var chart = am4core.create("users_chart", am4charts.XYChart);
        chart.dataSource.url = "api/v3/get/users";
        chart.dataSource.parser = new am4core.CSVParser();
        chart.dataSource.parser.options.useColumnNames = true;
        chart.language.locale = am4lang_tr_TR;
        chart.dataSource.parser.options.reverse = true;
        chart.leftAxesContainer.layout = "vertical";
// Create axes

        chart.exporting.menu = new am4core.ExportMenu();

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 50;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "Count";
        series.dataFields.dateX = "Date";
        series.strokeWidth = 2;
        series.minBulletDistance = 10;
        series.tooltipText = "[bold]{Date.formatDate()}:[/] {Count} Yeni üye";
        series.tooltip.pointerOrientation = "vertical";

// Create series


// Add cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.xAxis = dateAxis;
        var selector = new am4plugins_rangeSelector.DateAxisRangeSelector();
        selector.container = document.getElementById("controls");
        selector.axis = dateAxis;

    }); // end am4core.ready()
</script>



