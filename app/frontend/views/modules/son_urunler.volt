{% if soneklenen is defined %}
<div class="son_urunler">
    <div class="baslik">
        <div class="gbaslik">
            <h4>Son Eklenen <span>Ürünler</span></h4>
            <a href="{{ url('tum-urunler') }}" class="detay">Tüm <span>Ürünler</span><i class="las la-arrow-right"></i></a>
        </div>
    </div>
    <div class="aurunler_ort">
        <div class="au_cerceve">
            {% for son in soneklenen %}
                <?php $image = \Yabasi\Images::findFirst(array('conditions' => 'meta_key="product" and status=1 and content_id='.$son->id, 'order' => 'showcase desc')); ?>
                {% set image_url = 'media/resimyok.png' %}
                {% if image %}
                    {% set image_url = 'media/product/' ~ image.meta_value %}
                {% endif %}
                <div class="urn">
                    <div class="urn_imgs">
                        <a href="{{ url('urun/' ~ son.sef) }}" style="background: url('{{ url(image_url) }}') center center no-repeat;"></a>
                        {% if son.discount_rate is not 0 and son.discount_rate is not '' %}
                            <div class="discount_area">
                                {{ totaldiscount(son.id) }}
                            </div>
                        {% endif %}
                    </div>

                    <div class="noc">
                        <h3><a href="{{ url('urun/' ~ son.sef) }}">{{ son.name }}</a></h3>
                        <div class="kfiyat">
                            <div class="kfiyat_son">{{ totalprice(son.id) }}</div>
                            {% if son.discount_rate is not 0 and son.discount_rate is not '' %}
                                <del>{{ oldprice(son.id) }}</del>
                            {% endif %}
                        </div>
                    </div>


                </div>
            {% endfor %}
        </div>
    </div>
</div>
{% endif %}