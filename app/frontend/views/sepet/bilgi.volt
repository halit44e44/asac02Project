<div class="sayfa">
    <div class="mini_kutu">
        <h3>{{ cevir._('Üye Olmadan Alışveriş') }}</h3>

        {% if ilkgiris is defined %}
            <div class="frm_kutu bilgi yesil tm hata">{{ cevir._('giris_basarili_text') }}</div>
        {% endif %}

        <form method="POST" id="uyeliksiz_giriş">
            <div class="frm_kutu">
                <input type="text" name="uyelıksiz_email" id="uyelıksiz_email" placeholder="{{ cevir._('email_adresiniz') }}" value="">
                <i class="far fa-user"></i>
            </div>
            <div class="frm_kutu">
                <input type="text" name="uyelıksiz_name" id="uyelıksiz_name" placeholder="{{ cevir._('adiniz') }}" value="">
                <i class="far fa-user"></i>
            </div>
            <div class="frm_kutu">
                <input type="text" name="uyelıksiz_phone" id="uyelıksiz_phone" placeholder="{{ cevir._('telefon') }}" value="">
                <i class="far fa-user"></i>
            </div>
            <div class="frm_kutu bilgi sbg tm hata dn"></div>
            <div class="frm_kutu">
                <a href="javascript:;" id="uyeliksiz_giris" class="btn_w100">{{ cevir._('giris') }}<i class="fas fa-angle-right"></i></a>

                <input type="text" name="ref" value="" hidden>
                <input type="submit" hidden>
            </div>
        </form>
        <div class="cl"></div>
    </div>
</div>