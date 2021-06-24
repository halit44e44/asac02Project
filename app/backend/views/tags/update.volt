<div class="alert alert-secondary rounded-0 dn" role="alert"></div>

<form method="post" id="tagsForm">

    <input type="hidden" class="lastid" value="{% if id is defined %}{{ id }}{% endif %}">

    <div class="card card-custom gutter-b mainCard" data-card="true">
        <div class="card-header">
            <h3 class="card-title">Etiketler Ayarları</h3>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Etiket Adı:</label>
                    <input type="text" id="name" name="name" value="{% if tags is defined %}{{ tags.name }}{% endif %}" class="form-control" placeholder="Etiket adını yazınız" autofocus="" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Üst İçerik: </label>
                    <textarea name="topcontent" id="topcontent">{% if tags is defined %}{{ tags.top_info }}{% endif %}</textarea>
                    <div class="invalid-feedback">Bu alan boş olamaz, minimum 20 karakter yazılmalıdır.</div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Alt İçerik: </label>
                    <textarea name="subcontent" id="subcontent">{% if tags is defined %}{{ tags.sub_info }}{% endif %}</textarea>
                    <div class="invalid-feedback">Bu alan boş olamaz, minimum 20 karakter yazılmalıdır.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom gutter-b seoCard" data-card="true">
        <div class="card-header">
            <h3 class="card-title">SEO Ayarları</h3>
        </div>

        <div class="card-body">

            <div class="seo_preview">
                <div class="seo_preview_title">ARAMA GÖRÜNÜMÜ</div>
                <h1 class="slugTitle">{% if tags is defined %}{{ tags.seo_title }}{% endif %}</h1>
                <span>{{ site_url }}/</span><span><strong class="slugText">{% if tags is defined %}{{ tags.sef }}{% endif %}</strong></span>
                <p class="slugDesc">{% if tags is defined %}{{ tags.description }}{% endif %}</p>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>SEO Başlığı:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="seotitle" name="seo_title" value="{% if tags is defined %}{{ tags.seo_title }}{% endif %}" placeholder="Arama motorlarında görünecek başlık" />

                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Kategori URL'si:</label>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text text-dark-50">{{ site_url }}/</span>
                        </div>
                        <input type="text" class="form-control slugurl" name="sef" value="{% if tags is defined %}{{ tags.sef }}{% endif %}" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Anahtar Kelime:</label>
                    <div class="input-group">
                        <input id="etiket" class="form-control tagify" name='keyword' placeholder='etiketleri yazınız...' value="{% if tags.keyword is defined %}{{ tags.keyword }}{% endif %}" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Açıklama:</label>
                    <div class="input-group">
                        <textarea type="text" rows="2" class="form-control" id="description" maxlength="150" name="description">{% if tags is defined %}{{ tags.description }}{% endif %}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="{{ url('backend/tags') }}" class="btn btn-secondary float-left">Vazgeç</a>
                    <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    $(document).ready(function () {
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
        $('#tagsForm').validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#tagsForm').serialize();
                const id = $('.lastid').val();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/tags/update/") }}'+id,
                    data: data,
                    success: function (response) {
                        const obj = jQuery.parseJSON(response);
                        if (obj.status === 'ok') {
                            $('.alert').removeClass('dn').html('İşlem başarılı bir şekilde tamamlandı!');
                            $('.mainCard, .seoCard').addClass('card-collapse');
                            $('.lastid').val(obj.id);
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