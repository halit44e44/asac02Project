<div class="sayfa">
    <div class="syf_ort">

        {{ partial('uye/inc/sidebar') }}

        <div class="syf_icerik">
            <h2>{{ cevir._('indirim_kuponlarim') }}</h2>
            <div class="syf_bolum">
                {% if userId is defined  %}
                    {{ voucher(userId) }}
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