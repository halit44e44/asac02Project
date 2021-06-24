<div class="sayfa">
    <div class="syf_ort">
        {{ partial('uye/inc/sidebar') }}
        <div class="syf_icerik">
            <h2>{{ cevir._('iade Talebi') }}</h2>
            <div class="syf_bolum">
                <form action="{{ url('uye/odeme') }}" method="post">
                    <div class="frm_kutu">
                        <span>{{ cevir._('siparisiniz') }}</span>

                        <span name="order">
                            {% if order is defined %}
                                {% for order in order %}

                                {% endfor %}
                            {% endif %}
                        </span>

                        <!--
                        <select name="order">
                            {% if order is defined %}
                                {% for order in order %}

                                        {% if order.id == payment.order_id %}
                                            <option value="{{ order.id }}" selected="selected">{{ order( order.id) }}</option>
                                        {% else %}
                                            <option value="{{ order.id }}">{{ order( order.id) }}</option>
                                        {% endif %}

                                {% endfor %}
                            {% endif %}
                        </select>

                        -->
                    </div>

                    <div class="frm_kutu">
                        <span>{{ cevir._('banka_bilgileri') }}</span>
                        <select name="hesap_no" id="bankid" onclick="bankcontent(this)">
                            <option value="0" selected>Banka Seçiniz</option>
                            {% for bank in bank %}
                                {% if bank.id == payment.bank_id %}
                                    <option value="{{ bank.id }}" selected="selected">{{ bank.name }}</option>
                                {% else %}
                                    <option value="{{ bank.id }}">{{ bank.name }}</option>
                                {% endif %}
                            {% endfor %}
                        </select>
                    </div>
                    <div class="frm_kutu">
                        <!-- <input type="text" name="ajax" id="ajax" value="IBAN: {{ bank_content }}"> -->

                        <div name="ajax" id="ajax" value="{{ bank_content }}"></div>
                    </div>

                    <div class="frm_kutu">
                        <span>{{ cevir._('notunuz_varsa') }}</span>
                        <textarea name="note">{% if payment.note is defined %}{{ payment.note }}{% endif %}</textarea>
                    </div>

                    {% if payment is defined %}
                        {% if payment.status === "2" %}
                            <div class="frm_kutu">
                                <div class="kpn_yellow">Ödeme Bildiriminiz İletilmiştir.</div>
                            </div>
                        {% endif %}
                        {% if payment.status === "1" %}
                            <div class="frm_kutu">
                                <div class="kpn">Ödeme Bildiriminiz Onaylandı.</div>
                            </div>
                        {% endif %}
                    {% endif %}

                    <div class="frm_kutu">
                        <input type="submit" value="{{ cevir._('gonder') }}" class="btn btn_sari fr">
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function bankcontent() {
        var id = document.getElementById("bankid").value;
        $.ajax({
            type: 'POST',
            url: 'uye/bankcontent/' + '/' + id,
            data: $('#ajax').serialize(),
            success: function (response) {
                document.getElementById('ajax').innerHTML = response;
            }
        })
    }
</script>
{% if cerez.value is defined%}
    <input id="cerez" type="hidden" data-baslik="{{ cerez.value }}">
    <script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
    <script>
        var baslik=$('#cerez').data('baslik');
        window.start.init({Palette:"palette1",Theme:"wire",Mode:"floating left",Time:"1",LinkText:"Detaylı bilgi almak için tıklayınız",Location:"{{ url('sayfa/gizlilik-ve-cerez-politikasi') }}",Message:baslik,ButtonText:"kabul et",})
    </script>
{% endif %}