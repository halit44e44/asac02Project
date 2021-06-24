{% if total_product is defined %}
{% if total_product is not 0 %}
<div class="ana_urunler">
    <div class="aurunler_ort">
        <div class="au_sidebar">
            <h4>{{ cevir._('kategoriler') }}</h4>
            <ul>
                {% if maincats is defined %}
                    {% for maincat in maincats %}
                        <li><a href="{{ url('kategori/' ~ maincat.sef) }}" onmouseover="javascript:kat_icerikler({{ maincat.id }})" id="asm_{{ maincat.id }}">{{ maincat.name }}</a></li>
                    {% endfor %}
                {% endif %}
            </ul>
        </div>

        <div class="au_cerceve" id="cats">
        </div>
        <script>
            //ilk cagirmada tum kategoriye gore getiriyor ondan değer 0 verilmiş.
            kat_icerikler(0);
            function kat_icerikler(id) {
                $('.au_sidebar ul li a').removeClass('aktif');
                $('#asm_'+id).addClass('aktif');

                $('#cats').html('{{ cevir._('yukleniyor') }}..');

                let url_id = '';
                if (id !== 0) {
                    url_id = id;
                }

                if (id === 0) {

                }
                $.ajax({
                    type: 'post',
                    url: '{{ url("api/v4/product/") }}',
                    dataType: 'json',
                    cache: false,
                    data: 'cat_id='+id+'&limit=45',
                    success: function (data) {
                        $('#cats').empty();
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
                                urun += '<div class="discount_area">'+u.discount_text+'</div>';
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
                            $('#cats').append(urun);

                        });

                    }
                });

            }
        </script>
    </div>
</div>
{% endif %}
{% endif %}