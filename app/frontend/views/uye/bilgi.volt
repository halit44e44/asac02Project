 <div class="sayfa">
    <div class="syf_ort">

        {{ partial('uye/inc/sidebar') }}

        <div class="syf_icerik">
            <h2><span>{{ cevir._('hesap_bilgilerim') }}</span></h2>
            <div class="uyari uyari_kirmizi mb-0 bru dn" id="uyari" style="">İşlem yapma yetkiniz yoktur!</div>
            <!--işlem sonrası mesaj başlar-->
            <div class="syf_mesaj hata dn"></div>
            <!--işlem sonrası mesaj biter-->

            <!--hesap bilgilerim başlar-->
            <form id="bilgiForm">
                <div class="syf_mbolum">
                    <h5><span>{{ cevir._('kullanici_bilgilerim') }}</span></h5>
                    <div class="frm_kutu">
                        <span><span>{{ cevir._('ad_ve_soyad') }}</span></span>
                        <input type="text" name="name" id="name" value="{{ user.name }}">
                    </div>

                    <div class="frm_kutu">
                        <span><span>{{ cevir._('cep_telefonu') }}</span></span>
                        <input type="text" name="phone" id="phone" value="{{ user.phone }}">
                    </div>

                    <div class="frm_kutu">
                        <span>{{ cevir._('tc_kimlik_no') }}</span>
                        <input type="text" name="id_no" id="id_no" value="{{ user.idno }}">
                    </div>

                    <div class="frm_kutu">
                        <span>{{ cevir._('dogum_tarihiniz') }}</span>
                        <div class="frmk_ic">

                            <select name="gun" id="gun" class="mini3">
                                <option value="00">{{ cevir._('gun') }}</option>
                                {% set day = date('d', user.birth_date) %}
                                {% for days in 1..31 %}
                                    <option value="{{ days }}" {% if days is day %}selected{% endif %}>{{ days }}</option>
                                {% endfor %}
                            </select>

                            <select name="ay" id="ay" class="mini3">
                                <option value="00">{{ cevir._('ay') }}</option>
                                {% set month = date('m', user.birth_date) %}
                                {% for months in 1..12 %}
                                    <option value="{{ months }}" {% if months is month %}selected{% endif %}>{{ months }}</option>
                                {% endfor %}
                            </select>

                            <select name="yil" id="yil" class="mini3">
                                <option value="0000">{{ cevir._('yil') }}</option>
                                {% set year = date('Y', user.birth_date) %}
                                {% for years in 1950..date('Y')-10 %}
                                    <option value="{{ years }}" {% if years is year %}selected{% endif %}>{{ years }}</option>
                                {% endfor %}
                            </select>

                        </div>
                    </div>

                    <div class="frm_kutu">
                        <span>{{ cevir._('cinsiyetiniz') }}</span>
                        <div class="frmk_ic">
                            <label class="mini3" for="erkek"><input type="radio" name="gender" class="gender" value="1" id="erkek" {% if user.gender is 1 %}checked{% endif%} />{{ cevir._('erkek') }}</label>
                            <label class="mini3" for="kadin"><input type="radio" name="gender" class="gender" value="2" id="kadin" {% if user.gender is 2 %}checked{% endif%} />{{ cevir._('kadin') }}</label>
                        </div>
                    </div>

                    <div class="frm_kutu">
                        <a href="javascript:;" value="Güncelle" class="btn btn_sari fr" id="uyeBilgi">{{ cevir._('guncelle') }}</a>
                    </div>
                </div>
            </form>
            <!--hesap bilgileim biter-->

            <div class="syf_mbolum">
                <!--sifre guncelle başlar-->
                <form id="sifreForm">
                    <h5>{{ cevir._('sifre_guncelle') }}</h5>
                    <div class="frm_kutu">
                        <span>{{ cevir._('su_anki_sifre') }}</span>
                        <input type="password" name="password" id="password">
                    </div>

                    <div class="frm_kutu">
                        <span>{{ cevir._('yeni_sifre') }}</span>
                        <input type="password" name="password1" id="password1">
                    </div>

                    <div class="frm_kutu">
                        <span>{{ cevir._('yeni_sifre_tekrar') }}</span>
                        <input type="password" name="password2" id="password2">
                    </div>

                    <div class="frm_kutu">
                        <a href="javascript:;" class="btn btn_sari fr" id="uyeSifre">{{ cevir._('guncelle') }}</a>
                    </div>
                </form>
                <!--sifre guncele biter-->

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