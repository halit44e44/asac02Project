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
                <a class="nav-link active" href="{{ url('backend/pro/top/' ~ id) }}">İçerik</a>
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
        </ul>
    </div>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">
        <div class="tab-pane" id="footer" role="tabpanel">
            <form id="footerForm" method="post">
                <input type="hidden" name="param" value="top"/>
                <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>

                <div class="form-group row">
                    <label class="col-lg-12 col-form-label">Üst banner metin alanı:</label>
                    <div class="col-lg-12 col-xl-12">
                        <input type="text" class="form-control form-control-solid" name="top_metin"
                               value="{% if themes.value is defined %}{% if themes.value is not null %}{{ themes.value }}{% endif %}{% endif %}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-12 col-form-label">Çerez Politika Başlığı:</label>
                    <div class="col-lg-12 col-xl-12">
                        <input type="text" class="form-control form-control-solid" name="cerez"
                               value="{% if cerez.value is defined %}{% if cerez.value is not null %}{{ cerez.value }}{% endif %}{% endif %}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 text-left">
                        <input type="button" onclick="window.location.href='{{ url('backend/setting/themes') }}'" class="btn btn-secondary btn-sm" value="Geri Dön">
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary btn-sm">Sadece Kaydet</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>

    function back(){
        history.back();
    }

    CodeMirror.fromTextArea(document.getElementById("footer_manu"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode: "javascript",
        theme: "base16-dark"
    });
</script>