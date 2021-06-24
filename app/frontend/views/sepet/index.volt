<div class="sayfa">
    <div class="syf_ort">
        <div class="uyari" id="yorum_uyari" style="display: none;"></div>
        <div class="sepetim_ana">
            <div class="sepetim">
                <h4>Sepetim ({{ count }} ürün )</h4>
                {% if shopcart is defined %}
                    {% for shopcart in shopcart %}
                        <div class="surn surn_{{ shopcart.id }}" >
                            <div class="su_img"><a href="{{ url(('urun/')~product(shopcart.pro_id).sef) }}"><img src="public/media/product/{{ productImage(shopcart.pro_id) }}" alt=""></a></div>
                            <div class="su_bilgi">
                                <h4><a href="{{ url(('urun/')~product(shopcart.pro_id).sef) }}">{{ product(shopcart.pro_id).name }}</a></h4>
                                <span>{{ hediye(shopcart.pro_id) }}</span>

                            </div>

                            <div class="su_varyasyon">
                                <span>{{ cevir._('adet') }}</span>
                                <input onchange="adet(this)" data-stok="{{ sepetStock(shopcart.id) }}" data-id="{{shopcart.id}}" type="number" min="1" max="{{ sepetStock(shopcart.id) }}" value="{{shopcart.piece  }}" id="adet{{ shopcart.id }}" class="sepet_number">
                            </div>

                            <div class="su_varyasyon">
                                {{ sepetVariant(shopcart.id ) }}
                            </div>

                            <div class="su_fiyat">
                                <del>{{ oldpricesepet(shopcart.id) }}</del>
                                <span>{{ price(shopcart.id) }}</span>
                            </div>

                            <div class="su_sil">
                                <a onclick="sil(this)" data-id="{{ shopcart.id }}" href="javascript:void(0)" class="fas fa-times"></a>
                            </div>
                        </div>
                    {% endfor %}
                {% endif %}
                {% if shopcart.id is empty %}
                    <div class="uyari sepet_bos_uyari" id="yorum_uyari">{{ cevir._('sepet_bos_text') }}</div>
                {% endif %}


            </div>

        </div>

        <div class="sepet_bilgi">
            <div class="sepet_ozet">
                <h4>{{ cevir._('siparis_ozeti') }}</h4>
                {% if cargo is not null or cargo != 0 %}
                    {% if round(cargo-sepettotalprice(user,user))>0 %}
                        <div class="kiskirt">Sepetinize {{ round(cargo-sepettotalprice(user,user))}} TL lik daha ürün eklerseniz, kargo ücreti bizden.</div>
                    {% endif %}
                {% else %}
                    <span></span>
                {% endif %}


                <div style="width:100%; float:left; max-height:300px; overflow:auto;">
                    {% if shopcarts is defined %}
                        {% for shopcarts in shopcarts %}
                            <div class="so_urn surn_{{ shopcarts.id }}">
                                <a href=""><img src="public/media/product/{{ productImage(shopcarts.pro_id) }}" alt=""></a>
                                <h5><a href="">{{ product(shopcarts.pro_id).name }}  </a></h5>

                                <div class="sou_varyasyon">
                                    <span>{{ cevir._('adet') }}: {{shopcarts.piece  }}</span>
                                    {{ sepetVariant(shopcarts.id) }}
                                </div>
                                <div class="sou_fiyat">
                                    <del>{{ oldpricesepet(shopcarts.id) }}</del>
                                    <span>{{ price(shopcarts.id) }}</span>
                                </div>
                            </div>
                        {% endfor %}
                    {% endif %}
                </div>


                {% if shopcarts.user_id is defined %}
                    <div class="sou_fiyat">
                        <div class="souf">
                            <span>{{ cevir._('ara_toplam') }}</span>
                            <span>{% if user is defined %}
                                    {{ sepettotalprice(user) }}
                                {% endif %}
                        </span>
                        </div>
                        {% if sepetVoucher(user)=="true" %}
                            <div class="souf">
                                <span>Kupun İndirimi</span>
                                <span>{{ indirim(user) }}</span>
                                <span></span>
                            </div>
                        {% endif %}
                        <div class="souf">
                            <span>{{ cevir._('kargo_toplam') }}</span>
                            {% if cargo is not null %}
                                {% if round(sepettoplam(user,user)-cargo)>=0 %}
                                    <span>{{ cevir._('ucretsiz_kargo') }}</span>
                                {% else %}
                                    <span>{% if user is defined %}{{ cargo(user) }}{% else %} {% endif %}</span>
                                {% endif %}
                            {% else %}
                                <span>{% if user is defined %}{{ cargo(user) }}{% else %} {% endif %}</span>
                            {% endif %}
                        </div>

                        {% if havalekontrol(user)=="true" %}
                        <div class="souf toplam">
                            <span>{{ cevir._('havale_indirimi') }}</span>
                            {% if cargo is not null %}
                                {% if round(sepettoplam(user,user)-cargo)>=0 %}
                                    <span>{% if user is defined %}{{ havaletoplam(user) }}{% endif %}</span>
                                {% else %}
                                    <span>{{ pricesepet(cargo(user,user)+havaletoplam(user,user),shopcarts.pro_id) }}</span>
                                {% endif %}
                            {% else %}
                                <span>{{ pricesepet(cargo(user,user)+havaletoplam(user,user),shopcarts.pro_id) }}</span>
                            {% endif %}
                        </div>
                        {% endif %}

                        <div class="souf toplam">
                            <span>{{ cevir._('toplam') }}</span>
                            {% if cargo is not null %}
                                {% if round(sepettoplam(user,user)-cargo)>=0 %}
                                    <span>{% if user is defined %}{{ sepettoplam(user) }}{% endif %}</span>
                                {% else %}
                                    <span>{{ pricesepet(cargo(user,user)+sepettoplam(user,user),shopcarts.pro_id) }}</span>
                                {% endif %}
                            {% else %}
                                <span>{{ pricesepet(cargo(user,user)+sepettoplam(user,user),shopcarts.pro_id) }}</span>
                            {% endif %}
                        </div>
                    </div>
                {% endif %}
                {% if user is defined %}
                    {% if sepetVoucher(user)=="false" %}
                        <div id="hediye_ceki">
                            <h4 onclick="$('#hc_form').slideToggle()">{{ cevir._('kupon_kodu_text') }}<i class="fas fa-chevron-down"></i></h4>
                            <div id="hc_form">
                                <input type="text" id="vouchers" placeholder="{{ cevir._('kupon_kodunu_yazin') }}">
                                <input type="button" onclick="kupon()" value="{{ cevir._('hediye_ceki_kullan') }}">
                            </div>
                        </div>
                    {% endif %}
                {% endif %}
            </div>

            {% if count>0%}
                <div class="sepet_butonlari">

                    <div class="sol">
                        <a href="{{ url('') }}" lang="tr">{{ cevir._('alisverise_devam_et') }}</a>
                    </div>

                    <div class="sag">
                        <a href="{{ url('sepet/adres') }}" class="sepet_onay" lang="tr">{{ cevir._('sepeti_onayla') }}
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            {% endif %}
        </div>
    </div>
</div>

{% if oneriler is defined %}
<!-- onerilen ürünler -->
    <div class="son_urunler mt-0">
        <div class="baslik">
            <div class="gbaslik">
                <h5>En çok alınan <span>ürünler</span></h5>
            </div>
        </div>
        <div class="aurunler_ort">
            <div class="au_cerceve mh-auto">
                {% for son in oneriler %}
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

{% if cerez.value is defined%}
    <input id="cerez" type="hidden" data-baslik="{{ cerez.value }}">
    <script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
    <script>
        var baslik=$('#cerez').data('baslik');
        window.start.init({Palette:"palette1",Theme:"wire",Mode:"floating left",Time:"1",LinkText:"Detaylı bilgi almak için tıklayınız",Location:"{{ url('sayfa/gizlilik-ve-cerez-politikasi') }}",Message:baslik,ButtonText:"kabul et",})
    </script>
{% endif %}
<script>
    function sil(el){
        var id=$(el).data('id');

        $.ajax({
                type: "POST",
                url: 'sepet/delete/'+id,
                success: function (data)
                {
                    if (data==="ok"){
                        location.reload();
                    } else {
                        $('#yorum_uyari').addClass('uyari_kirmizi').fadeIn().html('{{ cevir._('sepet_hata_mesaji') }}');
                    }
                },
            }
        );

    }
</script>
<script>
    function adet(el){
        var id=$(el).data('id');
        var stok=$(el).data('stok');
        var adet=document.getElementById('adet'+id).value;
        if (adet>stok){
            $('#yorum_uyari').addClass('uyari_kirmizi').fadeIn().html("Stokda sadece "+stok+" adet ürün var.");
        }
        else {
            $.ajax({
                    type: "POST",
                    url: 'sepet/adet/'+id+'/'+adet,
                    success: function (data)
                    {

                        if (data==="ok"){
                            location.reload();
                        } else {
                            $('#yorum_uyari').addClass('uyari_kirmizi').fadeIn().html(data);
                        }
                    },
                }
            );
        }


    }

    function kupon(){

        var vouchers=document.getElementById('vouchers').value;

        $.ajax({
                type: "POST",
                url: 'sepet/voucher/'+vouchers,
                success: function (data)
                {
                    if (data==="ok"){
                        location.reload();
                    } else {
                        $('#yorum_uyari').addClass('uyari_kirmizi').fadeIn().html(data);
                        $('html,body').stop().animate({scrollTop:"0"},500);
                    }
                },
            }
        );



    }
</script>
