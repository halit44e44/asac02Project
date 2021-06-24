<div class="sayfa">
    <div class="mini_kutu">
        <a href="{{ url('uye/giris') }}" class="fas fa-times"></a>
        <h3>{{ cevir._('uye_kayit') }}</h3>

        <div class="frm_kutu bilgi">
            Eğer üyeyseniz <a href="{{ url('uye/giris') }}">üye giriş</a> sayfasından üye girişi yapabilirsiniz.
        </div>
        <form method="POST" id="uyeKayitForm">
            <div class="frm_kutu">
                <input type="text" name="name" id="name" placeholder="{{ cevir._('adiniz_ve_soyadiniz') }}">
                <i class="far fa-user"></i>
            </div>

            <div class="frm_kutu">
                <input type="text" name="phone" id="phone" placeholder="{{ cevir._('telefon_numaraniz') }}">
                <i class="far fa-user"></i>
            </div>

            <div class="frm_kutu">
                <input type="text" name="email" id="email" placeholder="{{ cevir._('email_adresiniz') }}">
                <i class="far fa-user"></i>
            </div>
            <div class="frm_kutu">
                <input type="text" name="tc" id="tc" placeholder="{{ cevir._('Tc Kimlik No') }}">
                <i class="far fa-user"></i>
            </div>

            <div class="frm_kutu">
                <input type="password" name="password" id="password" placeholder="{{ cevir._('sifreniz') }}">
                <i class="far fa-user"></i>
            </div>

            <div class="frm_kutu tm">
                <input type="checkbox" name="bildirim" value="1" id="bildirim" checked><label for="bildirim">Önemli kampanyalardan haberdar olmak için <a href="#aydinlatma_metni" class="openModal" rel="modal:open">Aydınlatma ve Rıza Metni</a>'ni okudum ve onaylıyorum.</label>
            </div>

            <!--eğer kayıt sırasında bir hata mesajı vs var ise başlar-->
            <div class="frm_kutu bilgi kbg hata dn"></div>
            <!--eğer kayıt sırasında bir hata mesajı vs var ise biter-->

            <div class="frm_kutu">
                <a href="javascript:;" id="uyeKayit" class="btn_w100">Üye ol<i class="fas fa-angle-right"></i></a>
            </div>
        </form>

        <div class="frm_kutu bilgi tm">
            Üye ol butonuna basarak <a href="#uyelik_sozlesmesi" class="openModal" rel="modal:open">Üyelik Sözleşmesi’ni</a> ve <a href="#gizlilik_ve_cerez" class="openModal" rel="modal:open">Gizlilik ve Çerez Politikası</a>’nı okuduğunuzu ve kabul ettiğinizi onaylıyorsunuz.
        </div>
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
<div id="aydinlatma_metni" class="modal p10-0">
    <div class="mini_kutu mini_kutu_fix scrollable">
        <h3>Aydınlatma ve Rıza Metni</h3>
        {% if aydinlatma is defined %}{{ aydinlatma.content }}{% endif %}
        <div class="cl"></div>
    </div>
</div>

<div id="uyelik_sozlesmesi" class="modal p10-0">
    <div class="mini_kutu mini_kutu_fix scrollable">
        <h3>Üyelik Sözleşmesi</h3>
        {% if uyeliksozlesme is defined %}{{ uyeliksozlesme.content }}{% endif %}
        <div class="cl"></div>
    </div>
</div>

<div id="gizlilik_ve_cerez" class="modal p10-0">
    <div class="mini_kutu mini_kutu_fix scrollable">
        <h3>Gizlilik ve Çerez Politikası</h3>
        {% if gizlilik is defined %}{{ gizlilik.content }}{% endif %}
        <div class="cl"></div>
    </div>
</div>