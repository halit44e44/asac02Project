<div class="sayfa">
    <div class="syf_ort">

        {{ partial('sayfa/inc/sidebar') }}

        {% if sayfa is defined %}
        <div class="syf_icerik">
            <h2>{{ sayfa.name }}</h2>
            <div class="syf_bolum">
                <div class="frm_kutu">
                    {{ sayfa.content }}

                    {% if sayfa.map is not null %}
                    <div class="harita">
                        <iframe src="{{ sayfa.map }}" width="870" height="250" frameborder="0" style="border:0; margin-bottom:20px;" allowfullscreen=""></iframe>
                    </div>
                    {% endif %}

                    <div class="popup-gallery">
                        {% for gallery in contentgallery(sayfa.id) %}
                        <a href="{{ url('media/content/' ~ gallery.meta_value) }}"><img src="{{ url('media/content/' ~ gallery.meta_value) }}" width="75"></a>
                        {% endfor %}
                    </div>
                </div>
            </div>
        </div>
        {% endif %}

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
<script>
    $(document).ready(function () {
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Yükleniyor #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1]
            },
            image: {
                tError: '<a href="%url%">Görsel #%curr%</a> yüklenemedi!'
            }
        });
    });
</script>