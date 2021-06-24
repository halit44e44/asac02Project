<div class="alert alert-secondary rounded-0 dn" role="alert"></div>

<form method="post" id="contentForm">
    <input type="hidden" name="id" value="{{ content.id }}" />
    <div class="card card-custom gutter-b mainCard" data-card="true">
        <div class="card-header">
            <h3 class="card-title">İçerik Ayarları</h3>
        </div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Başlık:</label>
                    <input type="text" id="name" name="name" value="{{ content.name }}" class="form-control" placeholder="İçerik başlığını yazınız" autofocus="" />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>Kategori:</label>
                    <select class="form-control select2" id="kt_select2_2" name="content_cat_id">
                        {% if contentcats is defined %}
                            {% for cat in contentcats %}
                                <option value="{{ cat.id }}" {% if content.content_cat_id is cat.id %}selected{% endif %}>{{ cat.name }}</option>
                                <?php
                                $altcats = \Yabasi\Contentcats::find('top_id='.$cat->id);
                                if ($altcats->count() != 0) { ?>
                                <?php foreach ($altcats as $alt) {?>
                                <option value="<?php echo $alt->id; ?>" {% if alt.id is cat.id %}selected{% endif %}>&nbsp;&nbsp;- <?php echo $alt->name; ?></option>
                                <?php }} ?>
                            {% endfor %}
                        {% endif %}
                    </select>
                </div>
                <div class="col-lg-6">
                    <label>Yönlendirme URL'si:</label>
                    <input type="text" class="form-control" name="redirect_url" value="{{ content.redirect_url }}" />
                    <span class="form-text text-muted">Eğer yönlendirme yok ise boş bırakınız</span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Kısa İçerik:</label>
                    <div class="input-group">
                        <textarea type="text" rows="2" class="form-control" id="short_content" maxlength="150" name="short_content">{{ content.short_content }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>İçerik: </label>
                    <textarea name="content" id="content">{{ content.content }}</textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Google Maps:</label>
                    <div class="input-group">
                        <textarea type="text" rows="2" class="form-control" id="map" name="map">{{ content.map }}</textarea>
                    </div>
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
                <h1 class="slugTitle">{{ content.seo_title }}</h1>
                <span>{{ site_url }}/</span><span><strong class="slugText">{{ content.sef }}</strong></span>
                <p class="slugDesc">{{ content.description }}</p>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>SEO Başlığı:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="seotitle" name="seo_title" value="{{ content.seo_title }}" placeholder="Arama motorlarında görünecek başlık" />

                    </div>
                </div>
                <div class="col-lg-6">
                    <label>Kategori URL'si:</label>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text text-dark-50">{{ site_url }}/</span>
                        </div>
                        <input type="text" class="form-control slugurl" name="sef" value="{{ content.sef }}" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Anahtar Kelime:</label>
                    <div class="input-group">
                        <input id="etiket" class="form-control tagify" name='keyword' placeholder='etiketleri yazınız...' value="{{ content.keyword }}" />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Açıklama:</label>
                    <div class="input-group">
                        <textarea type="text" rows="2" class="form-control" id="description" maxlength="150" name="description">{{ content.description }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="{{ url('backend/content') }}" class="btn btn-secondary float-left">Vazgeç</a>
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
            <input type="hidden" class="lastid" name="id" value="{% if content is defined %}{{ content.id }}{% endif %}" />
            <input type="hidden" class="table" name="table" value="content" />
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
                            <img src="{{ url('media/content/' ~ image.meta_value) }}" style="object-fit: cover;" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <form id="form_{{ image.id }}">
                            <input type="hidden" class="lastid" name="id" value="{{ image.id }}" />
                            <input type="hidden" name="table" value="content" />
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
                                    <button type="button" onclick="removeImage(this)" data-id="{{ image.id }}" data-table="content" class="btn btn-light-danger mr-2">Kaldır</button>
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


        $('#contentForm').validate({
            rules: {
                name: "required",
                content: "required"
            },
            messages: {
                name: "Bu alan zorunludur!",
                content: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#contentForm').serialize();

                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/content/update/") }}',
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
            prepeareCheckbox();
        }
    });
    prepeareCheckbox();
    function prepeareCheckbox() {
        $("input:checkbox").on('click', function () {
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