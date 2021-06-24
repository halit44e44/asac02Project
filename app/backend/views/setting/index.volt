<div class="card card-custom">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">Lisans Ayarları</h3>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a class="nav-link active lisans_ayarlari" data-toggle="tab" href="#lisans_ayarlari">Lisans Ayarları</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sirket_bilgileri" data-toggle="tab" href="#sirket_bilgileri">Şirket Bilgileri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link vergi_bilgileri" data-toggle="tab" href="#vergi_bilgileri">Vergi Bilgileri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link adres_bilgileri" data-toggle="tab" href="#adres_bilgileri">Adres Bilgileri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mail_ayarlari" data-toggle="tab" href="#mail_ayarlari">Mail Ayarları</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">
        <div class="tab-content">

            <!--#lisans ayarları başlar-->
            <div class="tab-pane fade show active" id="lisans_ayarlari" role="tabpanel">

                <form id="lisansForm" method="post">
                    <input type="hidden" name="param" value="licence" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Site URL:</label>
                            <input type="url" id="site_url" readonly name="site_url" value="{% if site_url is defined %}{{ site_url.value }}{% endif %}" class="form-control" placeholder="https://" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Lisans Numarası:</label>
                            <input type="text" id="licence_number" readonly name="licence_number" value="{% if licence_number is defined %}{{ licence_number.value }}{% endif %}" class="form-control" placeholder="Lisans numarasınızı yazınız" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <!--#lisans ayarları biter-->

            <!--#şirket bilgileri başlar-->
            <div class="tab-pane fade" id="sirket_bilgileri" role="tabpanel">
                <form id="sirketForm" method="post">
                    <input type="hidden" name="param" value="sirket_bilgileri" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Şirket Adı:</label>
                            <input type="text" id="sirket_adi" name="sirket_adi" value="{% if sirket_adi is defined %}{{ sirket_adi.value }}{% endif %}" class="form-control" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Şirket Resmi Adı:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="text" id="sirket_resmi_adi" name="sirket_resmi_adi" value="{% if sirket_resmi_adi is defined %}{{ sirket_resmi_adi.value }}{% endif %}" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Firma Yetkilisi:</label>
                            <input type="text" id="firma_yetkilisi" name="firma_yetkilisi" value="{% if firma_yetkilisi is defined %}{{ firma_yetkilisi.value }}{% endif %}" class="form-control" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Email adresi:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="text" id="sirket_email_adresi" name="sirket_email_adresi" value="{% if sirket_email_adresi is defined %}{{ sirket_email_adresi.value }}{% endif %}" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Telefon Numarası:</label>
                            <input type="text" id="telefon_numarasi" name="telefon_numarasi" value="{% if telefon_numarasi is defined %}{{ telefon_numarasi.value }}{% endif %}" class="form-control" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Fax Numarası:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="text" id="fax_numarasi" name="fax_numarasi" value="{% if fax_numarasi is defined %}{{ fax_numarasi.value }}{% endif %}" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm" id="">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <!--#şirket bilgileri biter-->

            <!--#vergi bilgileri başlar-->
            <div class="tab-pane fade" id="vergi_bilgileri" role="tabpanel">

                <form id="vergiForm" method="post">
                    <input type="hidden" name="param" value="vergi_bilgileri" />
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="font-weight-bold">Vergi Numarası:</label>
                            <input type="text" id="vergi_numarasi" name="vergi_numarasi" value="{% if vergi_numarasi is defined %}{{ vergi_numarasi.value }}{% endif %}" class="form-control" />
                        </div>
                        <div class="col-lg-4">
                            <label class="font-weight-bold">Vergi Dairesi:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="text" id="vergi_dairesi" name="vergi_dairesi" value="{% if vergi_dairesi is defined %}{{ vergi_dairesi.value }}{% endif %}" class="form-control" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="font-weight-bold">Sicil Numarası:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="text" id="sicil_numarasi" name="sicil_numarasi" value="{% if sicil_numarasi is defined %}{{ sicil_numarasi.value }}{% endif %}" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Kep Adresi:</label>
                            <input type="text" id="kep_adresi" name="kep_adresi" value="{% if kep_adresi is defined %}{{ kep_adresi.value }}{% endif %}" class="form-control" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">Mersis Numarası:</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="text" id="mersis_numarasi" name="mersis_numarasi" value="{% if mersis_numarasi is defined %}{{ mersis_numarasi.value }}{% endif %}" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <!--#vergi bilgileri biter-->

            <!--#adres bilgileri başlar-->
            <div class="tab-pane fade" id="adres_bilgileri" role="tabpanel">

                <form id="adresForm" method="post">
                    <input type="hidden" name="param" value="adres_bilgileri" />
                    <div class="form-group row">

                        <div class="col-lg-3">
                            <label class="font-weight-bold">Ülke:</label>
                            <style>.select2 {width:100% !important;}</style>
                            <select class="form-control" name="ulke">
                                {% if countries is defined %}
                                    {% for country in countries %}
                                        <option value="{{ country.CountryID }}" {% if ulke.value is defined %}{% if ulke.value is country.CountryID %}selected{% endif %}{% endif %}>{{ country.CountryName }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <label class="font-weight-bold">Şehir:</label>
                            <select class="form-control" name="il" id="city">
                                {% if cities is defined %}
                                    {% for cities in cities %}
                                        <option value="{{ cities.CityID }}" {% if il.value is defined %}{% if il.value is cities.CityID %}selected{% endif %}{% endif %}>{{ cities.CityName }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <label class="font-weight-bold">İlçe:</label>
                            <select class="form-control" name="ilce" id="town">
                                {% if town is defined %}
                                    {% for town in town %}
                                        <option value="{{ town.TownID }}" {% if ilce.value is defined %}{% if ilce.value is town.TownID %}selected{% endif %}{% endif %}>{{ town.TownName }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <label class="font-weight-bold">Belde:</label>
                            <select class="form-control" name="belde" id="district">
                                {% if districts is defined %}
                                    {% for districts in districts %}
                                        <option value="{{ districts.DistrictID }}" {% if belde.value is defined %}{% if belde.value is districts.DistrictID %}selected{% endif %}{% endif %}>{{ districts.DistrictName }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="col-lg-2">
                            <label class="font-weight-bold">Mahalle:</label>
                            <select class="form-control" name="mahalle" id="neighborhood">
                                {% if neighborhood is defined %}
                                    {% for neighborhood in neighborhood %}
                                        <option value="{{ neighborhood.NeighborhoodID }}" {% if mahalle.value is defined %}{% if mahalle.value is neighborhood.NeighborhoodID %}selected{% endif %}{% endif %}>{{ neighborhood.NeighborhoodName }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                    </div>

                    <script>
                        /* ulke değiş sehir getir */
                        $(' #country').on('change', function () {
                            const id = $(this).val();
                            $.ajax({
                                type: 'post',
                                url: 'backend/user/country',
                                data: 'id='+id,
                                success: function (respond) {
                                    $('#city').html(respond);
                                }
                            });
                        });

                        /* il getir */
                        $('#city').on('change', function () {
                            const id = $(this).val();
                            $.ajax({
                                type: 'post',
                                url: 'backend/user/city',
                                data: 'id='+id,
                                success: function (respond) {
                                    $('#town').html(respond);
                                }
                            });
                        });

                        /* ilce getir */
                        $('#town').on('change', function () {
                            const id = $(this).val();
                            $.ajax({
                                type: 'post',
                                url: 'backend/user/town',
                                data: 'id='+id,
                                success: function (respond) {
                                    $('#district').html(respond);
                                }
                            });
                        });

                        $('#district').on('change', function () {
                            const id = $(this).val();
                            $.ajax({
                                type: 'post',
                                url: 'backend/user/district',
                                data: 'id='+id,
                                success: function (respond) {

                                    $('#neighborhood').html(respond);
                                }
                            });
                        });

                        /* zip getir */
                        $('#neighborhood').on('change', function () {
                            const id = $(this).val();
                            $.ajax({
                                type: 'post',
                                url: 'backend/user/neighborhood',
                                data: 'id='+id,
                                success: function (respond) {
                                }
                            });
                        });


                    </script>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="font-weight-bold">Adres:</label>
                            <textarea class="form-control" name="adres">{% if adres is defined %}{{ adres.value }}{% endif %}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <!--#adres bilgileri biter-->

            <!--#smtp mail başlar-->
            <div class="tab-pane fade" id="mail_ayarlari" role="tabpanel">
                <form id="smtpForm" method="post">
                    <input type="hidden" name="param" value="smtp" />
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">SMTP Sunucu Adresi:</label>
                            <input type="text" id="smtp_sunucu" name="smtp_sunucu" value="{% if smtp_sunucu is defined %}{{ smtp_sunucu.value }}{% endif %}" class="form-control" placeholder="" />
                        </div>
                        <div class="col-lg-3">
                            <label class="font-weight-bold">SMTP Port:</label>
                            <input type="number" id="smtp_port" name="smtp_port" value="{% if smtp_port is defined %}{{ smtp_port.value }}{% endif %}" class="form-control" placeholder="" />
                        </div>
                        <div class="col-lg-3">
                            <label class="font-weight-bold">Gönderim Tipi:</label>
                            <select class="form-control" name="smtp_gonderim_tipi">
                                <option value="tls" {% if smtp_gonderim_tipi is defined %}{% if smtp_gonderim_tipi.value is 'tls' %}selected{% endif %}{% endif %}>TLS</option>
                                <option value="ssl" {% if smtp_gonderim_tipi is defined %}{% if smtp_gonderim_tipi.value is 'ssl' %}selected{% endif %}{% endif %}>SSL</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="font-weight-bold">SMTP Kullanıcı Adı:</label>
                            <input type="text" id="smtp_kullaniciadi" name="smtp_kullaniciadi" value="{% if smtp_kullaniciadi is defined %}{{ smtp_kullaniciadi.value }}{% endif %}" class="form-control" placeholder="" />
                        </div>
                        <div class="col-lg-6">
                            <label class="font-weight-bold">SMTP Şifresi:</label>
                            <input type="password" id="smtp_sifre" name="smtp_sifre" value="{% if smtp_sifre is defined %}{{ smtp_sifre.value }}{% endif %}" class="form-control" placeholder="" />
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--#smtp mail biter-->

        </div>

    </div>
</div>

<script>
    $(document).ready(function() {

        $('.lisans_ayarlari').click(function () {
            $('h3.card-label').html('Lisans Ayarları');
            $('.alert').addClass('dn');
        });

        $('.sirket_bilgileri').click(function () {
            $('h3.card-label').html('Şirket Bilgileri');
            $('.alert').addClass('dn');
        });

        $('.vergi_bilgileri').click(function () {
            $('h3.card-label').html('Vergi Bilgileri');
            $('.alert').addClass('dn');
        });

        $('.adres_bilgileri').click(function () {
            $('h3.card-label').html('Adres Bilgileri');
            $('.alert').addClass('dn');
        });

        $('.mail_ayarlari').click(function () {
            $('h3.card-label').html('Mail Ayarları');
            $('.alert').addClass('dn');
        });

        $('.sozlesmeler').click(function () {
            $('h3.card-label').html('Sözleşmeler');
            $('.alert').addClass('dn');
        });

        /* telefon ve fax input mask */
        $("#telefon_numarasi, #fax_numarasi").inputmask("mask", {
            "mask": "(999) 999-9999"
        });

        $('.selectClass').select2({
            placeholder: "Lütfen seçim yapınız"
        });

        ClassicEditor
            .create( document.querySelector( '.satis_sozlesmesi' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                table: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                language: 'tr',


            } )
            .catch( error => {
                console.log( error );
            } );
        ClassicEditor
            .create( document.querySelector( '.uyelik_sozlesmesi' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                table: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                language: 'tr',


            } )
            .catch( error => {
                console.log( error );
            } );
        ClassicEditor
            .create( document.querySelector( '.iade_ve_iptal' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                table: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                language: 'tr',


            } )
            .catch( error => {
                console.log( error );
            } );
        ClassicEditor
            .create( document.querySelector( '.kisisel_verilerin_korunmasi' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                table: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                language: 'tr',


            } )
            .catch( error => {
                console.log( error );
            } );
        ClassicEditor
            .create( document.querySelector( '.on_bilgilendirme' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                table: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                language: 'tr',


            } )
            .catch( error => {
                console.log( error );
            } );
        ClassicEditor
            .create( document.querySelector( '.alisverissiz_odeme' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                table: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                language: 'tr',


            } )
            .catch( error => {
                console.log( error );
            } );

        /* email adresi mask */
        $("#sirket_email_adresi, #kep_adresi").inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&amp;'*+/=?^_`{|}~\-]",
                    cardinality: 1,
                    casing: "lower"
                }
            }
        });

        /* lisans tab post */
        $('#lisansForm').validate({
            rules: {
                site_url: "required",
                licence_number: "required"
            },
            messages: {
                site_url: "Geçerli bir URL yazınız!",
                licence_number: "Lisans numaranızı yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#lisansForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
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

        /* şirket bilgileri tab post */
        $('#sirketForm').validate({
            rules: {
                sirket_adi: "required",
                sirket_resmi_adi: "required",
                firma_yetkilisi: "required",
                sirket_email_adresi: "required",
                telefon_numarasi: "required"
            },
            messages: {
                sirket_adi: "Şirket adını yazınız!",
                sirket_resmi_adi: "Şirket resmi adını yazınız!",
                firma_yetkilisi: "Firma yetkilisini yazınız!",
                sirket_email_adresi: "Lütfen geçerli bir email adresi yazınız!",
                telefon_numarasi: "Lütfen geçerli bir telefon numarası yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#sirketForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
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

        /* şirket bilgileri tab post */
        $('#vergiForm').validate({
            rules: {
                vergi_numarasi: "required",
                vergi_dairesi: "required",
                sicil_numarasi: "required",
                kep_adresi: "required",
                mersis_numarasi: "required"
            },
            messages: {
                vergi_numarasi: "Vergi numarasını yazınız!",
                vergi_dairesi: "Vergi dairesini yazınız!",
                sicil_numarasi: "Sicil numarasını yazınız!",
                kep_adresi: "Lütfen geçerli bir kep adresi yazınız!",
                mersis_numarasi: "Mersis numarasını yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#vergiForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
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

        /* adres bilgileri tab post */
        $('#adresForm').validate({
            rules: {
                ulke: "required",
                il: "required",
                ilce: "required",
                adres: "required"
            },
            messages: {
                ulke: "Lütfen ülke seçimi yapınız!",
                il: "Lütfen İl seçimi yapınız!",
                ilce: "Lütfen ilçe seçimi yazınız!",
                adres: "Lütfen adres alanını doldurunuz!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#adresForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
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

        /* smtp tab post */
        $('#smtpForm').validate({
            rules: {
                smtp_sunucu: "required",
                smtp_port: "required",
                smtp_kullaniciadi: "required",
                smtp_sifre: "required"
            },
            messages: {
                smtp_sunucu: "Lütfen sunucu adını yazınız!",
                smtp_port: "Lütfen erişim portunu yazınız!",
                smtp_kullaniciadi: "Lütfen smtp mail kullanıcı adını yazınız!",
                smtp_sifre: "Lütfen smtp mail şifresini yazınız!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#smtpForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
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

        /* sozlesme tab post */
        $('#sozlesmeForm').validate({
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#sozlesmeForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/update/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').html('İşlem başarılı bir şekilde tamamlandı!');
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                        goTop();
                    }
                });
            }
        });

    });
</script>