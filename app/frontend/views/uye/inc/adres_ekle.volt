<div class="mini_kutu">
    <h3>{{ cevir._('yeni_adres_ekle') }}</h3>
    <button title="Close (Esc)" type="button" class="mfp-close color-red">×</button>
    <form method="POST" class="fkontrol" id="adresForm">
        <div class="frm_kutu">
            <label>{{ cevir._('adres_basligi') }}</label>
            <input type="text" name="name" class="name" placeholder="{{ cevir._('adres_basligi') }}">
        </div>

        <div class="frm_kutu">
            <label>{{ cevir._('ad_ve_soyad') }}</label>
            <input type="text" name="user_info" class="user_info" placeholder="{{ cevir._('ad_ve_soyad') }}">
        </div>

        <div class="frm_kutu">
            <label>{{ cevir._('cep_telefonu') }}</label>
            <input type="text" name="phone" class="phone" placeholder="{{ cevir._('cep_telefonu') }}">
        </div>

        <div class="frm_kutu">
            <select name="ulke" class="mini2 ulkeler">
                <option value="0">{{ cevir._('ulke') }}</option>
                {% if ulkeler is defined %}
                    {% for ulke in ulkeler %}
                        <option value="{{ ulke.id }}">{{ ulke.name }}</option>
                    {% endfor %}
                {% endif %}
            </select>

            <select name="sehir" class="mini2 sehirler">
                <option value="0">{{ cevir._('sehir') }}</option>
            </select>
        </div>

        <div class="frm_kutu">
            <select name="ilce" class="mini2 ilceler">
                <option value="0">{{ cevir._('ilce') }}</option>
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