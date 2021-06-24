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
                <a class="nav-link" href="{{ url('backend/pro/top/' ~ id) }}">İçerik</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('backend/pro/footer/' ~ id) }}">Footer</a>
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
                <input type="hidden" name="param" value="footer"/>
                <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>

                <!--<div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Bülten Başlığı:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="bulten_basligi"
                               value="{% if bulten_basligi is defined %}{% if bulten_basligi.status == "1" %}{{ bulten_basligi.value }}{% endif %}{% endif %}">
                    </div>
                </div>-->

                <div class="form-group row">
                    <label class="col-lg-12 col-form-label">Footer Alanı:</label>
                    <div class="col-lg-12 col-xl-12">
                            <textarea id="footer_manu" class="codemirror-textarea" name="footer_manu">{% if footer_manu is defined %}{% if footer_manu.status == "1" %}{{ footer_manu.value }}{% endif %}{% endif %}</textarea>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-lg-12 col-form-label">Copyright Yazısı:</label>
                    <div class="col-lg-12 col-xl-12">
                        <input type="text" class="form-control form-control-solid" name="copyright_yazisi"
                               value="{% if copyright_yazisi is defined %}{% if copyright_yazisi.status == "1" %}{{ copyright_yazisi.value }}{% endif %}{% endif %}">
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

    CodeMirror.fromTextArea(document.getElementById("footer_manu"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode: "javascript",
        theme: "base16-dark"
    });
</script>