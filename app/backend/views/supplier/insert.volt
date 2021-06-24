<form id="supplierForm" method="post">

    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Yeni Tedarikçi Ekle</h3>
        </div>

        <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

        <div class="card-body">

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Tedarikçi:</label>
                    <input type="text" id="name" name="name" maxlength="100" minlength="3" class="form-control" placeholder="Tedarikçi  yazınız" />
                </div>
            </div>

        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="{{ url('backend/supplier') }}" class="btn btn-secondary float-left">Vazgeç</a>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    $(document).ready(function () {

        $('#supplierForm').validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#supplierForm').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/supplier/insert/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                            goTop();
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                            goTop();
                        }
                    }
                });
            }
        });
    });
</script>