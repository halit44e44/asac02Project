<div class="card card-custom" xmlns="http://www.w3.org/1999/html">
    <!--begin::Header-->

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
                <a class="nav-link active" href="{{ url('backend/pro/modal/' ~ id) }}">Modal Ayarları</a>
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
                                    <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Modal</h6>
                                    <button type="button" class="btn btn-primary" data-toggle="popover" data-html="true" data-content="Önerilen minumum genişlik<span class='label label-inline font-weight-bold label-light-primary'>545<code>PX</code></span>.">?
                                    </button>
                                </div>

                                <form class="dropzone dropzone-default dropzone-primary photoupload5">
                                    <input type="hidden" class="lastid" name="id" value="{{ themes5.id }}"/>
                                    <input type="hidden" class="table" name="table" value="theme_content/modal"/>
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
                            <div id="uploadedphotos5">
                                {% if images5 is defined %}
                                    {% for image5 in images5 %}
                                    <div class="card card-custom gutter-b" id="image_{{ image5.id }}">
                                        <i class="fa fa-check cardi dn" id="cardi_{{ image5.id }}"></i>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 mr-7">
                                                    <div class="symbol symbol-50 symbol-lg-120">
                                                        <img src="media/{{ image5.meta_key }}/{{ image5.meta_value }}"
                                                             style="object-fit: cover;"/>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <form id="form_{{ image5.id }}">
                                                        <input type="hidden" class="lastid" name="id"
                                                               value="{{ image5.id }}"/>
                                                        <input type="hidden" name="extension"
                                                               value="<?php echo explode(" .",
                                                        $image5->getMetaValue())[1]; ?>" />
                                                        <div class="d-flex align-items-center flex-wrap justify-content-between row">
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label>Dosya ismi</label>
                                                                    <input type="text" class="form-control" name="name"
                                                                           value="<?php echo explode(" .",
                                                                    $image5->getMetaValue())[0]; ?>" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Sıra</label>
                                                                    <input type="number" class="form-control" name="row" value="{{ image5.row }}" min="1" autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="checkbox">
                                                                    {% if image5.showcase == 1 %}
                                                                        <input type="checkbox" name="showcase" value="1" data-image="media/{{ image5.meta_key }}/{{ image5.meta_value }}" checked="true">
                                                                    {% else %}
                                                                        <input type="checkbox" name="showcase" value="0" data-image="media/{{ image5.meta_key }}/{{ image5.meta_value }}">
                                                                    {% endif %}
                                                                    <span class="mr-3"></span>Ön tanımlı görsel
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <button type="button" onclick="removeImage(this)"
                                                                        data-id="{{ image5.id }}"
                                                                        class="btn btn-light-danger mr-2">Kaldır
                                                                </button>
                                                                <button type="button" class="btn btn-light-primary mr-2"
                                                                        data-id="{{ image5.id }}"
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

            <form id="modalForm" method="post">
                <input type="hidden" name="param" value="modal_ayarları"/>
                <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>
                <div class="form-group row">
                    <label class="col-lg-2 col-form-label text-right">Yönlendirme URL'si:</label>
                    <div class="col-lg-9">
                        <input type="text" name="yonlendirme_url" class="form-control form-control-solid" value="{% if yonlendirme_url is defined %}{% if yonlendirme_url.status == "1" %}{{ yonlendirme_url.value }} {% endif %}{% endif %}">
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

    if ($('form.photoupload5').length) {
        const photoUpload = new Dropzone('form.photoupload5', {
            url: "{{ url('backend/upload/set') }}",
            uploadMultiple: true,
            autoProcessQueue: true,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            maxFiles: 1,
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
                $('#uploadedphotos5').html(response);
                changePreviewImage();
            }
        });
    }

    function changePreviewImage() {
        $('input[name=showcase]').on('click', function () {
            var image5 = $(this).data("image5");

            if ($(".fix-sidebar-image").attr("src") == "/media/system/resimyok.png") {
                $(".fix-sidebar-image").attr("src", image5);
            } else {
                $(".fix-sidebar-image").attr("src", "/media/system/resimyok.png");
            }
        });
    }
</script>