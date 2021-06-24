{% if modul4 is defined %}
<div class="urn_kategori urnk_buyuk modul4">
    <div class="urnk_ort h-auto">
        {% if modul4 is defined %}
            <div class="urnk_baslik">
                <h4><a href="{{ url('kategori/' ~ modul4.sef) }}">{{ modul4.name }}</a></h4>
                <h5>{{ cevir._('kacirilmayacak_firsatlar') }}</h5>
                <a href="{{ url('kategori/' ~ modul4.sef) }}" class="urnk_lnk">{{ cevir._('tum_urunler') }}<i class="fa fa-arrow-right"></i></a>
            </div>

        {% endif %}

        <div class="urnk_cerceve">
            {% if modul4_pro is defined %}
                {% for son in modul4_pro %}
                    <?php $image = \Yabasi\Images::findFirst(array('conditions' => 'meta_key="product" and status=1 and content_id='.$son['id'], 'order' => 'showcase desc')); ?>
                    {% set image_url = 'media/resimyok.png' %}
                    {% if image %}
                        {% set image_url = 'media/product/' ~ image.meta_value %}
                    {% endif %}
                    <div class="urn">
                        <div class="urn_imgs">
                            <a href="{{ url('urun/' ~ son['sef']) }}" style="background: url('{{ url(image_url) }}') center center no-repeat;"></a>
                            {% if son['discount_rate'] is not 0 and son['discount_rate'] is not '' %}
                                <div class="discount_area">
                                    {{ totaldiscount(son['id']) }}
                                </div>
                            {% endif %}
                        </div>
                        <div class="noc">
                            <h3><a href="{{ url('urun/' ~ son['sef']) }}">{{ son['name'] }}</a></h3>
                            <div class="kfiyat">
                                <div class="kfiyat_son">{{ totalprice(son['id']) }}</div>
                                {% if son['discount_rate'] is not 0 and son['discount_rate'] is not '' %}
                                    <del>{{ oldprice(son['id']) }}</del>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                {% endfor %}
            {% endif %}
        </div>

    </div>
</div>
{% endif %}