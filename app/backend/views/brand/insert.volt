<div class="alert alert-secondary rounded-0 dn" role="alert"></div>
<input type="hidden" id="users" value="{{ user.group_id }}">
<form id="brandForm" method="post">

    <div class="card card-custom gutter-b mainCard" data-card="true">
        <div class="card-header">
            <h3 class="card-title">Marka Ayarları</h3>
            <div class="card-toolbar">
                <a href="javascript:;" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Gizle/Göster">
                    <i class="ki ki-arrow-down icon-nm"></i>
                </a>
            </div>
        </div>

        <div class="card-body">

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Marka:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Marka adını yazınız" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label>İçerik: </label>
                    <textarea name="content" id="content"></textarea>
                </div>
            </div>

        </div>
    </div>

    <div class="card card-custom gutter-b seoCard" data-card="true">
        <div class="card-header">
            <h3 class="card-title">SEO Ayarları</h3>
            <div class="card-toolbar">
                <a href="javascript:;" class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-card-tool="toggle" data-toggle="tooltip" data-placement="top" title="Gizle/Göster">
                    <i class="ki ki-arrow-down icon-nm"></i>
                </a>
            </div>
        </div>

        <div class="card-body">

            <div class="seo_preview dn">
                <div class="seo_preview_title">ARAMA GÖRÜNÜMÜ</div>
                <h1 class="slugTitle"></h1>
                <span>https://www.yabasi.com/</span><span><strong class="slugText"></strong></span>
                <p class="slugDesc"></p>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>SEO Başlığı:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="seo_title" id="seotitle" placeholder="Arama motorlarında görünecek başlık" />

                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Kategori URL'si:</label>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text text-dark-50">https://www.yabasi.com/</span>
                        </div>
                        <input type="text" class="form-control slugurl" id="slugurl" name="slugurl" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Anahtar Kelime:</label>
                    <div class="input-group">
                        <input id="etiket" class="form-control tagify" name='keyword' placeholder='etiketleri yazınız...' value="" autofocus="" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Açıklama:</label>
                    <div class="input-group">
                        <textarea type="text" rows="2" class="form-control" id="description" maxlength="150" name="description"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Üst İçerik: </label>
                    <textarea name="topcontent" id="topcontent"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Alt İçerik: </label>
                    <textarea name="subcontent" id="subcontent"></textarea>
                </div>
            </div>


        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="{{ url('backend/brand') }}" class="btn btn-secondary float-left">Vazgeç</a>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
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
            <input type="hidden" class="table" name="table" value="brand" />
            <div class="dropzone-msg dz-message needsclick">
                <h3 class="dropzone-msg-title">Fotoğrafları buraya sürükle veya tıklayarak yükle.</h3>
                <span class="dropzone-msg-desc">Aynı anda 10 fotoğraf yükleyebilirsiniz.</span>
            </div>
        </form>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-lg-12 text-right">
                <a href="{{ url('backend/brand') }}" class="btn btn-primary">İşlemleri Tamamla</a>
            </div>
        </div>
    </div>
</div>

<div class="uploadedphotos"></div>

<script>

    $(document).ready(function () {
        const user=$('#users').val();

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
        ClassicEditor
            .create( document.querySelector( '#topcontent' ), {
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
            .create( document.querySelector( '#subcontent' ), {
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

        $('#brandForm').validate({
            rules: {
                name: "required",
                seo_title: "required"
            },
            messages: {
                name: "Bu alan zorunludur!",
                seo_title: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#brandForm').serialize();
                if (user==="3"){
                    Swal.fire("Hata!", "Düzenleme yetkiniz bulunmamaktadır!", "warning");
                    return false;
                }
                else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url("backend/brand/insert/") }}',
                        data: data,
                        success: function (response) {

                            const obj = jQuery.parseJSON(response);

                            if (obj.status === 'ok') {
                                $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                                $('.mainCard .card-body, .seoCard .card-body, .seoCard .card-footer').hide();
                                $('.mainCard, .seoCard').addClass('card-collapse');
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
            prepeareCheckbox();
        }
    });

    prepeareCheckbox();
    function prepeareCheckbox() {
        $("input:checkbox").on('click', function() {
            // in the handler, 'this' refers to the box clicked on
            var $box = $(this);
            if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the group/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    }

</script>