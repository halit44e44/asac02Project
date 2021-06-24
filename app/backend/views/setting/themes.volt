<div class="card card-custom">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">Temalar</h3>
        </div>
    </div>
    <div class="tab-pane fade show active" id="pc_temalar" role="tabpanel">
        <form id="pcForm" method="post">
            <input type="hidden" name="param" value="pc_temalar"/>

            <div class="row">
                {% if themes is defined %}
                    {% for themes in themes %}
                        <?php $parse = json_decode($themes->meta_value, true);

                                                            $image_logo = 'media/resimyok.png';
                                                            $image = \Yabasi\Images::findFirst('content_id='.$parse['id'] . ' and meta_key="theme_content/logo" and status=1');
                                                            if($image) {
                                                            $image_logo = 'media/theme_content/logo/'.$image->meta_value;
                                                            }
                                                            $image_r1 = 'media/resimyok.png';
                                                            $image = \Yabasi\Images::findFirst('content_id='.$parse['id'] . ' and meta_key="theme_content/catalog" and status=1');
                                                            if ($image){
                                                            $image_r1 = 'media/theme_content/catalog/'.$image->meta_value;
                                                            }
                                                            $images_r2 = 'media/resimyok.png';
                                                            $image = \Yabasi\Images::findFirst('content_id='.$parse['id'] . ' and meta_key="theme_content/banner1" and status=1');
                                                            if ($image){
                                                            $images_r2 = 'media/theme_content/banner1/'.$image->meta_value;
                                                            }
                                                            $images_r3 = 'media/resimyok.png';
                                                            $image = \Yabasi\Images::findFirst('content_id='.$parse['id'] . ' and meta_key="media/theme_content/banner2" and status=1');
                                                            if($image){
                                                            $images_r3 = 'media/theme_content/banner/'.$image->meta_value;
                                                            }
                                                            ?>
                        <div class="col-xl-4">
                            <div class="card card-custom card-stretch gutter-b">
                                <div class="card-body d-flex flex-column">
                                    <div class="flex-grow-1 pb-5">
                                        <div class="d-flex align-items-center pr-2 mb-6">
                                            <span class="text-muted font-weight-bold font-size-lg flex-grow-1">
                                            {% if parse['create_at'] is defined %}
                                                {# date("d.m.Y  H:m:s", parse['create_at']) #}
                                            {% endif %}
                                            </span>
                                            <div>
                                                <div class="form-control line-e border-0">
                                                    <img width="80px" class="showImage" style="border:1px solid #efefef"
                                                         src="{% if image_logo is defined %}{{ image_logo }}{% endif %}" data-toggle="tooltip"
                                                         data-trigger="focus"
                                                         data-content="<img src='{% if image_logo is defined %}{{ image_logo }}{% endif %}' width='800' class='img-fluid'>"
                                                         data-original-title="" title="">
                                                </div>
                                            </div>
                                        </div>
                                        <a class="text-dark font-weight-bolder text-hover-primary font-size-h4">
                                            {% if themes is defined %}
                                                {{ themes.name }}
                                            {% endif %}
                                            <br>Renk Yoğunluğu</a>
                                        <p class="text-dark-50 font-weight-normal font-size-lg mt-6">
                                            <br>
                                            {% if parse['content'] is defined %}
                                                {{ parse['content'] }}
                                            {% endif %}
                                        </p>
                                    </div>
                                    <?php
                                    $screen_url = 'public/assets/frontend/images/screen/';
                                    ?>
                                    <div class="d-flex align-items-center">
                                        <span class="symbol-label bg-light-light">
                                        <img width="40px" class="showImage"
                                             src="{{ screen_url ~ '1.png' }}" data-toggle="tooltip"
                                             data-trigger="focus"
                                             data-content="<img src='{{ screen_url ~ '1.png' }}' width='400' class='img-fluid'>">
                                        </span>
                                        <div class="ml-sm-2 my-1"></div>
                                        <span class="symbol-label bg-light-light">
                                        <img width="40px" class="showImage"
                                             src="{{ screen_url ~ '2.png' }}" data-toggle="tooltip"
                                             data-trigger="focus"
                                             data-content="<img src='{{ screen_url ~ '2.png' }}' width='400' class='img-fluid'>"
                                             data-original-title="" title="">
                                        </span>
                                        <div class="ml-sm-2 my-1"></div>
                                        <span class="symbol-label bg-light-light">
                                        <img width="40px" class="showImage"
                                             src="{{ screen_url ~ '3.png' }}" data-toggle="tooltip"
                                             data-trigger="focus"
                                             data-content="<img src='{{ screen_url ~ '3.png' }}' width='400' class='img-fluid'>"
                                             data-original-title="" title="">

                                        </span>

                                        <div class="ml-sm-auto my-1">
                                            {% set status = 'Aktif' %}
                                            {% set status_text= 'icon-md fas fa-check' %}
                                            {% set status_icon= 'btn-success' %}
                                            {% if themes.status is 0 %}
                                                {% set status = 'Pasif' %}
                                                {% set status_text= 'icon-md fas fa-times' %}
                                                {% set status_icon= 'btn-primary' %}
                                            {% endif %}
                                            <a href="javascript:;" title="{{ status }}" data-id="{{ themes.id }}" class="btn btn-icon {{ status_icon }} changeTheme">
                                                <i class="{{ status_text }}"></i>
                                            </a>

                                            <a href="{{ url('backend/pro/genelayar/' ~ themes.id) }}"
                                               class="btn btn-icon btn-primary"
                                               title="Özellikler"
                                               data-toggle="tooltip" data-theme="dark">
                                                <i class="icon-md fas fa-pencil-alt"></i>

                                            </a>
                                            <a href="https://oyos.com.tr/demo/giyim_demo.png" target="_blank" class="btn btn-icon btn-primary"
                                               title="Ön İzleme"
                                               data-toggle="tooltip" data-theme="dark">
                                                <i class="icon-md fas fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                {% endif %}
            </div>
        </form>
    </div>

</div>

<script>
    $('.changeTheme').click(function () {
        const id = $(this).data('id');
        console.log(id);
        $.ajax({
            type: 'post',
            url: '{{ url('backend/setting/changetheme/') }}',
            data: 'id='+id,
            success: function(response) {
                console.log('???');
                if (response === 'ok') {
                    window.location.reload();
                }
            }
        })
    });
</script>