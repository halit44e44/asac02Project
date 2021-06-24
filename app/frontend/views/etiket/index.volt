<div class="sayfa">
    <div class="syf_ort">
        <div class="filitre">
            <div class="fcerceve">
                <div class="kbaslik">
                    <h2>{% if tags is defined %}{{ tags.name }}{% endif %}</h2>
                </div>

                {% if cats is defined %}
                    <ul class="akategori">
                        {% for cat in cats %}
                            <li><a href="{{ url('kategori/' ~ cat.sef) }}">{{ cat.name }}<i class="fas fa-angle-right"></i></a></li>
                        {% endfor %}
                    </ul>
                {% endif %}



                <div class="flt">
                    <h3>{{ cevir._('fiyat_araligi') }}</h3>

                    <div class="aralik">
                        <input type="text" name="min" min="0" class="min">
                        <input type="text" name="max" min="0" class="max">
                        <i class="fas fa-arrow-right" id="fiyatFiltre"></i>
                    </div>

                    <ul class="flist">
                        {% if price is defined %}{{ price }}{% endif %}
                    </ul>
                </div>

                <div class="flt">
                    <h3>{{ cevir._('markalar') }}</h3>
                    <ul class="flist">
                        {% if marka is defined %}{{ marka }}{% endif %}
                    </ul>
                </div>

            </div>
        </div>

        {% if tags.top_info is not null %}
        <div id="top_info">
            {{ tags.top_info }}
        </div>
        {% endif %}

        <div class="urunler">
            <div class="uflt">
                <ul>
                    <li><a href="javascript:;" class="aktif" id="coksatanlar"><i class="fas fa-award"></i>{{ cevir._('cok_satanlar') }}</a></li>
                    <li><a href="javascript:;" id="enyeniler"><i class="fas fa-fire"></i>{{ cevir._('en_yeniler') }}</a></li>
                    <li><a href="javascript:;" id="endusukfiyat"><i class="fas fa-arrow-down"></i>{{ cevir._('en_dusuk_fiyat') }}</a></li>
                    <li><a href="javascript:;" id="enyuksekfiyat"><i class="fas fa-arrow-up"></i>{{ cevir._('en_yuksek_fiyat') }}</a></li>
                </ul>
            </div>

            <div class="urn_cerceve">

            </div>

        </div>

        {% if tags is not null %}
        <div id="sub_info">
            {{ tags.sub_info }}
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
    kat_icerikler(0, "enyeniler", "firsat");
    function kat_icerikler(id, order, position) {


        const sef = '{% if tags is defined %}{{ tags.name }}{% endif %}';

        let minmax = '';
        const min = $('.min').val();
        const max = $('.max').val();
        if (min !== null && max !== null) {
            minmax = '&min='+min+'&max='+max;
        }

        let brand = '';
        $('input:radio[name="brand_id"]').each(function () {
            var $this = $(this);
            if (this.checked) {
                brand = '&brand_id='+$this.val();
            }
        });
        $.ajax({
            type: 'post',
            url: '{{ url("api/v4/product") }}/',
            data: 'cat_id=0&limit=12&camp='+order+minmax+brand+'&sef='+sef,
            success: function (data) {

                $('.urn_cerceve').empty();

                let urun = '';
                $.each(data, function(index, u) {
                    let id = u.id;

                    let rate = 'TL'
                    if (u.sale_rate === 2) {
                        rate = 'USD';
                    } else if (u.sale_rate === 3) {
                        rate = 'EURO';
                    }



                    image_url = u.image;
                    urun = '<div class="urn">';
                    urun += '<div class="urn_imgs">';
                    urun += '<a href="{{ url('urun/') }}'+u.sef+'" style="background:url(\'{{ url('media/') }}'+image_url+'\') center center no-repeat;"></a>';
                    urun += '</div>';

                    if (u.discount_text != "null"){
                        urun += '<div class="urn_detay">';
                        urun += '<h3><a href="{{ url('urun/') }}'+u.sef+'">'+u.name+'</a></h3>';
                        urun += '<div class="fiyat">';
                        urun += '<span>'+u.discount_text+'</span>';
                        urun += '<div class="fiyat_son">'+u.total_price+' '+rate+'</div>';
                        urun += '<del>'+u.sale_price+' '+rate+'</del>';
                        urun += '</div>';
                        urun += '</div>';
                    } else {
                        urun += '<div class="noc">';
                        urun += '<h3><a href="{{ url('urun/') }}'+u.sef+'">'+u.name+'</a></h3>';
                        urun += '<div class="kfiyat">';
                        urun += '<div class="kfiyat_son">'+u.total_price+' '+rate+'</div>';
                        urun += '</div>';
                        urun += '</div>';
                    }

                    urun += '</div>';
                    $('.urn_cerceve').append(urun);


                });

            },error:function (){
                $('.urn_cerceve').html('Aradığınız ürün bulunamadı');
            }
        });

    }

    $(document).ready(function () {
        $('#coksatanlar').click(function () {
            clearActive('coksatanlar');
            kat_icerikler(0, "coksatanlar", "tab");
        });
        $('#enyeniler').click(function () {
            clearActive('enyeniler');
            kat_icerikler(0, "enyeniler", "tab");
        });
        $('#endusukfiyat').click(function () {
            clearActive('endusukfiyat');
            kat_icerikler(0, "endusukfiyat", "tab");
        });
        $('#enyuksekfiyat').click(function () {
            clearActive('enyuksekfiyat');
            kat_icerikler(0, "enyuksekfiyat", "tab");
        });

        $('#fiyatFiltre').click(function () {
            kat_icerikler(0, "coksatanlar", "minmax");
        });

        $('input:radio[name="filterByPrice"]').change(function(){
            if ($(this).is(':checked')) {
                const minmax = $(this).val();
                const chars = minmax.split('-');
                const min = chars[0];
                const max = chars[1];
                if (min) {
                    $('.min').val(min);
                }
                if (max) {
                    $('.max').val(max);
                }
                kat_icerikler(0, "coksatanlar", "minmax");
            }
        });
        $('input:radio[name="brand_id"]').change(function(){
            if ($(this).is(':checked')) {
                const val = $(this).val();
                kat_icerikler(0, "coksatanlar", "brand");
            }
        });



    });

    function clearActive(el) {

        $('#coksatanlar').removeClass('aktif');
        $('#enyeniler').removeClass('aktif');
        $('#endusukfiyat').removeClass('aktif');
        $('#enyuksekfiyat').removeClass('aktif');

        $('#'+el).addClass('aktif');

        $('.urn_cerceve').html('');
    }
</script>
