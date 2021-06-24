<div class="card card-custom">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">Diğer Ayarlar
                <span class="d-block text-muted pt-2 font-size-sm">Ve bir çok ayarlar ile sitenizi yapılandırın.</span>
            </h3>
        </div>
    </div>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">
        <div class="tab-content">

            <!--#puan ayarları başlar-->
            <div class="tab-pane fade show active" id="puan_ayarlari" role="tabpanel">

                <form id="otherSettingsForm" method="post">
                    <input type="hidden" name="param" value="point" />
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="font-weight-bold">Kaç TL üzeri alışverişlerde kargo ücretsiz olsun</label>
                            <input type="number" id="cargo" name="cargo" {% if cargo.value is defined %}value="{{ cargo.value }}"{% endif %} class="form-control" min="0" />
                            <span class="form-text text-muted">Kullanmak istemiyorsanız boş bırakınız.</span>
                        </div>
                        <div class="col-lg-1">

                        </div>

                        <div class="col-lg-5">
                            <label class="font-weight-bold">Üyeliklerde TC Kimlik numarası zorunluluk durumu</label>
                            <div class="d-flex align-items-center">

                                <select class="form-control" name="tc">
                                    <option{% if tc.value is defined%} {% if tc.value=="1"%} selected {% endif %} {% endif %} value="1">Aktif</option>
                                    <option{% if tc.value is defined%} {% if tc.value=="2"%} selected {% endif %} {% endif %} value="2">Pasif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1">

                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="font-weight-bold">Kur bilgisi</label>
                            <div class="d-flex align-items-center">

                                <select class="form-control" name="currency">
                                    <option{% if currency.value=="TL"%} selected {% endif %} value="TL">TL</option>
                                    <option{% if currency.value=="USD"%} selected {% endif %} value="USD">USD</option>
                                    <option {% if currency.value=="EURO"%} selected {% endif %}value="EURO">EURO</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-lg-1">

                        </div>
                        <div class="col-lg-5">
                            <label class="font-weight-bold">Kaç güne kadar sipariş iptal veya iada edilebilir</label>
                            <input type="number" id="order" name="order" {% if order.value is defined %}value="{{ order.value }}"{% endif %} class="form-control" min="0" />

                        </div>
                        <div class="col-lg-1">

                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="font-weight-bold">Hediye çekine dönüştürülen puanlar kaç gün kullanılabilir</label>
                            <input type="number" id="voucher" name="voucher" {% if voucher.value is defined %}value="{{ voucher.value }}"{% endif %} class="form-control" min="0" />

                        </div>
                        <div class="col-lg-1">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                        </div>
                    </div>
                </form>

            </div>
            <!--#puan ayarları biter-->

        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $('#otherSettingsForm').validate({
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#otherSettingsForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/otherSettings/") }}',
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
