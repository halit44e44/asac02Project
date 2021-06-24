<div class="sayfa">
    <div class="mini_kutu">
        <h3>{{ cevir._('uye_girisi') }}</h3>

        {% if ilkgiris is defined %}
            <div class="frm_kutu bilgi yesil tm hata">{{ cevir._('giris_basarili_text') }}</div>
        {% endif %}

        <div class="frm_kutu bilgi">
            Eğer üye değilseniz <a href="{{ url('uye/kayit') }}">üye kayıt</a> sayfasından üye olabilirsiniz.
        </div>

        <form method="POST" id="uye_giris">
            <div class="frm_kutu">
                <input type="text" name="email" id="email" placeholder="{{ cevir._('email_adresiniz') }}" value="">
                <i class="far fa-user"></i>
            </div>

            <div class="frm_kutu">
                <input type="password" name="sifre" id="password" placeholder="{{ cevir._('sifreniz') }}" value="">
                <i class="far fa-user"></i>
            </div>

            <div class="frm_kutu">
                <a href="{{ url('uye/sifirla') }}" class="sfr_unt"><i class="far fa-question-circle"></i> {{ cevir._('sifremi_unuttum') }}</a>
            </div>

            <div class="frm_kutu bilgi sbg tm hata dn"></div>

            <div class="frm_kutu">
                <a href="javascript:;" id="uyeGiris" class="btn_w100">{{ cevir._('giris') }}<i class="fas fa-angle-right"></i></a>

                <input type="text" name="ref" value="" hidden>
                <input type="submit" hidden>
            </div>
        </form>
        <div class="cl"></div>
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
