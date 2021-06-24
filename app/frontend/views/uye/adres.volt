<div class="sayfa">
    <div class="syf_ort">

        {{ partial('uye/inc/sidebar') }}

        <div class="syf_icerik pr">
            <h2>{{ cevir._('adreslerim') }}</h2>
            <div class="yeni_adres hesabim_toolbar">
                <a href="#yeni_adres_ekle" class="openModal" rel="modal:open">
                    <i class="fas fa-plus"></i>
                    <span>{{ cevir._('yeni_adres_ekle') }}</span>
                </a>
            </div>
            <!--işlem sonrası mesaj başlar-->
            <div class="syf_mesaj hata dn ">{{ cevir._('adres_eklenildi_text') }}</div>
            <!--işlem sonrası mesaj biter-->

            <div class="syf_bolum">

                {% if adresler is defined %}
                    {% for adres in adresler %}
                        <div class="adres" id="adres_{{ adres.id }}">
                            <div class="adres_kutu">
                                <h5>
                                    {{ adres.name }}
                                    <a href="javascript:;" data-id="{{ adres.id }}" class="fas fa-times adresSil"></a>
                                    <a title="Adresi düzenle" href="javascript:;" data-id="{{ adres.id }}" class="ajax_link fas fa-edit adresDuzenle"></a>
                                </h5>
                                <p>{{ adres.user_info }}</p>
                                <p>{{ adres.phone }}</p>
                                <p>{{ adres.address }}</p>
                            </div>
                        </div>
                    {% endfor %}
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
<div id="yeni_adres_ekle" class="modal p10-0">
    <div class="mini_kutu mini_kutu_fix">
        <h3>{{ cevir._('yeni_adres_ekle') }}</h3>
        <form method="POST" class="fkontrol" id="adresForm">
            <input type="hidden" name="type" value="insert" />
            <div class="frm_kutu">
                <label>{{ cevir._('adres_basligi') }}</label>
                <input type="text" name="name" class="name">
            </div>

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

            <div class="frm_kutu">
                <a href="javascript:;" class="btn_w100 adresEkle">{{ cevir._('kaydet') }}</a>
            </div>
        </form>
        <div class="cl"></div>
    </div>
</div>

<div id="adres_duzenle" class="modal p10-0"></div>