<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
    .fixcolor {
        color: #d4d4d4 !important;
        font-size: 18px !important;
    }

    .dragbaslar {
        border: 2px dashed #e6e6e6;
        padding: 10px;
        height: auto !important;
    }

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .h100 {
        height: 100%;
    }

    .tasi:hover {
        cursor: auto !important;
    }

    .navi {
        padding-right: 12.5px !important;
        padding-left: 12.5px !important;
    }
    ol ol, ul ul, ol ul, ul ol {margin-left: 20px;}
</style>
<div class="card card-custom" xmlns="http://www.w3.org/1999/html">
    <div class="card-header card-header-tabs-line">
        <ul class="nav nav-dark nav-bold nav-tabs nav-tabs-line" data-remember-tab="tab_id" role="tablist">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/genelayar/' ~ id) }}">Genel Ayarlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/renk/' ~ id) }}">Renk Ayarları</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/top/' ~ id) }}">İçerik</a>
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
                <a class="nav-link active" href="{{ url('backend/pro/menu/' ~ id) }}">Menü Ayarları</a>
            </li>

        </ul>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="navi navi-bold navi-hover navi-active navi-link-rounded" id="draggable">
                    <h6 class="text-center mb-10">Tüm Kategoriler</h6>
                    <ul>
                    {% if catlist is defined %}{{ catlist }}{% endif %}
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-12 navi navi-bold navi-hover navi-active navi-link-rounded">
                <h6 class="text-center mb-10">Üst Menü</h6>
                <div id="headerwidget" class="h100" data-theme="{% if id is defined %}{{ id }}{% endif %}">
                    {% if menuHeader is defined %}
                        {% for menuHeader in menuHeader %}
                            <?php
                            $header_name = \Yabasi\Cats::findFirst('id = ' . $menuHeader->getCatsId());
                            if ($header_name) {
                            $name = $header_name->getName(); ?>
                            <div class="navi-item mb-2 headerthen menu_{{ menuHeader.id }}" id="row_{{ menuHeader.cats_id }}" data-eid="{{ menuHeader.cats_id }}" data-trans="{{ menuHeader.row_number }}">
                                <a href="javascript:;" class="navi-link py-4 active">
                                    <span class="navi-icon mr-2"><i class="icon-xl fas fa-arrows-alt fixcolor"></i></span>
                                    <span class="navi-text font-size-lg ">{{ name }}</span>
                                    <i class="icon-md fas fa-times text-danger removeMenu" data-id="{{ menuHeader.id }}"></i>
                                </a>
                            </div>
                            <?php
                                }
                            ?>
                        {% endfor %}
                    {% endif %}
                </div>
            </div>
            <div class="col-lg-4 col-12 navi navi-bold navi-hover navi-active navi-link-rounded">
                <h6 class="text-center mb-10">Alt Menü</h6>
                <div id="footerwidget" class="h100" data-theme="{% if id is defined %}{{ id }}{% endif %}">

                    {% if menuFooter is defined %}
                        {% for menuFooter in menuFooter %}
                            <?php
                            $footer_name = \Yabasi\Cats::findFirst('id = ' . $menuFooter->getCatsId());
                            if ($footer_name) {
                            $name = $footer_name->getName(); ?>
                            <div class="navi-item mb-2 footerthen" id="row_{{ menuFooter.cats_id }}" data-eid="{{ menuFooter.cats_id }}" data-trans="{{ menuFooter.row_number }}">
                                <a href="javascript:;" class="navi-link py-4 active">
                                    <span class="navi-icon mr-2"><i class="icon-xl fas fa-arrows-alt fixcolor"></i></span>
                                    <span class="navi-text font-size-lg ">{{ name }}</span>
                                </a>
                            </div>
                            <?php
                                }
                            ?>
                        {% endfor %}
                    {% endif %}

                </div>
            </div>


        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

    $(document).ready(function () {

        $('.removeMenu').click(function () {
            const id = $(this).data('id');
            $.ajax({
                type: "post",
                url: 'backend/pro/removemenu',
                data: 'id='+id,
                success: function (response) {
                    if (response === "ok") {
                        $('.menu_'+id).remove();
                    }
                }
            });
        });

        $("#headerwidget, #footerwidget").sortable();
        $("#headerwidget, #footerwidget").disableSelection();

        $(".tasi").draggable({
            containment: "#container",
            helper: 'clone',
            revert: 'invalid',
        });

        $("#headerwidget").droppable({
            hoverClass: 'dragbaslar',
            accept: ":not(.ui-sortable-helper)",
            drop: function (ev, ui) {
                $(ui.draggable).clone().appendTo(this);
                $(this).children().each(function (index) {
                    if ($(this).attr('data-trans') != (index + 1)) {
                        $(this).attr('data-trans', (index + 1)).addClass('updated');
                    }
                    $('#headerwidget .removeMenu').removeClass('dn');
                });
                saveHeaderMenu(1);
            }
        });

        $("#footerwidget").droppable({
            hoverClass: 'dragbaslar',
            accept: ":not(.ui-sortable-helper)",
            drop: function (ev, ui) {
                $(ui.draggable).clone().appendTo(this);
                $(this).children().each(function (index) {
                    if ($(this).attr('data-trans') != (index + 1)) {
                        $(this).attr('data-trans', (index + 1)).addClass('updated');
                    }
                });
                saveHeaderMenu(2);
            }
        });

    });

    $(function () {

        var header = $('#headerwidget');
        var footer = $('#footerwidget');

        if (header) {
            header.sortable({
                opacity: 0.6,
                cursor: "move",
                update: function () {

                    saveHeaderMenu(1);

                    $(this).children().each(function (index) {
                        if ($(this).attr('data-trans') != (index + 1)) {
                            $(this).attr('data-trans', (index + 1)).addClass('updated');
                        }
                    });
                }
            });
        }

        if (footer) {
            footer.sortable({
                opacity: 0.6,
                cursor: "move",
                update: function () {

                    var sortableData = $('#footerwidget').sortable('serialize');
                    var theme_id = $('#footerwidget').data("theme");
                    var which = 2;
                    $.ajax({
                        type: "post",
                        url: 'backend/pro/menusave/' + theme_id + '/' + which,
                        data: sortableData,
                        success: function (response) {
                            if (response === "ok") {
                            }
                        }
                    });

                    $(this).children().each(function (index) {
                        if ($(this).attr('data-trans') != (index + 1)) {
                            $(this).attr('data-trans', (index + 1)).addClass('updated');
                        }
                    });
                }
            });
        }

    });


    function saveHeaderMenu(which) {
        var sortableData = $('#headerwidget').sortable('serialize');
        const theme_id = $('#headerwidget').data("theme");
        $.ajax({
            type: "post",
            url: 'backend/pro/menusave/' + theme_id + '/' + which,
            data: sortableData,
            success: function (response) {
                if (response === "ok") {
                }
            }
        });
    }


</script>
