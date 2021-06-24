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
                <a class="nav-link active" href="{{ url('backend/pro/manset/' ~ id) }}">Manşet Ayarları</a>
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

        <div class="tab-pane" id="tema_slider" role="tabpanel">
            <form id="sliderForm" method="post">
                <input type="hidden" name="param" value="tema_slider"/>
                <input type="hidden" name="id" value="{% if id is defined %}{{ id }}{% endif %}"/>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Geçiş Tipi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <select class="form-control" name="gecis_tipi">
                            {% if gecis_tipi is defined %}
                                <option value="slide" {% if gecis_tipi.value === "slide" %}selected{% endif %}>Kayma Efekti</option>
                                <option value="fade" {% if gecis_tipi.value === "fade" %}selected{% endif %}>Solma Efekti</option>
                                <option value="cube" {% if gecis_tipi.value === "cube" %}selected{% endif %}>Küp Efekti</option>
                                <option value="coverflow" {% if gecis_tipi.value === "coverflow" %}selected{% endif %}>Kapak Akışı Efekti</option>
                                <option value="flip" {% if gecis_tipi.value === "flip" %}selected{% endif %}>Çevirme Efekti</option>
                            {% else %}
                                <option value="slide">Kayma Efekti</option>
                                <option value="fade">Kaybolma Efekti</option>
                                <option value="cube">Küp Efekti</option>
                                <option value="coverflow">Kapak Akışı Efekti</option>
                                <option value="flip">Çevirme Efekti</option>
                            {% endif %}
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Resmin Değişme Süresi:</label>
                    <div class="col-lg-6 col-xl-4">
                        <input type="number" class="form-control form-control-solid" name="resim_degisme_suresi"
                               value="{% if resim_degisme_suresi is defined %}{% if resim_degisme_suresi.status == "1" %}{{ resim_degisme_suresi.value }}{% endif %}{% endif %}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Mini Slider Butonları Gösterimi:</label>
                    <div class="col-lg-9 col-xl-4">
                        <input type="hidden" name="ileri_geri_button_gosterim"
                               value="false">
                        <span class="switch switch-icon">
                                <label>
                                    <input type="checkbox"
                                           name="ileri_geri_button_gosterim"
                                           {% if ileri_geri_button_gosterim is defined %}{% if ileri_geri_button_gosterim.value=="on" %}checked{% endif %} aria-disabled="false"{% endif %}>
                                    <span></span>
                                </label>
                            </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-lg-3 col-form-label text-lg-right">Mini Slider Çerçeve Rengi</label>
                    <div class="input-group-addon">
                        <input name="minislider_cerceve_rengi" type="text" id="hex11" maxlength="7"
                               value="{% if minislider_cerceve_rengi is defined %}{% if minislider_cerceve_rengi.status == "1" %}{{ minislider_cerceve_rengi.value }}{% endif %}{% endif %}"/>
                        <input type="color" id="color11"/>
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
    let color11Input = document.querySelector('#color11');
    let hex11Input = document.querySelector('#hex11');

    color11Input.addEventListener('input', () => {
        let color11 = color11Input.value;
        hex11Input.value = color11;
    });


    $(document).ready(function () {

        $('.selectClass').select2({
            placeholder: "Lütfen seçim yapınız"
        });

        /* genel ayarlar tab post */
        $('#sliderForm').validate({
            rules: {
                gecis_tipi: "required",
                slider_baslik_boyutu: "required",
                slider_metin_boyutu: "required",
                slider_button_boyutu: "required",
                slider_button_tipi: "required"
            },
            messages: {
                gecis_tipi: "Lütfen ülke seçimi yapınız!",
                slider_baslik_boyutu: "Lütfen İl seçimi yapınız!",
                slider_metin_boyutu: "Lütfen ilçe seçimi yazınız!",
                slider_button_boyutu: "Lütfen adres alanını doldurunuz!",
                slider_button_tipi: "Lütfen adres alanını doldurunuz!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#sliderForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/pro/slider/") }}',
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
