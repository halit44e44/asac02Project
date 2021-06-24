<div class="card card-custom" xmlns="http://www.w3.org/1999/html">
    <!--begin::Header-->

    <input type="hidden" value="{{ themes.id }}">

    <div class="card-header card-header-tabs-line">
        <ul class="nav nav-dark nav-bold nav-tabs nav-tabs-line" data-remember-tab="tab_id" role="tablist">
            <li class="nav-item">
                <a class="nav-link active genel_ayarlar" href="{{ url('backend/pro/genelayar/' ~ id) }}">Genel
                    Ayarlar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('backend/pro/renk/'~id) }}">Renk Ayarları</a>
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
                <a class="nav-link" href="{{ url('backend/pro/menu/' ~ id) }}">Menü Ayarları</a>
            </li>
        </ul>
    </div>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">


        <div class="tab-pane fade show active" id="genel_ayarlar" role="tabpanel">

            <div class="d-flex flex-column-fluid photoUploadCpnteiner">
                <div class="container padding-right-none">
                    <div class="col-lg-12 col-sm-12 float-right padding-none-m padding-right-none">

                        <div class="card mb-10 dns">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-7">
                                    <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Logo</h6>
                                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                            data-content="Önerilen minumum genişlik<span class='label label-inline font-weight-bold label-light-primary'>545<code>PX</code></span>.">
                                        ?
                                    </button>
                                </div>

                                <form class="dropzone dropzone-default dropzone-primary photoupload1">
                                    <input type="hidden" class="lastid" name="id" value="{{ themes.id }}"/>
                                    <input type="hidden" class="table" name="table" value="theme_content/logo"/>
                                    <div class="dropzone-msg dz-message needsclick">
                                        <h3 class="dropzone-msg-title">Logoyu buraya sürükle veya tıklayarak yükle.</h3>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column-fluid">
                <div class="container padding-right-none">
                    <div class="col-lg-12 col-sm-12 float-right padding-none-m padding-right-none">
                        <div class="mb-10 dns">
                            <div id="uploadedphotos">
                                {% if images is defined %}
                                    {% for image in images %}
                                    <div class="card card-custom gutter-b" id="image_{{ image.id }}">
                                        <i class="fa fa-check cardi dn" id="cardi_{{ image.id }}"></i>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 mr-7">
                                                    <div class="symbol symbol-50 symbol-lg-120">
                                                        <img src="media/{{ image.meta_key }}/{{ image.meta_value }}"
                                                             style="object-fit: cover;"/>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <form id="form_{{ image.id }}">
                                                        <input type="hidden" class="lastid" name="id"
                                                               value="{{ image.id }}"/>
                                                        <input type="hidden" name="extension"
                                                               value="<?php echo explode(" .",
                                                        $image->getMetaValue())[1]; ?>" />
                                                        <div class="d-flex align-items-center flex-wrap justify-content-between row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Dosya ismi</label>
                                                                    <input type="text" class="form-control" name="name"
                                                                           value="<?php echo explode(" .", $image->getMetaValue())[0]; ?>" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 text-right">
                                                                <button type="button" onclick="removeImage(this)"
                                                                        data-id="{{ image.id }}"
                                                                        class="btn btn-light-danger mr-2">Kaldır
                                                                </button>
                                                                <button type="button" class="btn btn-light-primary mr-2"
                                                                        data-id="{{ image.id }}"
                                                                        onclick="updateImage(this)">Kaydet
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {% endfor %}
                                    <script>
                                        $(document).ready(function () {
                                            changePreviewImage();
                                        });
                                    </script>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="d-flex flex-column-fluid photoUploadCpnteiner">
                <div class="container padding-right-none">
                    <div class="col-lg-12 col-sm-12 float-right padding-none-m padding-right-none">

                        <div class="card mb-10 dns">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-7">
                                    <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Footer</h6>
                                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true"
                                            data-content="Önerilen minumum genişlik<span class='label label-inline font-weight-bold label-light-primary'>545<code>PX</code></span>.">
                                        ?
                                    </button>
                                </div>

                                <form class="dropzone dropzone-default dropzone-primary photoupload2">
                                    <input type="hidden" class="lastid" name="id" value="{{ themes2.id }}"/>
                                    <input type="hidden" class="table" name="table" value="theme_content/footer"/>
                                    <div class="dropzone-msg dz-message needsclick">
                                        <h3 class="dropzone-msg-title">Fotoğrafları buraya sürükle veya tıklayarak
                                            yükle.</h3>
                                        <span class="dropzone-msg-desc">Aynı anda 10 fotoğraf yükleyebilirsiniz.</span>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column-fluid">
                <div class="container padding-right-none">
                    <div class="col-lg-12 col-sm-12 float-right padding-none-m padding-right-none">
                        <div class="mb-10 dns">
                            <div id="uploadedphotos2">
                                {% if images2 is defined %}
                                    {% for image2 in images2 %}
                                    <div class="card card-custom gutter-b" id="image_{{ image2.id }}">
                                        <i class="fa fa-check cardi dn" id="cardi_{{ image2.id }}"></i>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 mr-7">
                                                    <div class="symbol symbol-50 symbol-lg-120">
                                                        <img src="media/{{ image2.meta_key }}/{{ image2.meta_value }}"
                                                             style="object-fit: cover;"/>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <form id="form_{{ image2.id }}">
                                                        <input type="hidden" class="lastid" name="id"
                                                               value="{{ image2.id }}"/>
                                                        <input type="hidden" name="extension"
                                                               value="<?php echo explode(" .",
                                                        $image->getMetaValue())[1]; ?>" />
                                                        <div class="d-flex align-items-center flex-wrap justify-content-between row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label>Dosya ismi</label>
                                                                    <input type="text" class="form-control" name="name"
                                                                           value="<?php echo explode(" .",
                                                                    $image->getMetaValue())[0]; ?>" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Sıra</label>
                                                                    <input type="number" class="form-control" name="row"
                                                                           value="{{ image2.row }}" min="1"
                                                                           autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="checkbox">
                                                                    {% if image2.showcase == 1 %}
                                                                        <input type="checkbox" name="showcase" value="1"
                                                                               data-image="media/{{ image2.meta_key }}/{{ image2.meta_value }}"
                                                                               checked="true">
                                                                    {% else %}
                                                                        <input type="checkbox" name="showcase" value="0"
                                                                               data-image="media/{{ image2.meta_key }}/{{ image2.meta_value }}">
                                                                    {% endif %}
                                                                    <span class="mr-3"></span>
                                                                    Ön tanımlı görsel
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <button type="button" onclick="removeImage(this)"
                                                                        data-id="{{ image2.id }}"
                                                                        class="btn btn-light-danger mr-2">Kaldır
                                                                </button>
                                                                <button type="button" class="btn btn-light-primary mr-2"
                                                                        data-id="{{ image2.id }}"
                                                                        onclick="updateImage(this)">Kaydet
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {% endfor %}
                                    <script>
                                        $(document).ready(function () {
                                            changePreviewImage();
                                        });
                                    </script>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="genelAyarForm" method="post">
                <input type="hidden" name="param" value="genel_ayarlar"/>
                <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>


                <!--<div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Varyantlı Ürün Fiyat Gösterim Tipi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <select class="form-control select2 selectClass" name="urun_fiyat_gosterim_tipi">
                            {% if urun_fiyat_gosterim_tipi is defined %}
                            <option value="1" {% if urun_fiyat_gosterim_tipi.value == 1 %}selected{% endif %}>Sadece Seçenek Adı</option>
                            <option value="2" {% if urun_fiyat_gosterim_tipi.value == 2 %}selected{% endif %}>KDV dahil</option>
                            <option value="3" {% if urun_fiyat_gosterim_tipi.value == 3 %}selected{% endif %}>Fiyat+KDV
                                {% else %}
                                    <option value="1">Sadece Seçenek Adı</option>
                                    <option value="2">KDV dahil</option>
                                    <option value="3">Fiyat+KDV</option>
                            {% endif %}
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Marka Gösterim Tipi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <select class="form-control select2 selectClass" name="marka_gosterim_tipi">
                            {% if marka_gosterim_tipi is defined %}
                            <option value="1" {% if marka_gosterim_tipi.value == 1 %}selected{% endif %}>İsim</option>
                            <option value="2" {% if marka_gosterim_tipi.value == 2 %}selected{% endif %}>Marka Logosu</option>
                                {% else %}
                                    <option value="1">İsim</option>
                                    <option value="2">Marka Logosu</option>
                            {% endif %}
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Vitrinde 1 Satırdaki Ürün
                        Adedi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <select class="form-control select2 selectClass" name="vitrin_bir_satir_urun_adedi">
                            {% if vitrin_bir_satir_urun_adedi is defined %}
                            <option value="1" {% if vitrin_bir_satir_urun_adedi.value == 1 %}selected{% endif %}>2</option>
                            <option value="2" {% if vitrin_bir_satir_urun_adedi.value == 2 %}selected{% endif %}>3</option>
                            <option value="3" {% if vitrin_bir_satir_urun_adedi.value == 3 %}selected{% endif %}>4</option>
                            <option value="4" {% if vitrin_bir_satir_urun_adedi.value == 4 %}selected{% endif %}>5</option>
                                {% else %}
                                    <option value="1">2</option>
                                    <option value="2">3</option>
                                    <option value="3">4</option>
                                    <option value="4">5</option>
                            {% endif %}
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Kategorilerin Detayda Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="kategori_detay_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="kategori_detay_gosterim"
                                            {% if kategori_detay_gosterim is defined %}{% if kategori_detay_gosterim.value=="on" %} checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>-->

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Markaların Detayda Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="marka_detay_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="marka_detay_gosterim"
                                           {% if marka_detay_gosterim is defined %} {% if marka_detay_gosterim.value=="on" %} checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Kategori Breadcrumb Kullanımı:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="kategori_breadcrumb_kullanim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="kategori_breadcrumb_kullanim"
                                           {% if kategori_breadcrumb_kullanim is defined %}{% if kategori_breadcrumb_kullanim.value=="on" %} checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>

                </div>

                <!--<div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Sipariş aşamalarında KDV
                        Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="siparis_asama_kdv_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="siparis_asama_kdv_gosterim"
                                          {% if siparis_asama_kdv_gosterim is defined %} {% if siparis_asama_kdv_gosterim.value=="on" %}checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>-->


                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Stok Kodlarının Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="stok_kod_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="stok_kod_gosterim"
                                           {% if stok_kod_gosterim is defined %}{% if stok_kod_gosterim.value=="on" %}checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>

                <!--<div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">KDV Hariç Fiyat Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="kdv_haric_fiyat_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="kdv_haric_fiyat_gosterim"
                                           {% if kdv_haric_fiyat_gosterim is defined %}{% if kdv_haric_fiyat_gosterim.value=="on" %}checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">En Düşük Taksit Miktarı
                        Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="en_dusuk_taksit_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="en_dusuk_taksit_gosterim"
                                           {% if en_dusuk_taksit_gosterim is defined %}{% if en_dusuk_taksit_gosterim.value=="on" %}checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Ürün Detayda Ürün Özelliklerinin
                        Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="urun_detay_urun_ozellikleri_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="urun_detay_urun_ozellikleri_gosterim"
                                           {% if urun_detay_urun_ozellikleri_gosterim is defined %}{% if urun_detay_urun_ozellikleri_gosterim.value=="on" %}checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>-->


                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Paylaşım Linkleri Kullanımı:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="paylasim_link_kullanimi"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="paylasim_link_kullanimi"
                                           {% if paylasim_link_kullanimi is defined %}{% if paylasim_link_kullanimi.value=="on" %}checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Anasayfa Ürün Uzunluk Boyutu:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="anasayfa_height" value="false">
                        <input type="text" name="anasayfa_height" class="form-control col-3" placeholder="350px" value="{% if anasayfa_height is defined %}{{ anasayfa_height.value }}{% endif %}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Diğer Sayfalar Ürün Uzunluk Boyutu:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="diger_height" value="false">
                        <input type="text" name="diger_height" class="form-control col-3" placeholder="350px" value="{% if diger_height is defined %}{{ diger_height.value }}{% endif %}">
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

    if ($('form.photoupload1').length) {
        const photoUpload = new Dropzone('form.photoupload1', {
            url: "{{ url('backend/upload/set') }}",
            uploadMultiple: true,
            autoProcessQueue: true,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            maxFiles: 10,
            maxFilesize: 5000,
            thumbnailWidth: 222,
            thumbnailHeight: 222,
            accept: function (file, done) {
                if (file.size > 5242880) {
                    done('Dosya boyutu çok yüksek!');
                } else {
                    if (file.status === 'error') {
                        done('Görsel yüklenemedi!');
                    } else {
                        done();
                    }
                }
            },
            thumbnail: function (file, dataUrl) {
                if ($(".fix-sidebar-image").attr("src") == "/media/system/resimyok.png") {
                    $(".fix-sidebar-image").attr("src", dataUrl);
                }
            },
            success: function (file, response) {
                $('#uploadedphotos').html(response);
                changePreviewImage();
            }
        });
    }

    function changePreviewImage() {
        $('input[name=showcase]').on('click', function () {
            var image = $(this).data("image");

            if ($(".fix-sidebar-image").attr("src") == "/media/system/resimyok.png") {
                $(".fix-sidebar-image").attr("src", image);
            } else {
                $(".fix-sidebar-image").attr("src", "/media/system/resimyok.png");
            }
        });
    }

    if ($('form.photoupload2').length) {
        const photoUpload = new Dropzone('form.photoupload2', {
            url: "{{ url('backend/upload/set') }}",
            uploadMultiple: true,
            autoProcessQueue: true,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            maxFiles: 10,
            maxFilesize: 5000,
            thumbnailWidth: 222,
            thumbnailHeight: 222,
            accept: function (file, done) {
                if (file.size > 5242880) {
                    done('Dosya boyutu çok yüksek!');
                } else {
                    if (file.status === 'error') {
                        done('Görsel yüklenemedi!');
                    } else {
                        done();
                    }
                }
            },
            thumbnail: function (file, dataUrl) {
                if ($(".fix-sidebar-image").attr("src") == "/media/product/resimyok.jpg") {
                    $(".fix-sidebar-image").attr("src", dataUrl);
                }
            },
            success: function (file, response) {
                $('#uploadedphotos2').html(response);
                changePreviewImage2();
            }
        });
    }

    function changePreviewImage2() {
        $('input[name=showcase]').on('click', function () {
            var image2 = $(this).data("image2");

            if ($(".fix-sidebar-image").attr("src") == "/media/system/resimyok.png") {
                $(".fix-sidebar-image").attr("src", image2);
            } else {
                $(".fix-sidebar-image").attr("src", "/media/system/resimyok.png");
            }
        });
    }


    $(document).ready(function () {

        $('.genel_ayarlar').click(function () {
            $('h3.card-label').html('Genel Ayarlar');
            $('.alert').addClass('dn');
        });


        $('.selectClass').select2({
            placeholder: "Lütfen seçim yapınız"
        });


        /* genel ayarlar tab post */
        $('#genelAyarForm').validate({
            rules: {
                urun_gosterim_tipi: "required",
                urun_fiyat_gosterim_tipi: "required",
                marka_gosterim_tipi: "required",
                vitrin_bir_satir_urun_adedi: "required",
                bir_satir_blog_yazi_adedi: "required",
                urun_adet_secim_tipi: "required"
            },
            messages: {
                urun_gosterim_tipi: "Lütfen ülke seçimi yapınız!",
                urun_fiyat_gosterim_tipi: "Lütfen İl seçimi yapınız!",
                marka_gosterim_tipi: "Lütfen ilçe seçimi yazınız!",
                vitrin_bir_satir_urun_adedi: "Lütfen adres alanını doldurunuz!",
                bir_satir_blog_yazi_adedi: "Lütfen adres alanını doldurunuz!",
                urun_adet_secim_tipi: "Lütfen adres alanını doldurunuz!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#genelAyarForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/pro/genelayar/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').html('İşlem başarılı bir şekilde tamamlandı!');
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                    }
                });
            }
        });

    });
</script>
