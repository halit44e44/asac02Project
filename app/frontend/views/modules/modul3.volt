{% if modul3 is defined %}
    <div class="ana_serit">
        <div class="as_ort">
            {% for modul3 in modul3 %}
                <?php $image = \Yabasi\Images::findFirst(array('conditions' => 'meta_key="category" and status=1 and showcase=1 and content_id='.$modul3->id, 'order' => 'showcase desc')); ?>

                {% if image %}
                    {% set image_url = 'media/category/' ~ image.meta_value %}
                {% else %}
                    {% set image_url = '' %}
                {% endif %}
                <div class="aserit" {% if image is not null %}style="background: url('{{ url(image_url) }}') top left no-repeat;"{% endif %}>
                    <h4><a href="{{ url('kategori/' ~ modul3.sef) }}">{{ modul3.name }}</a></h4>
                    <h5 lang="tr">{{ modul3.short_content }}</h5>
                    <a href="{{ url('kategori/' ~ modul3.sef) }}" class="as_lnk">{{ cevir._('tum_urunler') }}<i class="fa fa-arrow-right"></i></a>
                </div>
            {% endfor %}

        </div>
    </div>
{% endif %}