<style>
    input[type='checkbox'] {
        appearance: none;
        -webkit-appearance: none;
        height: 20px;
        width: 20px;
        background-color: #d5d5d5;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        outline: none;
    }

    label {
        color: #4c4c4c;
        font-size: 13px;
        font-family: 'Poppins', Sans-serif;
        font-weight: 90;
        cursor: pointer;
    }

    input[type="checkbox"]:checked {
        background-color: #e71232;
    }


</style>
<div class="sayfa">
    <div class="syf_ort">

        {{ partial('uye/inc/sidebar') }}
        <div class="syf_icerik">
            <h2>{{ cevir._('bildirim_tecihleri') }}</h2>
            <div class="syf_bolum">
                <form action="{{ url('uye/bildirim') }}" method="post">
                    <h5>{{ cevir._('email_bildirimleri') }}</h5>
                    <div class="frm_kutu blist">
                        <input type="checkbox" id="email_news"
                               name="email_news" {% if noti.email_news is defined %}{% if noti.email_news === "1" %}  checked {% else %}  aria-disabled="false"{% endif %}{% endif %}
                               value="1">
                        <label for="email_news">
                            <h6>{{ cevir._('kampanya_haber_duyuru') }}</h6>
                            <span>{{ cevir._('email') }}</span>
                        </label>

                    </div>
                    <div class="frm_kutu blist">
                        <input type="checkbox" id="email_order"
                               name="email_order" {% if noti.email_order is defined %}{% if noti.email_order === "1" %} checked {% else %} aria-disabled="false" {% endif %}{% endif %}
                               value="1">
                        <label for="email_order">
                            <h6>{{ cevir._('siparis_durumları') }}</h6>
                            <span>{{ cevir._('email') }}</span>
                        </label>
                    </div>

                    <h5>{{ cevir._('sms_bildirimleri') }}</h5>
                    <div class="frm_kutu blist">
                        <input type="checkbox" id="sms_new"
                               name="sms_news" {% if noti.sms_news is defined %}{% if noti.sms_news === "1" %} checked {% else %} aria-disabled="false" {% endif %}{% endif %}
                               value="1">
                        <label for="sms_new">
                            <h6>{{ cevir._('kampanya_haber_duyuru') }}</h6>
                            <span>{{ cevir._('sms') }}</span>
                        </label>

                    </div>
                    <div class="frm_kutu blist">
                        <input type="checkbox" id="sms_order"
                               name="sms_order" {% if noti.sms_order is defined %}{% if noti.sms_order === "1" %} checked {% else %} aria-disabled="false" {% endif %}{% endif %}
                               value="1">
                        <label for="sms_order">
                            <h6>{{ cevir._('siparis_durumları') }}</h6>
                            <span>{{ cevir._('sms') }}</span>
                        </label>
                    </div>


                    <div class="frm_kutu">
                        <input type="submit" value="{{ cevir._('guncelle') }}" class="btn btn_sari fr">
                    </div>
                </form>
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

