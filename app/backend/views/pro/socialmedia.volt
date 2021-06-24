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
                <a class="nav-link" href="{{ url('backend/pro/footer/' ~ id) }}">Footer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('backend/pro/socialmedia/' ~ id) }}">Sosyal Ağlar</a>
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
        <div class="tab-pane" id="sosyal_aglar" role="tabpanel">
            <form id="footerForm" method="post">
                <input type="hidden" name="param" value="sosyal_aglar"/>
                <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>


                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Sosyal Ağlar Başlığı:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="sosyal_aglar_basligi"
                               value="{% if sosyal_aglar_basligi is defined  %}{% if sosyal_aglar_basligi.status == "1" %}{{ sosyal_aglar_basligi.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Bu alan boş bırakıldığında başlık gözükmeyecektir.">
                        ?
                    </button>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Facebook Adresi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="facebook_adres"
                               value="{% if facebook_adres is defined  %}{% if facebook_adres.status == "1" %}{{ facebook_adres.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Bu alan boş bırakıldığında<span class='label label-inline font-weight-bold label-light-primary'><code>X</code>İCON</span> Gözükmeyecektir.">
                        ?
                    </button>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Twitter Adresi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="twitter_adres"
                               value="{% if twitter_adres is defined  %}{% if twitter_adres.status == "1" %}{{ twitter_adres.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Bu alan boş bırakıldığında<span class='label label-inline font-weight-bold label-light-primary'><code>X</code>İCON</span> Gözükmeyecektir.">
                        ?
                    </button>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Pinterest Adresi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="pinterest_adres"
                               value="{% if pinterest_adres is defined  %}{% if pinterest_adres.status == "1" %}{{ pinterest_adres.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Bu alan boş bırakıldığında<span class='label label-inline font-weight-bold label-light-primary'><code>X</code>İCON</span> Gözükmeyecektir.">
                        ?
                    </button>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Youtube Adresi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="youtube_adres"
                               value="{% if youtube_adres is defined  %}{% if youtube_adres.status == "1" %}{{ youtube_adres.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Bu alan boş bırakıldığında<span class='label label-inline font-weight-bold label-light-primary'><code>X</code>İCON</span> Gözükmeyecektir.">
                        ?
                    </button>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Instagram Adresi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="instagram_adres"
                               value="{% if instagram_adres is defined  %}{% if instagram_adres.status == "1" %}{{ instagram_adres.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Bu alan boş bırakıldığında<span class='label label-inline font-weight-bold label-light-primary'><code>X</code>İCON</span> Gözükmeyecektir.">
                        ?
                    </button>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Linkedin Adresi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="linkedin_adres"
                               value="{% if linkedin_adres is defined  %}{% if linkedin_adres.status == "1" %}{{ linkedin_adres.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Bu alan boş bırakıldığında<span class='label label-inline font-weight-bold label-light-primary'><code>X</code>İCON</span> Gözükmeyecektir.">
                        ?
                    </button>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Whatsapp Numarası:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="whatsapp_numara"
                               value="{% if whatsapp_numara is defined  %}{% if whatsapp_numara.status == "1" %}{{ whatsapp_numara.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Rakamları Arasına Boşluk Bırakmayınız ve Numaranın Başına '0' Yazınız<span class='label label-inline font-weight-bold label-light-primary'><code>Örn:</code>05554443322</span>">
                        ?
                    </button>
                </div>

                <hr>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Hemen Ara:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="text" class="form-control form-control-solid" name="hemen_ara"
                               value="{% if hemen_ara is defined  %}{% if hemen_ara.status == "1" %}{{ hemen_ara.value }}{% endif %}{% endif %}">
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                            data-content="Rakamları Arasına Boşluk Bırakmayınız ve Numaranın Başına '0' Yazınız<span class='label label-inline font-weight-bold label-light-primary'><code>Örn:</code>05554443322</span>">
                        ?
                    </button>
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