<div class="sayfa">
    <div class="syf_ort">

        {{ partial('uye/inc/sidebar') }}
        <div class="syf_icerik">
            <h2>{{ cevir._('favorilerim') }}</h2>

            <div class="urunler">
                <div class="urn_cerceve bsu">
                    {% if favorites is defined %}
                        {% for fav in favorites %}
                            {% if fav.status == "1" %}
                                <?php
                                $pro = \Yabasi\Product::findFirst('id='.$fav->getProId());
                                if($fav->getUserId() == $user ){?>
                                <div class="urn">
                                    <div class="urn_imgs">
                                        <a href="{{ url('urun/' ~ pro.sef) }}" style="background:url('{{ url('media/product/' ~ productImage(pro.id)) }}') center center no-repeat;"></a>
                                    </div>
                                    <div class="urn_detay noc">
                                        <h3>
                                            <a href="{{ url('urun/' ~ pro.sef) }}">{{ pro.name }}</a>
                                        </h3>

                                        {% if pro.discount_rate is not "0" and pro.discount_rate is not '' %}
                                            <div class="fiyat">
                                                <span>{{ totaldiscount(pro.id) }}</span>
                                                <del>{{ oldprice(pro.id) }}</del>
                                                <div class="fiyat_son">{{ totalprice(pro.id) }}</div>
                                            </div>
                                        {% else %}
                                            <div class="kfiyat">
                                                <div class="kfiyat_son">{{ totalprice(pro.id) }}</div>
                                            </div>
                                        {% endif %}

                                    </div>
                                </div>
                                <?php } ?>
                            {% endif %}
                        {% endfor %}
                    {% else %}
                        Favorilerinize ürün ekleyerek başlayabilirsiniz.
                    {% endif %}
                </div>
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
