<div class="alert alert-secondary rounded-0 dn" role="alert"></div>

<form id="bankForm" method="post">

    <input type="hidden" name="id" value="{{ bank.id }}">

    <div class="card card-custom gutter-b mainCard" data-card="true">
        <div class="card-header">
            <h3 class="card-title">Banka Ayarları</h3>
        </div>

        <div class="card-body">

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Banka Adı:</label>
                    <input type="text" id="name" name="name" {% if bank.account_number is defined %}value="{{ bank.name }}"{% endif%}  maxlength="100" minlength="3" class="form-control" placeholder="Banka adını yazınız" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Hesap Sahipi:</label>
                    <input type="text" id="owner" name="owner"{% if bank.owner is defined %} value="{{ bank.owner }}" {% endif%}  maxlength="100" minlength="3" class="form-control" placeholder="Hesap sahibi" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>İban:</label>
                    <input type="text" id="iban" name="iban"{% if bank.iban is defined %} value="{{ bank.iban }}" {% endif%}  maxlength="100" minlength="3" class="form-control" placeholder="İban" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Şube:</label>
                    <input type="text" id="branch" name="branch"{% if bank.branch is defined %}value="{{ bank.branch }}" {% endif%} maxlength="100" minlength="3" class="form-control" placeholder="Şube" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Hesap Numarası:</label>
                    <input type="text" id="account_number" name="account_number"{% if bank.account_number is defined %}value="{{ bank.account_number }}" {% endif%} maxlength="100" minlength="3" class="form-control" placeholder="Hesap Numarası" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>İçerik: </label>
                    <textarea name="content" id="content">{{ bank.content }}</textarea>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="{{ url('backend/bank') }}" class="btn btn-secondary float-left">Vazgeç</a>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                </div>
            </div>
        </div>

    </div>
</form>


<div class="card card-custom gutter-b photoCard" data-card="true">
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
            <input type="hidden" class="lastid" name="id" value="{% if bank is defined %}{{ bank.id }}{% endif %}" />
            <input type="hidden" class="table" name="table" value="bank" />
            <div class="dropzone-msg dz-message needsclick">
                <h3 class="dropzone-msg-title">Fotoğrafları buraya sürükle veya tıklayarak yükle.</h3>
                <span class="dropzone-msg-desc">Aynı anda 10 fotoğraf yükleyebilirsiniz.</span>
            </div>
        </form>
    </div>
</div>

<div class="uploadedphotos">
    {% for image in images %}
        <div class="card card-custom gutter-b" id="image_{{ image.id }}">
            <i class="fa fa-check cardi dn" id="cardi_{{ image.id }}"></i>
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-shrink-0 mr-7">
                        <div class="symbol symbol-50 symbol-lg-120">
                            <img src="{{ url('media/bank/' ~ image.meta_value) }}" style="object-fit: cover;" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <form id="form_{{ image.id }}">
                            <input type="hidden" class="lastid" name="id" value="{{ image.id }}" />
                            <input type="hidden" name="table" value="bank" />
                            <input type="hidden" name="old_name" value="<?php echo preg_replace('/\\.[^.\\s]{3,4}$/', '', $image->getMetaValue()) ?>" />
                            <?php
                            $ext = explode(".", $image->getMetaValue());
                            $ext = $ext[1];
                            ?>
                            <input type="hidden" name="extension" value="{{ ext }}" />
                            <div class="d-flex align-items-center flex-wrap justify-content-between row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Dosya ismi</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo preg_replace('/\\.[^.\\s]{3,4}$/', '', $image->getMetaValue()); ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sıra</label>
                                        <input type="number" class="form-control" name="row" value="{{ image.row }}" min="1"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="checkbox">
                                        <input type="checkbox" name="showcase" value="1" {% if image.showcase is 1 %}checked="checked"{% endif %}>
                                        <span class="mr-3"></span>Ön tanımlı görsel</label>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" onclick="removeImage(this)" data-id="{{ image.id }}" data-table="bank" class="btn btn-light-danger mr-2">Kaldır</button>
                                    <button type="button" class="btn btn-light-primary mr-2" data-id="{{ image.id }}" onclick="updateImage(this)">Kaydet</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {% endfor %}
</div>

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

        $('#bankForm').validate({
            rules: {
                name: "required",
                iban: "required"
            },
            messages: {
                name: "Bu alan zorunludur!",
                iban: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#bankForm').serialize();

                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/bank/update/") }}',
                    data: data,
                    success: function (response) {
                        const obj = jQuery.parseJSON(response);
                        if (obj.status === 'ok') {
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