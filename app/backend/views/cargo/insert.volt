<div class="alert alert-secondary rounded-0 dn" role="alert"></div>
<input type="hidden" id="users" value="{{ user.group_id }}">
<form class="form" id="cargoForm" method="post">

    <div class="card card-custom gutter-b mainCard" data-card="true">
        <div class="card-header">
            <h3 class="card-title">Kargo Ayarları</h3>
            <div class="card-toolbar">
                <a href="javascript:;" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Gizle/Göster">
                    <i class="ki ki-arrow-down icon-nm"></i>
                </a>
            </div>
        </div>

        <div class="card-body">

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Kargo Firması:</label>
                    <input type="text" id="name" name="name" class="form-control" />
                </div>

                <div class="col-lg-6">
                    <label>Taşıma Bedeli:</label>
                    <input type="text" id="price" name="price" class="form-control" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Açıklama:</label>
                    <textarea type="text" rows="2" class="form-control" id="content" name="content" maxlength="250"></textarea>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <a href="{{ url('backend/cargo') }}" class="btn btn-secondary float-left">Vazgeç</a>
                        <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<div class="card card-custom gutter-b photoCard dn" data-card="true">
    <div class="card-header">
        <h3 class="card-title">Fotoğraf Ayarları</h3>
        <div class="card-toolbar">
            <a href="javascript:;" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Gizle/Göster">
                <i class="ki ki-arrow-down icon-nm"></i>
            </a>
        </div>
    </div>

    <div class="card-body">
        <form class="dropzone dropzone-default dropzone-primary photoupload">
            <input type="hidden" class="lastid" name="id" value="" />
            <input type="hidden" class="table" name="table" value="cargo" />
            <div class="dropzone-msg dz-message needsclick">
                <h3 class="dropzone-msg-title">Fotoğrafları buraya sürükle veya tıklayarak yükle.</h3>
                <span class="dropzone-msg-desc">Aynı anda 10 fotoğraf yükleyebilirsiniz.</span>
            </div>
        </form>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="{{ url('backend/cargo') }}" class="btn btn-primary">İşlemleri Tamamla</a>
            </div>
        </div>
    </div>
</div>

<div class="uploadedphotos"></div>

<script>

    $(document).ready(function () {

        ClassicEditor
            .create( document.querySelector( '#content' ), {
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

        $("#price").inputmask('999999.99', {
            numericInput: true
        });

        $('#cargoForm').validate({
            rules: {
                name: "required",
                price: "required"
            },
            messages: {
                name: "Bu alan zorunludur!",
                price: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#cargoForm').serialize();
                const user=$('#users').val();
                if (user === "3") {
                    Swal.fire("Hata!", "Düzenleme yetkiniz bulunmamaktadır!", "warning");
                    return false;
                } else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url("backend/cargo/insert/") }}',
                        data: data,
                        success: function (response) {

                            const obj = jQuery.parseJSON(response);

                            if (obj.status === 'ok') {
                                $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                                $('.photoCard').removeClass('dn');
                                $('.lastid').val(obj.id);
                                goTop();
                            } else {
                                $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                                goTop();
                            }
                        }
                    });
                }
            }
        });
    });

    let returned = '';
    const photoUpload = new Dropzone('form.photoupload', {
        url: '{{ url('backend/upload/set') }}',
        uploadMultiple: true,
        autoProcessQueue: true,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        maxFiles: 10,
        maxFilesize: 5000,
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
        success: function (file, response) {
            $('.uploadedphotos').html(response);
        }
    });

</script>