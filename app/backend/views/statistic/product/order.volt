<link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css"/>
<style>
    #chart_pro .amcharts-amexport-menu-level-0.amcharts-amexport-top {top:-75px !important;}
    #chart_products .amcharts-amexport-menu-level-0.amcharts-amexport-top {top: -107px !important;}
</style>
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                Ürün tabanlı sipariş verileri
            </h3>
        </div>
        <div class="col-8 form-group mb-8 pt-6 mr-15">
            <select onchange="pro(this)" class="form-control form-control-solid form-control-lg " data-live-search="true"  name="product" id="product">
                <option value="0">Ürün seçiniz</option>
                {% if pro is defined %}
                    {% for pro in pro %}
                        <option  {% if list is defined %}{% if list.id==pro.id %} selected {% endif %} {% endif %}value="{{ pro.id }}">{{ pro.name }}</option>
                    {% endfor %}
                {% endif %}
            </select>
        </div>
    </div>
    <div class="card-body">
        <div id="controls"></div>
        <div id="chart_products" style="height: 500px;"></div>
    </div>

</div>

<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/rangeSelector.js"></script>
<script src="//www.amcharts.com/lib/4/lang/tr_TR.js"></script>

<script>
    function pro(el) {
        var e = document.getElementById("product");
        var status = e.options[e.selectedIndex].value;

        products(status);
    }
    products();
    function products(id=false){
        am4core.ready(function() {
            var chart = am4core.create("chart_products", am4charts.XYChart);
            if (id){
                chart.dataSource.url = "api/v3/get/products/"+id;
            }
            else {
                chart.dataSource.url = "api/v3/get/products";
            }
            am4core.useTheme(am4themes_animated);
            chart.padding(0, 15, 0, 15);
            chart.exporting.menu = new am4core.ExportMenu();
            chart.dataSource.parser = new am4core.CSVParser();
            chart.dataSource.parser.options.useColumnNames = true;
            chart.dataSource.parser.options.reverse = true;
            chart.language.locale = am4lang_tr_TR;
// the following line makes value axes to be arranged vertically.
            chart.leftAxesContainer.layout = "vertical";

// uncomment this line if you want to change order of axes
//chart.bottomAxesContainer.reverseOrder = true;

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
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "piece";
            series.tooltipText = "Satış Adeti :{valueY.value}";

            series.defaultState.transitionDuration = 0;

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
            series2.dataFields.dateX = "date";
            series2.dataFields.valueY = "price";
            series2.yAxis = valueAxis2;
            series2.tooltipText = "Ciro : {valueY.value}";

// volume should be summed
            series2.groupFields.valueY = "sum";
            series2.defaultState.transitionDuration = 0;

            chart.cursor = new am4charts.XYCursor();

            var scrollbarX = new am4charts.XYChartScrollbar();
            scrollbarX.series.push(series);
            scrollbarX.marginBottom = 20;
            scrollbarX.scrollbarChart.xAxes.getIndex(0).minHeight = undefined;
            chart.scrollbarX = scrollbarX;

            if (!id){
                var selector = new am4plugins_rangeSelector.DateAxisRangeSelector();
                selector.container = document.getElementById("controls");
                selector.axis = dateAxis;
            }


        });
    }

</script>