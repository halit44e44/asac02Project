

    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css">

    <script type="text/javascript" src="assets/theme7/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="assets/theme7/js/raphael-min.js"></script>
    <script type="text/javascript" src="assets/theme7/js/paths.js"></script>
    <script type="text/javascript" src="assets/theme7/js/turkiye.js"></script>
    <script type="text/javascript" src="assets/theme7/js/jquery.qtip.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#map svg path").hover(
                function() {
                    var id=$(this).attr("id");
                    $("#sehir").text(id);
                });
            $("#map svg path").click(
                function() {
                     const id=$(this).attr("id");
                    $("#sehir").text(id);
                    $.ajax({
                        url: '{{ url("backend/statistic/city/") }}'+id,
                        type:'GET',
                        success:function(result){
                            document.getElementById("city").innerText=id;
                            document.getElementById("statictik").innerText=result;
                        }
                    });
                });
        })
    </script>
    <style type="text/css">
        body{background:#fff;}
        #map{width:1050px;height:620px;position:relative;margin:auto;}
        #map svg {position: relative;top: -100px; left: 0px;}
        svg > a {cursor: pointer;display:block;}

        #sehir{font-size:30px;text-align:center;margin-top:25px;color:#666;}
    </style>

    <div class="col-xl-3">
        <!--begin::Engage Widget 2-->
        <div class="card card-custom card-stretch gutter-b">
            <div class="card-body d-flex p-0">
                <div class="flex-grow-1 bg-danger p-8 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 70%; background-image: url(/metronic/theme/html/demo7/dist/assets/media/svg/humans/custom-3.svg)">
                    <h4 class="text-inverse-danger mt-2 font-weight-bolder" id="city"></h4>
                    <p class="text-inverse-danger my-6" id="statictik"></p>
                </div>
            </div>
        </div>
        <!--end::Engage Widget 2-->
    </div>

<div id="sehir"></div>

<div id="map"></div>


