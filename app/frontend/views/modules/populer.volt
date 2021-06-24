<div class="populer_kategoriler">
    <div class="pk_ort">
        {% if populers is defined %}
        {% for populer in populers %}
        <?php $image = \Yabasi\Images::findFirst(array('conditions' => 'meta_key="category" and status=1 and showcase=1 and content_id='.$populer->id, 'order' => 'showcase desc')); ?>
        {% if image %}
            {% set image_url = 'media/category/' ~ image.meta_value %}
        {% else %}
            {% set image_url = '' %}{% endif %}
        <div class="pkategori">
            <h2><a href="{{ url('kategori/' ~ populer.sef) }}">{{ populer.name }}</a></h2>
            <div class="pkaciklama">{{ populer.short_content }}</div>
            <div class="pk_res">
                <a href="{{ url('kategori/' ~ populer.sef) }}" title="{{ populer.name }}"><img src="{{ url(image_url) }}" alt="{{ populer.name }}"></a>
                <a href="{{ url('kategori/' ~ populer.sef) }}" title="{{ populer.name }}" class="detay">Tüm <span>ürünler</span><i class="las la-arrow-right"></i></a>
            </div>
        </div>
        {% endfor %}
        {% endif %}

    </div>
</div>