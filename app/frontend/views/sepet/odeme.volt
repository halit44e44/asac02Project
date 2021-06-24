<form method="post">
    {% if cargocity(adres.city_id,adres.town_id)=="true" %}
        <input name="cargo" type="hidden"  value="0">
        <input name="price" type="hidden" value="{% if user is defined %}{{ sepettoplam(user,user) }}{% endif %}" >
    {% elseif cargo is not null %}
        {% if round(sepettoplam(user,user)-cargo)>=0 %}
            <input name="cargo" type="hidden"  value="0">
            <input name="price" type="hidden" value="{% if user is defined %}{{ sepettoplam(user,user) }}{% endif %}" >
        {% else %}
            <input name="price" type="hidden" value="{{ cargo(user,user)+sepettoplam(user,user) }}">
            <input name="cargo" type="hidden"  value="{% if user is defined %}{{ cargo(user,user) }} {% endif %}">
        {% endif %}
    {% else %}
        <input name="price" type="hidden" value="{{ cargo(user,user)+sepettoplam(user,user) }}">
        <input name="cargo" type="hidden"  value="{% if user is defined %}{{ cargo(user,user) }} {% endif %}">
    {% endif %}

    <input name="odeme" id="odeme" type="hidden" value="5">
    <input name="adress" id="adress" type="hidden" value="{{ dist(adres.dist_id) }} mah. {{ adres.address }} {{ adres.zip_code }} -{{ city(adres.city_id) }} / {{ town(adres.town_id) }}">
    <input name="faturaadres" id="faturaadres" type="hidden" value="{{ dist(faturaadres.dist_id) }} mah. {{ faturaadres.address }} {{ faturaadres.zip_code }} -{{ city(faturaadres.city_id) }} / {{ town(faturaadres.town_id) }}">
    <div class="sayfa">
        <div class="syf_ort">
            <div class="siparis_kutu">
                <div class="adimlar">
                    <div class="adim">

                        <h4>Adres Bilgileri</h4>
                        <div class="aadres">
                            <h5>{{ adres.name }}</h5>
                            <span>{{ dist(adres.dist_id) }} mah. {{ adres.address }} {{ adres.zip_code }} -{{ city(adres.city_id) }} / {{ town(adres.town_id) }}</span>
                        </div>
                    </div>
                    <div class="adim aktif">
                        <h4>Ödeme Seçenekleri<i class="fas fa-check"></i></h4>
                        <span>Ödemenizi güvenle kredi kartı ve ya kapıda ödeme seçenekleri ile yapabilrisiniz.</span>
                    </div>
                </div>

                <div class="odeme_yontem">
                    {% for method in paymentMethods() %}
                        {% if method is not null %}

                            {% if method.sef is 'kredi_karti' %}
                                <div class="odmy aktif">
                                    <h4 data-sef="{{ method.sef }}" data-id="{{ method.id }}" class="aktif_odeme" id="{{ method.sef }}">{{ method.name }}<i id="i_kredi" class="fas fa-angle-down"></i></h4>
                                    <div class="kart_odeme odmy_kutu" id="content_{{ method.sef }}">
                                        <div class="kart_bilgi">
                                            <h5>Kart Bilgileri</h5>
                                            <div class="kform">
                                                <span>Kart Numarası</span>
                                                <input type="number" name="">
                                            </div>

                                            <div class="kform">
                                                <div class="skullanma">
                                                    <span>Son Kullanma</span>
                                                    <select name="">
                                                        <option value="0">Ay</option>
                                                        {% for ay in 1..31 %}
                                                        <option value="{{ ay }}">{{ ay }}</option>
                                                        {% endfor %}
                                                    </select>

                                                    <select name="">
                                                        <option value="0">Yıl</option>
                                                        {% for yil in  date('Y')..date('Y')+10%}
                                                            <option value="{{ yil }}">{{ yil }}</option>
                                                        {% endfor %}
                                                    </select>
                                                </div>

                                                <div class="cvv">
                                                    <span>Güvenlik</span>
                                                    <input type="number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="taksit">
                                            <h5>Taksit Seçenekleri</h5>
                                            <span>Kartınıza uygun taksit seçenekleri</span>
                                            <div class="tsecenekler">Kart bilgilerinizi girdikten sonra taksit seçebeklerini bu alanda seçebilirsiniz.</div>
                                        </div>
                                    </div>
                                </div>
                            {% endif %}

                            {% if method.sef is 'havale' %}
                                <div class="odmy">
                                    <h4 data-sef="{{ method.sef }}" data-id="{{ method.id }}" id="{{ method.sef }}">{{ method.name }}<i id="i_havale" class="fas fa-angle-right"></i></h4>
                                    <div class="odmy_kutu p10 bsbb" id="content_{{ method.sef }}" style="display: none;">
                                        <div class="uyari uyari_yesil">EFT/Havale ile ödeme yaptıkdan sonra lütfen ödeme bildirimi yapınız!</div>
                                        {% for bank in bank %}
                                            <div class="syf_bolum">
                                                <div class="adres" id="adres_1">
                                                    <div class="adres_kutu">
                                                        <p class="fw700"> {% if bank.name is defined %}{{ bank.name }} {% endif %}</p>
                                                        <p>{% if bank.name is defined %}Hesap Sahibi: {{ bank.owner }} {% endif %}</p>
                                                        <p>{% if bank.iban is defined %}Iban {{ bank.iban }} {% endif %}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        {% endfor %}

                                    </div>
                                </div>
                            {% endif %}

                            {% if method.sef is 'kapida_nakit' %}
                                <div class="odmy">
                                    <h4 data-sef="{{ method.sef }}" data-id="{{ method.id }}" id="{{ method.sef }}">{{ method.name }}<i  id="i_kapi" class="fas fa-angle-right"></i></h4>
                                    <div class="odmy_kutu p10 bsbb" id="content_{{ method.sef }}" style="display: none;">
                                        <div class="uyari uyari_yesil">Kapıda ödeme seneçeneği ile yapacağınız ödemelerinizi kapida kargo görevlisine yapabilirsiniz.</div>
                                        {% if method.sef is 'kapida_nakit' %}
                                            <p class="mb-20"><label class="fs14" for="kapida_nakit">Kapıda Nakit Ödeme <input type="checkbox" checked value="ok" name="sozlesme" id="kapida_nakit" class="fl big-checkbox"></label></p>
                                        {% endif %}
                                    </div>
                                </div>
                            {% endif %}

                            {% if method.sef is 'kapida_kredikarti' %}
                                <div class="odmy">
                                    <h4 data-sef="{{ method.sef }}" data-id="{{ method.id }}" id="{{ method.sef }}">{{ method.name }}<i  id="i_kapi" class="fas fa-angle-right"></i></h4>
                                    <div class="odmy_kutu p10 bsbb" id="content_{{ method.sef }}" style="display: none;">
                                        <div class="uyari uyari_yesil">Kapıda ödeme seneçeneği ile yapacağınız ödemelerinizi kapida kargo görevlisine yapabilirsiniz.</div>
                                        {% if method.sef is 'kapida_kredikarti' %}
                                            <p><label class="fs14" for="kapida_kredi">Kapıda Kredi Kartı ile Ödeme <input type="checkbox" checked value="ok" name="sozlesme" id="kapida_kredi" class="fl big-checkbox"></label></p>
                                        {% endif %}
                                    </div>
                                </div>
                            {% endif %}

                        {% endif %}
                    {% endfor %}
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
                                {% if cargocity(adres.city_id,adres.town_id)=="true" %}
                                    <span>{{  cevir._('ucretsiz_kargo') }}</span>
                                {% elseif cargo is not null %}
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
                                {% if cargocity(adres.city_id,adres.town_id)=="true" %}
                                <span>{% if user is defined %}{{ sepettoplam(user) }}{% endif %}</span>
                                {% elseif cargo is not null %}
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


                </div>
                <input type="checkbox" id="hediye_paketi" class="sepet_hediye_checkbox big-checkbox" value="1" name="gift_package">
                <label class="sepet_hediye_label" for="hediye_paketi">Hediye paketi istiyorum</label>
                <div class="souf">
                    <select name="cargo_firma" class="cargo_firma">
                        {% for cargofirma in cargofirma %}
                            <option value="{{ cargofirma.id }}">{{ cargofirma.name }}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class="souf">
                    <textarea name="gift_note" class="siparis_not" placeholder="Sipariş notunuz"></textarea>
                </div>

                <button type="submit" class="btn_w100">ÖDEMEYİ TAMAMLA<i class="fas fa-angle-right"></i></button>
            </div>

    </div>

</form>
{% if cerez.value is defined%}
    <input id="cerez" type="hidden" data-baslik="{{ cerez.value }}">
    <script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
    <script>
        var baslik=$('#cerez').data('baslik');
        window.start.init({Palette:"palette1",Theme:"wire",Mode:"floating left",Time:"1",LinkText:"Detaylı bilgi almak için tıklayınız",Location:"{{ url('sayfa/gizlilik-ve-cerez-politikasi') }}",Message:baslik,ButtonText:"kabul et",})
    </script>
{% endif %}
<script>
    $(document).ready(function () {
        $('.odmy h4').click(function () {
            const sef = $(this).data('sef');
            cleanBars();
            $('#'+sef).addClass('aktif_odeme');
            $('#'+sef+' i').removeClass('fas fa-angle-right').addClass('fas fa-angle-down');
            $('#content_'+sef).slideDown();
            $('#odeme').val( $(this).data('id'))

        });
    });

    function cleanBars() {
        $('.odmy h4').each(function () {
            $(this).removeClass('aktif_odeme');
            $(".odmy_kutu").slideUp();
            $('.odmy h4 i').removeClass('fas fa-angle-down').addClass('fas fa-angle-right')
        });
    }

</script>