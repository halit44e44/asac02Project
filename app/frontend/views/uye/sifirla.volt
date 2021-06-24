<div class="sayfa">
    <div class="mini_kutu">
        <a href="{{ url('uye/giris') }}" class="fas fa-times"></a>
        <h3>{{ cevir._('sifremi_unuttum') }}</h3>

        <div class="frm_kutu bilgi tm">
            {{ cevir._('sifremi_unuttum_text') }}
        </div>

        <form method="POST" id="uyeSifirlaForm">
            <div class="frm_kutu">
                <input type="text" name="email" id="email" placeholder="{{ cevir._('email_adresiniz') }}">
                <i class="far fa-user"></i>
            </div>

            <div class="frm_kutu bilgi sbg tm hata dn"></div>

            <div class="frm_kutu">
                <a href="javascript:;" id="uyeSifirla" class="btn_w100">Gönder<i class="fas fa-angle-right"></i></a>
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