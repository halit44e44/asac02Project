<div class="card card-custom">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">SEO Ayarları
                <span class="d-block text-muted pt-2 font-size-sm">Sistemin genel SEO ayarlarını yapılandırın.</span>
            </h3>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a class="nav-link active arama_motorlari_servisleri" data-toggle="tab" href="#arama_motorlari_servisleri">Arama Motoru Servisleri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  anasayfa" data-toggle="tab" href="#anasayfa">Anasayfa </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  cats_tab" data-toggle="tab" href="#cats_tab">Kategori </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  brand_tab" data-toggle="tab" href="#brand_tab">Marka </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  content_tab" data-toggle="tab" href="#content_tab">İçerik </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  contentcats_tab" data-toggle="tab" href="#contentcats_tab">İçerik Kategorileri </a>
                </li>


            </ul>
        </div>
    </div>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">
        <div class="tab-content">

            <div class="tab-pane fade show active" id="arama_motorlari_servisleri" role="tabpanel">
                <form id="metaForm" method="post">
                    <input type="hidden" name="param" value="sitemap" />
                    <button type="button" onclick="sitemap(this)" class="btn btn-primary btn-sm mb-4">Sitemap Oluştur</button>

                    <div class="sitemap_area">
                        {% if sitemap_links is defined %}{{ sitemap_links }}{% endif %}
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <select class="form-control select changetags" id="kt_select2_4" name="tracking_code">
                                    <option value="meta_tags">Meta tag ile site doğrulama</option>
                                    <option value="google_analytics">Google Analytics &amp; Remarketing kodu</option>
                                    <option value="google_order">Google Sipariş Takip Kodu</option>
                                    {#<option value="cart_tracking_code">Sepet Takip Kodu</option>#}
                                    {#<option value="product_tracking_code">Ürün Takip Kodu</option>#}
                                    {#<option value="home_tracking_code">Anasayfa Takip Kodu</option>#}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="meta_tags_div">
                        <div class="input-group">
                            <div class="col-lg-12" >
                                <textarea id="meta_tags" class="codemirror-textarea" name="meta_tags">{% if meta_tag is defined %}{{ meta_tag }}{% endif %}</textarea>
                            </div>
                        </div>
                    </div>
                    <div id="google_analytics_div" class="form-group row dn">
                        <div class="input-group">
                            <div class="col-lg-12" >
                                <textarea id="google_analytics" class="codemirror-textarea" name="meta_google_analytics">{% if google_analytics is defined %}{{ google_analytics }}{% endif %}</textarea>
                            </div>
                        </div>
                    </div>
                    <div id="google_order_div" class="form-group row dn">
                        <div class="input-group">
                            <div class="col-lg-12" >
                                <textarea id="google_order" class="codemirror-textarea" name="meta_google_order">{% if google_order is defined %}{{ google_order }}{% endif %}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row dn" id="cart_tracking_code_div">
                        <div class="input-group">
                            <div class="col-lg-12" >
                                <textarea id="cart_tracking_code" class="codemirror-textarea" name="meta_cart_tracking_code">{% if cart_tracking_code is defined %}{{ cart_tracking_code }}{% endif %}</textarea>
                            </div>
                        </div>
                    </div>
                    <div id="product_tracking_code_div" class="form-group row dn">
                        <div class="input-group">
                            <div class="col-lg-12" >
                                <textarea id="product_tracking_code" class="codemirror-textarea" name="meta_product_tracking_code">{% if home_tracking_code is defined %}{{ home_tracking_code }}{% endif %}</textarea>
                            </div>
                        </div>
                    </div>
                    <div id="home_tracking_code_div" class="form-group row dn">
                        <div class="input-group">
                            <div class="col-lg-12" >
                                <textarea id="home_tracking_code" class="codemirror-textarea" name="meta_home_tracking_code">{% if product_tracking_code is defined %}{{ product_tracking_code }}{% endif %}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="metaPost">Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="anasayfa" role="tabpanel">
                <form id="homeForm" method="post">
                    <input type="hidden" name="param" value="seo_home" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Anasayfa Başlığı:</label>
                            <input type="text" id="anasayfa_title" name="anasayfa_title" value="{%if seo_home['title'] is defined %}{{seo_home['title']}}{% endif %}" class="form-control" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Anasayfa Anahtar Kelime:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input id="etiket" class="form-control tagify" name='anasayfa_keyword' placeholder='etiketleri yazınız...' value="{% if seo_home['keyword'] is defined %}{{ seo_home['keyword']}} {% endif %}"  />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-13">
                            <label class="font-weight-bold">Anasayfa Açıklamaları : </label>
                            <textarea class="form-control" name="anasayfa_description">{% if seo_home['description'] is defined %}{{seo_home['description']}} {% endif %}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="tab-pane fade" id="cats_tab" role="tabpanel">
                <form id="catsForm" method="post">
                    <input type="hidden" name="param" value="seo_cats" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Kategori Başlığı:</label>
                            <input type="text"name="kategori_title" class="form-control" value="{% if seo_cats['title'] is defined %}{{seo_cats['title'] }}{% endif %}"/>
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Kategori Anahtar Kelime:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input id="kategori_etiket" class="form-control tagify" name='kategori_keyword' placeholder='etiketleri yazınız...' value="{% if seo_cats['keyword'] is defined %}{{ seo_cats['keyword']}} {% endif %}"  />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-13">
                            <label class="font-weight-bold">Kategori Açıklamaları : </label>
                            <textarea class="form-control" name="kategori_description">{% if seo_cats['description'] is defined %}{{ seo_cats['description'] }} {% endif %}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="tab-pane fade" id="brand_tab" role="tabpanel">
                <form id="brandForm" method="post">
                    <input type="hidden" name="param" value="seo_brand" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Marka Başlığı:</label>
                            <input type="text" id="brand_title" name="marka_title" class="form-control" value="{% if seo_brand['title'] is defined %}{{ seo_brand['title'] }} {% endif %}" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Marka Anahtar Kelime:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input id="marka_etiket" class="form-control tagify" name='marka_keyword' placeholder='etiketleri yazınız...' value="{% if seo_brand['keyword'] is defined %}{{ seo_brand['keyword']}} {% endif %}"  />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-13">
                            <label class="font-weight-bold">Marka Açıklamaları : </label>
                            <textarea class="form-control" name="marka_description">{% if seo_brand['description'] is defined %}{{ seo_brand['description'] }} {% endif %}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="tab-pane fade" id="content_tab" role="tabpanel">
                <form id="contentForm" method="post">
                    <input type="hidden" name="param" value="seo_content" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">İçerik Başlığı:</label>
                            <input type="text" id="content_title" name="icerik_title" class="form-control" value="{% if seo_content['title'] is defined %}{{ seo_content['title'] }} {% endif %}"/>
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">İçerik Anahtar Kelime:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input id="icerik_etiket" class="form-control tagify" name='icerik_keyword' placeholder='etiketleri yazınız...' value="{% if seo_content['keyword'] is defined %}{{ seo_content['keyword']}} {% endif %}"  />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-13">
                            <label class="font-weight-bold">İçerik Açıklamaları : </label>
                            <textarea class="form-control" name="icerik_description">{% if seo_content['description'] is defined %}{{ seo_content['description'] }} {% endif %}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm" id="">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="tab-pane fade" id="contentcats_tab" role="tabpanel">
                <form id="contentcatsForm" method="post">
                    <input type="hidden" name="param" value="seo_contentcat" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">İçerik Kategori Başlığı:</label>
                            <input type="text" id="contentcats_title" name="icerikkat_title" class="form-control" value="{% if seo_contentcat['title'] is defined %}{{ seo_contentcat['title'] }} {% endif %}" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">İçerik Kategori Anahtar Kelime:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input id="icerikkategori_etiket" class="form-control tagify" name='icerikkat_keyword' placeholder='etiketleri yazınız...' value="{% if seo_contentcat['keyword'] is defined %}{{ seo_contentcat['keyword']}} {% endif %}"  />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-13">
                            <label class="font-weight-bold">İçerik Kategori Açıklamaları : </label>
                            <textarea class="form-control" name="icerikkat_description">{% if seo_contentcat['description'] is defined %}{{ seo_contentcat['description'] }} {% endif %}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm" id="">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        new Tagify(document.getElementById('kategori_etiket'));
        new Tagify(document.getElementById('marka_etiket'));
        new Tagify(document.getElementById('icerik_etiket'));
        new Tagify(document.getElementById('icerikkategori_etiket'));

        $('#metaPost').click(function () {
            const meta_tag_value = meta_tag_val.getValue();
            const google_analytics_value = google_analytics_val.getValue();
            const google_order_value = google_order_val.getValue();
            const cart_tracking_code_value = cart_tracking_code_val.getValue();
            const home_tracking_code_value = home_tracking_code_val.getValue();
            const product_tracking_code_vaLue = product_tracking_code_vaL.getValue();

            const data = 'param=sitemap&meta_tags='+meta_tag_value+'&meta_google_analytics='+google_analytics_value+'&meta_google_order='+google_order_value+'&meta_cart_tracking_code='+cart_tracking_code_value+'&meta_product_tracking_code='+product_tracking_code_vaLue+'&meta_home_tracking_code='+home_tracking_code_value;

            $('.alert').addClass('dn');
            $.ajax({
                type: 'post',
                url: '{{ url("backend/setting/update/") }}',
                data: data,
                success: function (response) {
                    if (response === 'ok') {
                        $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                    } else {
                        $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                    }
                    goTop();
                }
            });
        });

        $('.changetags').on('change', function () {
            const val = $(this).val();
            cleanOptions();
            $('#'+val+'_div').removeClass('dn');
            $('#'+val).trigger('click');
        });

        $('#homeForm').validate({
            rules: {
                anasayfa_title: "required",
                anasayfa_keyword: "required",
                anasayfa_description: "required"
            },
            messages: {
                anasayfa_title: "Anasayfa başlığını yazınız",
                anasayfa_keyword: "Anasayfa anahtar kelimerlirini yazınız!",
                anasayfa_description:"Anasayfa açıklamasını yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#homeForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                    }
                });
            }
        });

        $('#catsForm').validate({
            rules: {
                kategori_title: "required",
                kategori_keyword: "required",
                kategori_description: "required"
            },
            messages: {
                kategori_title: "Kategori başlığını yazınız",
                kategori_keyword: "Kategori anahtar kelimerlirini yazınız!",
                kategori_description:"Kategori açıklamasını yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#catsForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                    }
                });
            }
        });

        $('#brandForm').validate({
            rules: {
                marka_title: "required",
                marka_keyword: "required",
                marka_description: "required"
            },
            messages: {
                marka_title: "Marka başlığını yazınız",
                marka_keyword: "Marka anahtar kelimerlirini yazınız!",
                marka_description:"Marka açıklamasını yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#brandForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                    }
                });
            }
        });

        $('#contentForm').validate({
            rules: {
                icerik_title: "required",
                icerik_keyword: "required",
                icerik_description: "required"
            },
            messages: {
                icerik_title: "İçerik başlığını yazınız",
                icerik_keyword: "İçerik anahtar kelimerlirini yazınız!",
                icerik_description:"İçerik açıklamasını yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#contentForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                    }
                });
            }
        });

        $('#contentcatsForm').validate({
            rules: {
                icerikkat_title: "required",
                icerikkat_keyword: "required",
                icerikkat_description: "required"
            },
            messages: {
                icerikkat_title: "İçerik kategoriler başlığını yazınız",
                icerikkat_keyword: "İçerik kategoriler anahtar kelimerlirini yazınız!",
                icerikkat_description:"İçerik kategoriler açıklamasını yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#contentcatsForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                    }
                });
            }
        });

    });
</script>

<script>
    const meta_tag_val = CodeMirror.fromTextArea(document.getElementById("meta_tags"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode:  "javascript",
        theme:"base16-dark"
    });
    const google_analytics_val = CodeMirror.fromTextArea(document.getElementById("google_analytics"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode:  "javascript",
        theme:"base16-dark"
    });
    const google_order_val = CodeMirror.fromTextArea(document.getElementById("google_order"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode:  "javascript",
        theme:"base16-dark"
    });
    const cart_tracking_code_val = CodeMirror.fromTextArea(document.getElementById("cart_tracking_code"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode:  "javascript",
        theme:"base16-dark"
    });
    const home_tracking_code_val = CodeMirror.fromTextArea(document.getElementById("home_tracking_code"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode:  "javascript",
        theme:"base16-dark"
    });
    const product_tracking_code_vaL = CodeMirror.fromTextArea(document.getElementById("product_tracking_code"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        value: "function myScript(){return 100;}",
        mode:  "javascript",
        theme:"base16-dark"
    });

    function cleanOptions() {
        $('#meta_tags_div').addClass('dn');
        $('#google_analytics_div').addClass('dn');
        $('#google_order_div').addClass('dn');
        $('#cart_tracking_code_div').addClass('dn');
        $('#product_tracking_code_div').addClass('dn');
        $('#home_tracking_code_div').addClass('dn');
    }

    function sitemap() {
        $.get(base_url + 'setting/sitemaps').done(function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.status === "ok") {
                $('.sitemap_area').html('');
                $('.sitemap_area').removeClass('dn').append('<p class="bg-light text-dark py-2 px-4"><a href="{{ url('sitemap/sitemap-product.xml') }}">sitemap-product.xml</a></p>');
                setTimeout(function () {
                    $('.sitemap_area').removeClass('dn').append('<p class="bg-light text-dark py-2 px-4"><a href="{{ url('sitemap/sitemap-cats.xml') }}">sitemap-cats.xml</a></p>');
                },1000)
                setTimeout(function () {
                    $('.sitemap_area').removeClass('dn').append('<p class="bg-light text-dark py-2 px-4"><a href="{{ url('sitemap/sitemap-brand.xml') }}">sitemap-brand.xml</a></p>');
                },2000)
                setTimeout(function () {
                    $('.sitemap_area').removeClass('dn').append('<p class="bg-light text-dark py-2 px-4"><a href="{{ url('sitemap/sitemap-contentcats.xml') }}">sitemap-contentcats.xml</a></p>');
                },3000)
                setTimeout(function () {
                    $('.sitemap_area').removeClass('dn').append('<p class="bg-light text-dark py-2 px-4"><a href="{{ url('sitemap/sitemap-content.xml') }}">sitemap-content.xml</a></p>');
                },4000)
            }
            else {
                $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
            }
        });
    }
</script>