<div class="sayfa">
    <div class="syf_ort">
        <div class="filitre">
            <div class="fcerceve">
                <div class="kbaslik">
                    <h2>{% if content is defined %}{{ content.name }}{% endif %}</h2>
                    <a href="{{ url('') }}"><i class="fas fa-arrow-left mr10"></i>{{ cevir._('anasayfa') }}</a>
                </div>

                <div class="flt">
                    <h3>{{ cevir._('markalar') }}</h3>
                    <ul class="flist pl-10">
                        {% if brands is defined %}
                            {% for brand in brands %}
                                <li><a href="{{ url('marka/' ~ brand.sef) }}">{{ brand.name }}</a></li>
                            {% endfor %}
                        {% endif %}
                    </ul>
                </div>

            </div>
        </div>

        {% if content.top_info is not null %}
            <div id="top_info">
                {{ content.top_info }}
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
            <div class="urn_cerceve" id="listcats"></div>
        </div>

        {% if content.sub_info is not null %}
            <div id="sub_info">
                {{ content.sub_info }}
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
    //ilk cagirmada tum kategoriye gore getiriyor ondan değer 0 verilmiş.
    marka_icerikler({{ content.id }}, "coksatanlar");
    function marka_icerikler(id, position) {

        $.ajax({
            type: 'post',
            url: '{{ url("api/v4/brand") }}/',
            data: 'brand_id='+id+'&position='+position,
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
                $('#listcats').paginathing({
                    perPage: 12,
                    limitPagination:{{ total_page }},
                    containerClass: 'urn-pagination',
                    pageNumbers: false
                });

            },error: function () {
                $('.urn_cerceve').html('');
            }
        });

    }

    $(document).ready(function () {
        $('#coksatanlar').click(function () {
            clearActive('coksatanlar');
            marka_icerikler({{ content.id }}, "coksatanlar");
        });
        $('#enyeniler').click(function () {
            clearActive('enyeniler');
            marka_icerikler({{ content.id }}, "enyeniler");
        });
        $('#endusukfiyat').click(function () {
            clearActive('endusukfiyat');
            marka_icerikler({{ content.id }}, "endusukfiyat");
        });
        $('#enyuksekfiyat').click(function () {
            clearActive('enyuksekfiyat');
            marka_icerikler({{ content.id }}, "enyuksekfiyat");
        });

    });

    function clearActive(el) {

        $('#coksatanlar').removeClass('aktif');
        $('#enyeniler').removeClass('aktif');
        $('#endusukfiyat').removeClass('aktif');
        $('#enyuksekfiyat').removeClass('aktif');
        $('.urn-pagination').remove();
        $('#'+el).addClass('aktif');

        $('.urn_cerceve').html('');
    }
</script>
<script type="text/javascript" src="assets/frontend/js/paginathing.js"></script>