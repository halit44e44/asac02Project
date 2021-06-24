<div class="sayfa">
    <div class="syf_ort">
        <div class="filitre">

            <!--ismail ekleme başlar--> 
            <a href="javascript:void(0);" id="flitre_menu">Detaylı filitre<i class="fas fa-plus"></i></a>
            <script>
                $('#flitre_menu').click(function() {
                    $('.fcerceve').slideToggle();
                });
            </script>
            <!--ismail ekleme biter-->

            <div class="fcerceve">
                <div class="kbaslik">
                    <h2>{{ cats.name }}</h2>
                    <!--ustkategorisi var ise başlar-->
                    {% if topcat is defined %}
                        <a href="{{ url('kategori/' ~ topcat.sef) }}"><i class="fas fa-arrow-left mr10"></i>{{ topcat.name }}</a>
                    {% endif %}
                    <!--ustkategorisi var ise biter-->
                </div>

                {% if sub is defined %}
                    <ul class="akategori">
                        {% for sub in sub %}
                            <li><a href="{{ url('kategori/' ~ sub.sef) }}">{{ sub.name }}<i class="fas fa-angle-right"></i></a></li>
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
                       {{ price }}
                    </ul>

                </div>

                <div class="flt">
                    <h3>{{ cevir._('markalar') }}</h3>
                    <ul class="flist">
                       {{ marka }}
                    </ul>
                </div>

                <div class="flt flt_btn">
                    <a href="javascript:filter()" class="btn btn_mavi btn_w100g">{{ cevir._('sifirla') }}</a>
                </div>

            </div>
        </div>

        {% if cats.top_info is not null %}
        <div id="top_info">
            {{ cats.top_info }}
        </div>
        {% endif %}

        <div class="urunler">
            <div class="uflt">
                <ul>
                    <li><a href="javascript:;" class="aktif" id="coksatanlar" data-name="coksatanlar"><i class="fas fa-award"></i>{{ cevir._('cok_satanlar') }}</a></li>
                    <li><a href="javascript:;" id="enyeniler" data-name="enyeniler"><i class="fas fa-fire"></i>{{ cevir._('en_yeniler') }}</a></li>
                    <li><a href="javascript:;" id="endusukfiyat" data-name="endusukfiyat"><i class="fas fa-arrow-down"></i>{{ cevir._('en_dusuk_fiyat') }}</a></li>
                    <li><a href="javascript:;" id="enyuksekfiyat" data-name="enyuksekfiyat"><i class="fas fa-arrow-up"></i>{{ cevir._('en_yuksek_fiyat') }}</a></li>
                </ul>
            </div>
            <div class="urn_cerceve mh900" id="listcats"></div>
        </div>

        {% if cats.sub_info is not null %}
            <div id="sub_info">
                {{ cats.sub_info }}
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
    kat_icerikler({{ cats.id }}, "coksatanlar", "first");
    function kat_icerikler(id, order, position) {

        let limit = '0,10';
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
            data: 'cat_id={{ cats.id }}&limit='+limit+'&camp='+order+minmax+brand,
            success: function (data) {
                $('#listcats').html('');
                $('.urn-pagination').html('');
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
                    if (u.discount_text != "null"){
                        urun += '<div class="discount_area l20 t20">'+u.discount_text+'</div>';
                    }
                    urun += '</div>';

                    urun += '<div class="noc">';
                    urun += '<h3><a href="{{ url('urun/') }}'+u.sef+'">'+u.name+'</a></h3>';
                    urun += '<div class="kfiyat">';
                    urun += '<div class="kfiyat_son">'+u.total_price+' '+rate+'</div>';
                    if (u.discount_text != "null"){
                        urun += '<del>'+u.sale_price+' '+rate+'</del>';
                    }

                    urun += '</div>';
                    urun += '</div>';
                    urun += '</div>';
                    $('#listcats').append(urun);

                });


                $('#listcats').paginathing({
                    perPage: 12,
                    limitPagination:{{ total_page }},
                    containerClass: 'urn-pagination',
                    pageNumbers: false
                });
            }, error: function () {
                $('#listcats').html('');
            }
        });

    }

    $(document).ready(function () {
        var grd = function(){
            $("input[type='radio']").click(function() {
                var previousValue = $(this).attr('previousValue');
                var name = $(this).attr('name');

                if (previousValue === 'checked') {
                    $('input[type=radio]').prop('checked', function () {
                        return this.getAttribute('checked') == 'checked';
                    });
                    const  name=$('.aktif').data('name');

                    kat_icerikler({{ cats.id }}, name, "tab");
                    $('.urn-pagination').remove();
                    $(this).attr('previousValue', false);
                } else {
                    $("input[name="+name+"]:radio").attr('previousValue', false);
                    $(this).attr('previousValue', 'checked');
                }
            });
        };

        grd('1');
        $('#coksatanlar').click(function () {
            clearActive('coksatanlar');
            kat_icerikler({{ cats.id }}, "coksatanlar", "tab");
        });
        $('#enyeniler').click(function () {
            clearActive('enyeniler');
            kat_icerikler({{ cats.id }}, "enyeniler", "tab");
        });
        $('#endusukfiyat').click(function () {
            $('#listcats').html('');
            clearActive('endusukfiyat');
            kat_icerikler({{ cats.id }}, "endusukfiyat", "tab");
        });
        $('#enyuksekfiyat').click(function () {
            clearActive('enyuksekfiyat');
            kat_icerikler({{ cats.id }}, "enyuksekfiyat", "tab");
        });

        $('#fiyatFiltre').click(function () {
            kat_icerikler({{ cats.id }}, "coksatanlar", "minmax");
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
                kat_icerikler({{ cats.id }}, "coksatanlar", "minmax");
            }
        });

        $('input:radio[name="brand_id"]').change(function(){
            if ($(this).is(':checked')) {
                const val = $(this).val();
                kat_icerikler({{ cats.id }}, "coksatanlar", "brand");
                $('.urn-pagination').remove();

            }
        });


    });

    function clearActive(el) {

        $('#coksatanlar').removeClass('aktif');
        $('#enyeniler').removeClass('aktif');
        $('#endusukfiyat').removeClass('aktif');
        $('#enyuksekfiyat').removeClass('aktif');

        $('#'+el).addClass('aktif');

        $('#listcats').html('');
        $('.urn-pagination').remove();
    }
    function filter(){
        $('input[type=radio]').prop('checked', function () {
            return this.getAttribute('checked') == 'checked';
        });
        $('.min').val("");
        $('.max').val("");
        kat_icerikler({{ cats.id }}, "coksatanlar", "first");
        clearActive('coksatanlar');

    }



</script>

<script type="text/javascript" src="assets/frontend/js/paginathing.js"></script>
