<div class="nerdeyim">
    <div class="nrd_ort">
        <ul>
            <li><span><b>{{ cevir._('aranan_kelime') }}:</b> {% if query is defined %}{{ query }}{% endif %}</span></li>
            {% if total_products is defined %}<li class="urn_kodu">{{ cevir._('toplam_sonuc') }}: {{ total_products }}</li>{% endif %}
        </ul>
    </div>
</div>
<div class="sayfa">
    <div class="syf_ort">
        <div class="urunler w100">
            <div class="urn_cerceve mh900">
                {% if products is defined %}
                    {% for pro in products %}
                        <div class="urn w25">
                            <div class="urn_imgs">
                                <?php $image = \Yabasi\Images::findFirst(array('conditions' => 'meta_key="product" and status=1 and content_id='.$pro->id, 'order' => 'showcase desc')); ?>
                                {% set image_url = 'media/resimyok.png' %}
                                {% if image %}
                                    {% set image_url = 'media/product/' ~ image.meta_value %}
                                {% endif %}
                                <a href="{{ url('urun/' ~ pro.sef) }}" style="background:url('{{ url(image_url) }}') center center no-repeat #fff;"></a>
                                {% if pro.discount_rate is not 0 and pro.discount_rate is not '' %}
                                    <div class="discount_area l20 t20">
                                        {{ totaldiscount(pro.id) }}
                                    </div>
                                {% endif %}
                            </div>
                            <div class="noc">
                                <h3><a href="{{ url('urun/' ~ pro.sef) }}">{{ pro.name }}</a></h3>
                                <div class="kfiyat">
                                    <div class="kfiyat_son">{{ totalprice(pro.id) }}</div>
                                    {% if pro.discount_rate is not 0 and pro.discount_rate is not '' %}
                                        <del>{{ oldprice(pro.id) }}</del>
                                    {% endif %}
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                {% else %}
                    <div class="sonuc-yok">
                        <i class="fas fa-search"></i>
                        <p>{{ cevir._('sonuc_bulunamadi_text') }}</p>
                    </div>
                {% endif %}
            </div>

        </div>
    </div>
</div>
{% if cerez.value is defined%}
    <input id="cerez" type="hidden" data-baslik="{{ cerez.value }}">
    <script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
    <script>
        var baslik=$('#cerez').data('baslik');
        window.start.init({Palette:"palette1",Theme:"wire",Mode:"floating left",Time:"1",LinkText:"Detaylı bilgi almak için tıklayınız",Location:"{{ url('sayfa/gizlilik-ve-cerez-politikasi') }}",Message:baslik,ButtonText:"kabul et",})
    </script>
{% endif %}
<script type="text/javascript" src="assets/frontend/js/paginathing.js"></script>
<script>
    $('.urn_cerceve').paginathing({
        perPage: 16,
        limitPagination:{{ total_page }},
        containerClass: 'urn-pagination',
        pageNumbers: false
    })
</script>
