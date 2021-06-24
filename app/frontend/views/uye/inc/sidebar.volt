<div class="syf_sidebar">
    <h3>Hesabım</h3>
    <span>{% if user_info is defined %}{{ user_info }}{% endif %}</span>

    <ul>
        <li><a class="{% if uyepage is 'favori' %}fw700{% endif %}" href="{{ url('uye/favori') }}">{{ cevir._('favorilerim') }}</a></li>
        <li><a class="{% if uyepage is 'siparis' %}fw700{% endif %}" href="{{ url('uye/siparis') }}">{{ cevir._('siparislerim') }}</a></li>
        <li><a class="{% if uyepage is 'puan' %}fw700{% endif %}" href="{{ url('uye/puan') }}">{{ cevir._('puanlarim') }}</a></li>
        <li><a class="{% if uyepage is 'bilgi' %}fw700{% endif %}" href="{{ url('uye/bilgi') }}">{{ cevir._('kullanici_bilgilerim') }}</a></li>
        <li><a class="{% if uyepage is 'kupon' %}fw700{% endif %}" href="{{ url('uye/kupon') }}">{{ cevir._('indirim_kuponlarim') }}</a></li>
        <li><a class="{% if uyepage is 'adres' %}fw700{% endif %}" href="{{ url('uye/adres') }}">{{ cevir._('adres_bilgilerim') }}</a></li>
        <li><a class="{% if uyepage is 'bildirim' %}fw700{% endif %}" href="{{ url('uye/bildirim') }}">{{ cevir._('bildirim_tercihleri') }}</a></li>
        <li><a class="{% if uyepage is 'odeme' %}fw700{% endif %}" href="{{ url('uye/odeme') }}">{{ cevir._('odeme_bildirimi') }}</a></li>
        <li><a href="{{ url('uye/cikis') }}">{{ cevir._('cikis') }}</a></li>
    </ul>
</div>