<div class="card card-custom" xmlns="http://www.w3.org/1999/html">
    <!--begin::Header-->

    <div class="card-header card-header-tabs-line">
        <ul class="nav nav-dark nav-bold nav-tabs nav-tabs-line" data-remember-tab="tab_id" role="tablist">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/genelayar/' ~ id) }}">Genel
                    Ayarlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/renk/' ~ id) }}">Renk Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('backend/pro/top/' ~ id) }}">Üst Alan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/footer/' ~ id) }}">Footer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/socialmedia/' ~ id) }}">Sosyal Ağlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/manset/' ~ id) }}">Manşet Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/modal/' ~ id) }}">Modal Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/menu/' ~ id) }}">Menü Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/fatura/' ~ id) }}">Fatura Ayarları</a>
            </li>
        </ul>
    </div>
    <style>
        .draggable {
            width: 90px;
            height: 80px;
            padding: 5px;
            float: left;
            margin: 0 10px 10px 0;
            font-size: .9em;
            background: red;
        }

        .ui-widget-header p, .ui-widget-content p {
            margin: 0;
        }

        #snaptarget {
            height: 400px;
            width: 1240px;
            background: aquamarine;
        }
    </style>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">

        <div class="tab-pane" id="footer" role="tabpanel">
            <form id="footerForm" method="post">
                <input type="hidden" name="param" value="top"/>
                <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>

                <!--FATURA BAŞLAR -->
                <div id="snaptarget" class="ui-widget-header">
                    <p>FATURA AYARI</p>
                </div>

                <br style="clear:both">
                <?php
                    for($i = 0; $i<4; $i++){
                ?>
                <div id="draggable_<?php echo $i ?>" class="draggable ui-widget-content">
                    <p>20 x 20</p>
                </div>
                <?php } ?>

                <!--FATURA BİTER-->


            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    $(function () {
        $("#draggable").draggable({snap: true});
        for (var i = 0; i<4; i++) {
            $("#draggable_"+i).draggable({grid: [20, 20]});
        }
        });

    function back() {
        history.back();
    }

</script>