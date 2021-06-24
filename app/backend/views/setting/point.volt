<div class="card card-custom">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">Puan Ayarları
                <span class="d-block text-muted pt-2 font-size-sm">Puan sistemi için değerleri tanımlayın.</span>
            </h3>
        </div>
    </div>

    <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

    <div class="card-body">
        <div class="tab-content">

            <!--#puan ayarları başlar-->
            <div class="tab-pane fade show active" id="puan_ayarlari" role="tabpanel">

                <form id="pointForm" method="post">
                    <input type="hidden" name="param" value="point" />

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label class="font-weight-bold">1 TL karşılığı puan:</label>
                            <input type="number" id="point" name="point" value="{% if point is defined %}{{ point }}{% else %}1000{% endif %}" min="1" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="font-weight-bold">Yorum</label>
                            <input type="number" id="comment_point" name="comment_point" value="{% if comment_point is defined %}{{ comment_point }}{% endif %}" class="form-control" min="0" />
                            <span class="form-text text-muted">1 yorum karşılığı kazanılacak puan sayısı</span>
                        </div>
                        <div class="col-lg-1">
                            <p class="font-weight-bolder mt-10" id="comment_total">0 TL</p>
                        </div>

                        <div class="col-lg-5">
                            <label class="font-weight-bold">Üyelik</label>
                            <input type="number" id="register_point" name="register_point" value="{% if register_point is defined %}{{ register_point }}{% endif %}" class="form-control" min="0" />
                            <span class="form-text text-muted">Üyelik karşılığı kazanılacak puan sayısı</span>
                        </div>
                        <div class="col-lg-1">
                            <p class="font-weight-bolder mt-10" id="register_total">0 TL</p>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-lg-5">
                            <label class="font-weight-bold">Tavsiye</label>
                            <input type="number" id="advice_point" name="advice_point" value="{% if advice_point is defined %}{{ advice_point }}{% endif %}" class="form-control" min="0" />
                            <span class="form-text text-muted">1 ürün tavsiyesi karşılığı kazanılacak puan</span>
                        </div>
                        <div class="col-lg-1">
                            <p class="font-weight-bolder mt-10" id="advice_total">0 TL</p>
                        </div>

                        <div class="col-lg-5">
                            <label class="font-weight-bold">Alışveriş</label>
                            <input type="number" id="shopping_point" name="shopping_point" value="{% if shopping_point is defined %}{{ shopping_point }}{% endif %}" class="form-control" min="0" />
                            <span class="form-text text-muted">Bedeli ne olursa olsun, 1 alışveriş karşılığı kazanılacak puan</span>
                        </div>
                        <div class="col-lg-1">
                            <p class="font-weight-bolder mt-10" id="shopping_total">0 TL</p>
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

        const point = $('#point');
        const currency = 'TL';

        const comment_point = $('#comment_point');
        const comment_total = $('#comment_total');

        const register_point = $('#register_point');
        const register_total = $('#register_total');

        const advice_point = $('#advice_point');
        const advice_total = $('#advice_total');

        const shopping_point = $('#shopping_point');
        const shopping_total = $('#shopping_total');

        point.bind('keyup mouseup', function () {
            comment_total.html((comment_point.val() / $(this).val()).toFixed(2) + " " + currency);
            register_total.html((register_point.val() / $(this).val()).toFixed(2) + " " + currency);
            advice_total.html((advice_point.val() / $(this).val()).toFixed(2) + " " + currency);
            shopping_total.html((shopping_point.val() / $(this).val()).toFixed(2) + " " + currency);
        });

        comment_point.bind('keyup mouseup', function () {
            comment_total.html(($(this).val() / point.val()).toFixed(2) + " " + currency);
        });

        register_point.bind('keyup mouseup', function () {
            register_total.html(($(this).val() / point.val()).toFixed(2) + " " + currency);
        });

        advice_point.bind('keyup mouseup', function () {
            advice_total.html(($(this).val() / point.val()).toFixed(2) + " " + currency);
        });

        shopping_point.bind('keyup mouseup', function () {
            shopping_total.html(($(this).val() / point.val()).toFixed(2) + " " + currency);
        });

        comment_total.html((comment_point.val() / point.val()).toFixed(2) + " " + currency);
        register_total.html((register_point.val() / point.val()).toFixed(2) + " " + currency);
        advice_total.html((advice_point.val() / point.val()).toFixed(2) + " " + currency);
        shopping_total.html((shopping_point.val() / point.val()).toFixed(2) + " " + currency);


        $('#pointForm').validate({
            rules: {
                point: "required"
            },
            messages: {
                point: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#pointForm').serialize();
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