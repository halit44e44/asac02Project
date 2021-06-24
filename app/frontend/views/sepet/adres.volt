<input type="hidden" id="fatura_adresi">
<input type="hidden" id="teslimat_adresi">

<div class="sayfa">
    <div class="syf_ort">
        <div class="uyari" id="yorum_uyari" style="display: none"></div>
        <div class="siparis_kutu">
            <div class="adimlar">
                <div class="adim aktif">
                    <h4>{{ cevir._('adres_bilgileri') }}</h4>
                    <div class="aadres">
                        <h5></h5>
                        <span></span>
                    </div>
                </div>
                <div class="adim">
                    <h4>{{ cevir._('odeme_secenekleri') }}</h4>
                    <span>Ödemenizi güvenle kredi kartı ve ya kapıda ödeme seçenekleri ile yapabilrisiniz.</span>
                </div>

                <div class="sepet_adres_alani">
                    <div class="yeni_adres">
                        <a href="#yeni_adres_ekle" class="openModal" rel="modal:open">
                            <i class="fas fa-plus"></i>
                            <span>{{ cevir._('yeni_adres_ekle') }}</span>
                        </a>
                    </div>
                </div>

            </div>


            <div class="adres_secimi">
                <div class="asecim aktif">
                    <div class="adres_bar">
                        <h4>{{ cevir._('teslimat_adresi') }}</h4>
                    </div>
                    <div class="adres w100">
                        {% if adres is defined %}
                        {% for adres in adres %}
                            <h5>{{ adres.name }}</h5>
                            <div class="adres_kutu mb-20 teslimatadressec" data-id="{{ adres.id }}" data-title="{{ adres.name }}" data-adres="{{ dist(adres.dist_id) }} mah. {{ adres.address }} {{ adres.zip_code }} -{{ city(adres.city_id) }} / {{ town(adres.town_id) }}" id="teslimat_{{ adres.id }}">
                                <p>{{ user_info }}</p>
                                <p>{{ adres.phone }}</p>
                                <p> {{ dist(adres.dist_id) }} mah. {{ adres.address }} {{ adres.zip_code }} -{{ city(adres.city_id) }} / {{ town(adres.town_id) }}</p>
                            </div>
                        {% endfor%}
                        {% endif %}
                    </div>
                </div>


                <div class="asecim">
                    <div class="adres_bar">
                        <h4>{{ cevir._('fatura_adresi') }}</h4>
                        <i class="fas fa-check dn"></i>
                    </div>
                    {% if faturaadres is defined %}
                    {% for faturaadres in faturaadres %}
                        <div class="adres w100">
                            <h5>{{ faturaadres.name }}</h5>
                            <div class="adres_kutu faturaadressec" data-id="{{ faturaadres.id }}" id="fatura_{{ faturaadres.id }}" >
                                <p>{{ user_info }}</p>
                                <p>{{ faturaadres.phone }}</p>
                                <p> {{ dist(faturaadres.dist_id) }} mah. {{ faturaadres.address }} {{ faturaadres.zip_code }} -{{ city(faturaadres.city_id) }} / {{ town(faturaadres.town_id) }}</p>
                            </div>
                        </div>
                    {% endfor%}
                    {% endif %}
                </div>
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


            </div>

            {% if count>0%} <a href="javascript:;" id="odemeSayfasi" class="btn_w100 ttu" lang="tr">{{ cevir._('odeme_adimina_gec') }}<i class="fas fa-angle-right"></i></a> {% endif %}
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
<script>
    $(document).ready(function () {

        $('.teslimatadressec').click(function () {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const adres = $(this).data('adres');

            teslimattemizle();
            $('#teslimat_'+id).addClass('aktif_adres');
            $('.aadres h5').html(title);
            $('.aadres span').html(adres);
            $('#fatura_adresi').val(id);
            isChecked();
        });

        $('.faturaadressec').click(function () {
            const id = $(this).data('id');
            faturatemizle();
            $('#fatura_'+id).addClass('aktif_adres');
            $('#teslimat_adresi').val(id);
            isChecked()
        });

        $('#odemeSayfasi').click(function () {
            const fatura_adresi = $('#fatura_adresi').val();
            const teslimat_adresi = $('#teslimat_adresi').val();
            if (fatura_adresi.length === 0){
                $('html,body').stop().animate({scrollTop:"0"},500);
                $('#yorum_uyari').addClass('uyari_kirmizi').fadeIn().html("Lütfen Teslimat Adresini Seçiniz!");
                return false;
            } else if (teslimat_adresi.length === 0){
                $('html,body').stop().animate({scrollTop:"0"},500);
                $('#yorum_uyari').addClass('uyari_kirmizi').fadeIn().html("Lütfen Fatura Adresini Seçiniz!");
                return false;
            }
            if(fatura_adresi && teslimat_adresi) {
                window.location.href='{{ url('sepet/odeme/') }}'+teslimat_adresi+'/'+ fatura_adresi;
            }

        });

    });

    function isChecked() {
        const teslimatadressec = $('.teslimatadressec');
        const faturaadressec = $('.faturaadressec');
        if (teslimatadressec.hasClass('aktif_adres') && faturaadressec.hasClass('aktif_adres')) {
            $('.fa-check').removeClass('dn');
        }
    }

    function teslimattemizle() {
        $('.teslimatadressec').each(function () {
            $(this).removeClass('aktif_adres');
        })
    }

    function faturatemizle() {
        $('.faturaadressec').each(function () {
            $(this).removeClass('aktif_adres');
        })
    }
</script>

<div id="yeni_adres_ekle" class="modal p10-0">
    <div class="mini_kutu mini_kutu_fix">
        <h3>{{ cevir._('yeni_adres_ekle') }}</h3>
        <div class="syf_mesaj hata uyari dn ">{{ cevir._('adres_eklenildi_text') }}</div>
        <form method="POST" class="fkontrol" id="adresForm">
            <input type="hidden" name="type" value="insert" />
            <div class="frm_kutu">
                <label>{{ cevir._('adres_basligi') }}</label>
                <input type="text" name="name" class="name">
            </div>
            {% if session=="ok" %}
                <div class="frm_kutu">
                    <label>{{ cevir._('email') }}</label>
                    <input type="text" name="email" class="email">
                </div>
            {% endif %}
            <div class="frm_kutu">
                <label>{{ cevir._('ad_ve_soyad') }}</label>
                <input type="text" name="user_info" class="user_info">
            </div>

            <div class="frm_kutu">
                <label>{{ cevir._('cep_telefonu') }}</label>
                <input type="text" name="phone" class="phone">
            </div>

            <div class="frm_kutu">
                <select name="country" class="mini2 country">
                    <option value="0">{{ cevir._('ulke') }}</option>
                    {% if ulkeler is defined %}
                        {% for ulke in ulkeler %}
                            <option value="{{ ulke.CountryID }}">{{ ulke.CountryName }}</option>
                        {% endfor %}
                    {% endif %}
                </select>

                <select name="city" class="mini2 city">
                    <option value="0">{{ cevir._('sehir') }}</option>
                </select>
            </div>

            <div class="frm_kutu">

                <select name="town" class="mini2 town">
                    <option value="0">{{ cevir._('ilce') }}</option>
                </select>

                <select name="district" class="mini2 district">
                    <option value="0">{{ cevir._('belde') }}</option>
                </select>
            </div>

            <div class="frm_kutu">
                <select name="neighborhood" class="mini2 neighborhood">
                    <option value="0">{{ cevir._('mahalle') }}</option>
                </select>

                <input type="text" name="zip_code" placeholder="{{ cevir._('posta_kodu') }}" class="mini2 zip_code">
            </div>

            <div class="frm_kutu">
                <label>{{ cevir._('adres') }}</label>
                <textarea name="address" class="address"></textarea>
            </div>

            {% if session=="ok" %}
                <div class="frm_kutu">
                    <a href="javascript:;" class="btn_w100 adresEklesesion">{{ cevir._('kaydet') }}</a>
                </div>
                {% else %}
                    <div class="frm_kutu">
                        <a href="javascript:;" class="btn_w100 adresEkle">{{ cevir._('kaydet') }}</a>
                    </div>
            {% endif %}

        </form>

    </div>
</div>
