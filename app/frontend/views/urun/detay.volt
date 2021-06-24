{% if breadcrumb is defined %}
    {% if breadcrumb.value is not 'false' %}
    <div class="nerdeyim">
        <div class="nrd_ort">
            <ul>
                {% if cat is defined %}
                    {% for cat in cat %}
                        <li><a href="{{ url("kategori/" ~ catsef(cat)) }}">{{ cats(cat)}}</a><i class="fas fa-angle-right"></i></li>
                    {% endfor %}
                {% endif %}
                <li><a href="{{ url("urun/"~pro.sef) }}">{{ pro.name }}</a></li>

            </ul>
        </div>
    </div>
    {% endif %}
{% endif %}

<input type="hidden" value="{{ pro.id }}" id="id">
{% if cerez.value is defined%}
    <input id="cerez" type="hidden" data-baslik="{{ cerez.value }}">
    <script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
    <script>
        var baslik=$('#cerez').data('baslik');
        window.start.init({Palette:"palette1",Theme:"wire",Mode:"floating left",Time:"1",LinkText:"Detaylı bilgi almak için tıklayınız",Location:"{{ url('sayfa/gizlilik-ve-cerez-politikasi') }}",Message:baslik,ButtonText:"kabul et",})
    </script>
{% endif %}
<div id="urun_detay">
    <div id="urnd_ort">
        <!--urun resimler başlar-->
        <div id="urn_slide">
            <div id="urns_buyuk" class="swiper-container">
                <ul class="swiper-wrapper">
                    {% if image is defined %}
                        {% for image in image %}
                            <li class="swiper-slide">
                                <a href="{{ url('media/product/' ~ image['url']) }}" class="galeri_popup" style="background:url('{{ url('media/product/' ~ image['url']) }}') center center no-repeat;"></a>
                            </li>
                        {% endfor %}
                    {% endif %}
                </ul>
            </div>

            <div id="urns_kucuk" class="swiper-container">

                <ul class="swiper-wrapper">
                    {% if images is defined %}
                        {% for images in images %}
                            <li class="swiper-slide"><a href="javascript:void(0)" style="background:url('{{ url('media/product/' ~ images['url']) }}') center center no-repeat;"></a></li>
                        {% endfor %}
                    {% endif %}
                </ul>

            </div>
        </div>

        <script>
            var urns_kucuk = new Swiper('#urns_kucuk', {
                spaceBetween: 10,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                autoplay: {
                    delay: 5000,
                }
            });

            var urns_buyuk = new Swiper('#urns_buyuk', {
                effect: 'slide',
                spaceBetween: 0,
                autoplay: {
                    delay: 5000,
                },
                thumbs: {
                    swiper: urns_kucuk
                }
            });
        </script>
        <!--urun resimler başlar-->

        <div id="urn_sag">
            <div id="urn_bilgi">
                <h1>{{ pro.name }}</h1>
                <div class="mini_aciklama">{{ pro.short_content }}</div>
                <ul>
                    {% if markagosterim is defined %}
                        {% if markagosterim.value is not 'false' %}
                            {% if pro.brand_id != 0  %}
                                <li><a href="{{ url('marka/' ~ brand.sef) }}" class="btn btn_mavi">{{ brand.name }}</a></li>
                            {% endif %}
                        {% endif %}
                    {% endif %}

                    {% if user is defined %}
                        <?php
                    $favorites =  \Yabasi\Favorites::findFirst("pro_id=" . $pro->getId() . " and user_id=" .$user." and status=1");
                        ?>
                        {% if favorites is null %}
                            {% set favori_renk = 'btn_gri' %}
                            {% set favori_icon= 'far fa-heart' %}
                            {% set favori_text= 'Favorilerime Ekle' %}
                        {% else %}
                            {% set favori_renk = 'btn_kirmizi' %}
                            {% set favori_icon= 'fas fa-heart' %}
                            {% set favori_text= 'Favorilerim' %}
                            {% if favorites.status is 0 %}
                                {% set favori_renk = 'btn_gri' %}
                                {% set favori_icon= 'far fa-heart' %}
                                {% set favori_text= 'Favorilerime Ekle' %}
                            {% endif %}
                        {% endif %}
                        <li><a href="javascript:;" onclick="changefavori(this)" data-id="{{ pro.id }}" data-user="{{ user }}" class="btn {{ favori_renk }}"><i class="{{ favori_icon }}"></i>{{ favori_text }}</a>
                    {% else %}
                        <li><a href="{{ url('uye/giris') }}" class="btn btn_gri}"><i class="far fa-heart"></i>{{ cevir._('favorilerime_ekle') }}</a></li>
                    {% endif %}
                    {% if stokgosterim is defined %}
                        {% if stokgosterim.value is not 'false' %}
                            <li class="urunkodu_onm">
                                <a href="javascript:;" class="btn"><b>{{ cevir._('urun_kodu') }}:</b> {{ pro.stock_code }}</a>
                            </li>
                        {% endif %}
                    {% endif %}
                </ul>

            </div>

            <div class="urn_fyt">
                {% if pro.discount_rate is not "0" and pro.discount_rate is not '' %}
                    <!--eger indirim var ise başlar-->
                    <div class="urn_ind">
                        {{ totaldiscount(pro.id) }}
                        <span>{{ cevir._('indirim') }}</span>
                    </div>
                    <!--eger indirim var ise biter-->
                    <del> {{ oldprice(pro.id) }}</del>
                    <span>{{ totalprice(pro.id) }}</span>
                {% else %}
                    <span>{{ totalprice(pro.id) }}</span>
                {% endif %}
            </div>

            {# ilişkili ürünler #}
            {{ getRelatedPro(pro_id) }}

            {# hediye ürünler #}
            {{ getGiftPro(pro_id) }}

            {# tavsiye ürünler #}
            {{ getRecommendetPro(pro_id) }}

            <div class="urn_spt">
                <div class="urnspt_satir">
                    <!--eğer varyant var ise başlar-->
                    {{ variant(pro_id) }}
                    <!--eğer varyant var ise biter-->

                    <!--sepet ekleme işleminde kullanılacak id-->
                    <input type="hidden" value="" name="urun_id">
                </div>

                <div class="urnspt_satir">
                    <input type="number" min="1" max="{{ pro.unit }}" data-max="{{ pro.unit }}" value="1" id="adet">
                    <div id="spt_ekle_html">
                        {% if pro.unit==0 %}
                            <a href="javascript:alert('Ürün tükendi')" class="spt_kapali ttu" lang="tr">{{ cevir._('urun_tukendi') }}<i
                                        class="las la-cart-plus"></i></a>
                        {% else %}
                            <a href="javascript:void(0)" onclick="sepet()" class="spt_ekle ttu" lang="tr">{{ cevir._('sepete_ekle') }}<i
                                        class="fas fa-cart-plus"></i></a>
                        {% endif %}
                    </div>
                </div>

                <div class="uyari dn" id="urun_uyari"></div>

                <div class="urn_bbilgi">
                    <div class="urn_bbb bbb_uk">
                        {% if pro.shipping_fee==0 %}
                            <span class="ttu" lang="tr">{{ cevir._('ucretsiz_kargo') }}</span>
                            <span>{{ cevir._('bu_urunun_kargosu_bizden') }}</span>
                            <i class="fas fa-shipping-fast"></i>
                        {% else %}
                            <span class="mt-5">{{ cevir._('kargo_ucreti') }} {{ pro.shipping_fee }} TL</span>
                            <i class="fas fa-shipping-fast"></i>
                        {% endif %}
                    </div>
                </div>
                <div class="urn_mbilgi hkargo"><span><i class="fas fa-shipping-fast"></i>{{ cevir._('hizli_teslimat') }} - </span>
                    En geç {{ cargodate}} kargoya verilir.
                </div>


            </div>
        </div>
    </div>
</div>

<div id="urun_aciklama">
    <div id="urna_ort">

        <div id="urna_tablar">
            <ul>
                <li><a href="javascript:tab_getir('aciklama')" id="tabm_aciklama" class="aktif ttu" lang="tr">{{ cevir._('urun_aciklamasi') }}</a></li>
                <li><a href="javascript:tab_getir('taksit')" id="tabm_taksit" class="ttu" lang="tr">{{ cevir._('taksit_secenekleri') }}</a></li>
                <li><a href="javascript:tab_getir('yorumlar')" id="tabm_yorumlar" class="ttu" lang="tr">{{ cevir._('kullanici_yorumlari') }}</a></li>
                <li><a href="javascript:tab_getir('iade')" id="tabm_iade" class="ttu" lang="tr">{{ cevir._('iade_kosullari') }}</a></li>
            </ul>

            <div class="urna_tab" id="tab_aciklama">
                <div class="icerik">
                    <p>{% if pro.content is defined %}{{ pro.content }}{% endif %}</p>
                    <table class="table table-striped" id="features">
                        <tbody>
                        {% if feature is defined %}
                            {% for feature in feature %}
                                <tr>
                                    <th scope="row">{{ featureName(feature) }}</th>
                                    <td>{{ feature(feature) }}</td>
                                </tr>
                            {% endfor %}
                        {% endif %}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="urna_tab" id="tab_taksit">
                <div class="icerik">
                    {% for taksit in taksit %}
                        <div class="banka">
                            <div class="banka_adi">
                                {{ taksit.name }}
                            </div>
                            <table>
                                <thead>
                                <tr>
                                    <th>Taksit</th>
                                    <th>Taksit Tutarı</th>
                                    <th>Toplam Tutar</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{ taksit(taksit.id,totalprice(pro.id,pro.id)) }}
                                </tbody>
                            </table>
                        </div>

                    {% endfor %}
                </div>
            </div>


            <div class="urna_tab" id="tab_yorumlar">
                {% if user is defined %}
                    <div id="yorum_yaz">

                        <div class="yrm_satir">
                            <input type="hidden" id="rating-2" name="rating-2" value="5"/>
                            <span>{{ cevir._('urun_icin_puaniniz') }}</span>
                            <span id="rating-1" data-stars="5"></span>
                        </div>


                        <div class="yrm_satir">
                            <textarea name="" placeholder="{{ cevir._('yorumunuz') }}.." id="comment"></textarea>
                        </div>

                        <div class="yrm_satir">
                            <input onclick="gonder()" id="gonder" data-stars="" type="submit" class="ybtn btn_bsari" value="{{ cevir._('yorumu_gonderin') }}">
                            <div class="yrm_bilgi">
                                <input type="checkbox" id="admin_gorunsun" value="1">
                                <label for="admin_gorunsun">{{ cevir._('tam_adim_gorunmesin') }}</label>
                            </div>
                        </div>
                        <div class="uyari" id="yorum_uyari"></div>
                    </div>
                {% else %}
                    <div id="yorum_yaz">{{ cevir._('yorum_sart_text') }}</div>
                {% endif %}

                {% if comment is defined %}
                    {% for comment in comment %}
                        <div id="yorumlar">

                            <div class="yrm">
                                <div class="yrm_kisi">
                                    <i class="far fa-user"></i>
                                    <span><i class="far fa-check-square"></i>{% if comment.id is defined %} {{ comment(comment.id) }}{% endif %} </span>
                                </div>
                                <div class="yrm_detay">
                                    <div class="yrm_bilgi">
                                        <div class="yildizlar yildizlar_mini">
                                            {% if comment.point is defined %}  {{ points(comment.point) }}{% endif %}
                                        </div>
                                        <span>{% if comment.created_at is defined %}{{ prodate(comment.created_at) }}{% endif %}</span>
                                    </div>
                                    <div class="yrm_txt">{% if comment.comment is defined %}{{ comment.comment }}{% endif %}</div>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                {% endif %}
                {% if comment.id is empty %}
                    <div id="yorumlar">
                        <div class="uyari"><i class="las la-exclamation-circle"></i>{{ cevir._('yorum_yapilmamis_text') }}</div>
                    </div>
                {% endif %}


            </div>
            <div class="urna_tab" id="tab_iade">
                <div class="icerik">
                    {% if iadeveiptal is defined %}{{ iadeveiptal }}{% endif %}
                </div>
            </div>
        </div>


        <div id="urn_puan">

            <img src="public/media/product/{{ image['url'] }}" alt="">
            <div id="urnp_bilgi">
                <h3>{{ pro.name }}</h3>
                <div id="puan">
                    <span>{% if sum is defined %}
                            {% if sum>0 %}
                                {{ sum }}
                            {% endif %}
                        {% endif %}
                    </span>
                    <span>  {% if sum>0 %}{{ cevir._('ortalama_kullanici_puani') }}{% endif %}</span>
                    <div class="yildizlar">
                        {% if sum is defined %}
                            {% if sum>0 %}
                                {{ points(sum) }}
                            {% endif %}
                            {% if sum==0 %}
                                {{ cevir._('henuz_yorum_yapilmadi') }}
                            {% endif %}
                        {% endif %}

                    </div>
                </div>
            </div>
            <div class="cl"></div>

            <div class="cl"></div>
            {% if sum is defined %}
                {% if sum!=0 %}
                    <div id="puanlar">
                        <div class="psatir">
                            <div class="pbilgi">
                                <span>{{ cevir._('cok_iyi') }} ({{ point5 }})</span>
                                <div class="yildizlar yildizlar_mini">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span><i style="width:{{ yuzde5 }}%;">%{{ yuzde5 }}</i></span>
                        </div>
                        <div class="psatir">
                            <div class="pbilgi">
                                <span>{{ cevir._('iyi') }} ({{ point4 }})</span>
                                <div class="yildizlar yildizlar_mini">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span><i style="width:{{ yuzde4 }}%;">%{{ yuzde4 }}</i></span>
                        </div>
                        <div class="psatir">
                            <div class="pbilgi">
                                <span>{{ cevir._('iyi_gibi') }} ({{point3}})</span>
                                <div class="yildizlar yildizlar_mini">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span><i style="width:{{ yuzde3 }}%;">%{{ yuzde3 }}</i></span>
                        </div>
                        <div class="psatir">
                            <div class="pbilgi">
                                <span>{{ cevir._('kotu') }} ({{ point2 }})</span>
                                <div class="yildizlar yildizlar_mini">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span><i style="width:{{ yuzde2 }}%;" >%{{ yuzde2 }}</i></span>
                        </div>
                        <div class="psatir">
                            <div class="pbilgi">
                                <span>{{ cevir._('cok_kotu') }} ({{ point1 }})</span>
                                <div class="yildizlar yildizlar_mini">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <span><i style="width:{{ yuzde1 }}%;">%{{ yuzde1 }}</i></span>
                        </div>
                    </div>
                {% endif%}
            {% endif%}
        </div>
    </div>
</div>
</div>
</div>
<script>

    function changefavori(el) {
        const id = $(el).data('id');
        const user = $(el).data('user');
        $.ajax({
            type: 'post',
            url: 'uye/changefavori/' + id + '/' + user,
            success: function (response) {
                console.log(response);
                if (response === "ok") {
                    window.location.reload();
                }
            }
        })
    }
</script>
<script>
    $(document).ready(function () {

        $("#admin_gorunsun").on("change", function () {
            if ($("#admin_gorunsun").prop("checked")) {
                document.getElementById("admin_gorunsun").value = "0";
            } else {
                document.getElementById("admin_gorunsun").value = "1";

            }
        });
    });

    function tab_getir(id) {
        $('.urna_tab').hide();
        $('#tab_' + id).fadeIn();

        $('#urna_tablar>ul li a').removeClass('aktif');
        $('#tabm_' + id).addClass('aktif');
    }
</script>

<script>

    function gonder(){
        var yorum=document.getElementById("comment").value;
        var anonim=document.getElementById("admin_gorunsun").value;
        var point=document.getElementById("rating-2").value;
        var id=document.getElementById("id").value;

        $.ajax({
                type: "POST",
                url: 'insert/comment/' + yorum + '/' + point+ '/'+anonim+ '/'+id,
                success: function (data)
                {
                    if (data==="ok"){
                        $('#yorum_yaz .yrm_satir').hide();
                        $('#yorum_uyari').addClass('uyari_yesil').fadeIn().html('{{ cevir._('yorum_basari_text') }}');
                    }
                    else {
                        $('#yorum_uyari').addClass('uyari_kirmizi').fadeIn().html('{{ cevir._('yorum_hata_text') }}');
                    }
                },
            }
        );

    }


    let durum;
    var variant="";
    $('.varyant').change(function() {
        $('.varyant').each(function() {

                console.log($(this).val());
                if($.isNumeric($(this).val())) {
                    variant+=$(this).val()+",";
                    durum = false;
                } else {
                    durum=true;
                    variant="";
                }
        });

        if(durum) {
            console.log('secilmeyen varyant var')
        } else {
            console.log('tumu duzenlenmiş');
            variant=variant.slice(0,-1);
            $('#spt_ekle_html').load('{{ url("insert/urun/")~pro.id }}'+"/" +variant);
            //$('#spt_ekle_html').html('{{ url("insert/urun/1/") }}' +variant);

            //$('.spt_ekle').attr("href","yeniyeref")
            $('.urn_fyt').load('{{ url("insert/urunfiyat/"~pro.id) }}'+"/"+variant);
            variant="";
        }
    });

    function sepet() {
        $('#urun_uyari').addClass('dn');
        var adet = document.getElementById("adet").value;
        var id = document.getElementById("id").value;
        var max=$('#adet').data("max");
        var variant="";
        var i=0;
        $('.varyant').each(function() {
            variant+=$(this).val()+",";
            i++;
        })



        if (adet>max){
            $('#urun_uyari').removeClass('dn').removeClass('uyari_yesil').addClass('uyari_kirmizi').fadeIn().html('Stokda '+max+" adet ürün vardır!");
        }

        else {
            variant=variant.slice(0,-1);
            if (i>0){
                $.ajax({
                        type: "POST",
                        url: 'insert/variant/' + id + '/' + variant,
                        success: function (data) {
                            $('#urun_uyari').addClass('dn');
                            if (data==="ok"){
                                $.ajax({
                                        type: "POST",
                                        url: 'insert/shopcart/' + id + '/' + adet+'/'+variant,
                                        success: function (data) {
                                            if (data === "ok"){

                                                sepetCount();

                                                $('#urun_uyari').removeClass('dn').removeClass('uyari_kirmizi').addClass('uyari_yesil').fadeIn().html('Ürün sepete eklenmiştir!');
                                            }else {
                                                $('#urun_uyari').removeClass('dn').removeClass('uyari_yesil').addClass('uyari_kirmizi').fadeIn().html('Bir sorun oluştu kütfen daha sonra tekrar deneyiniz!!');

                                            }

                                        },
                                    }
                                );

                            }else {
                                $('#urun_uyari').removeClass('dn').removeClass('uyari_yesil').addClass('uyari_kirmizi').fadeIn().html('Lütfen önce varyant seçimini yapınız!');
                            }

                        },
                    }
                );

            }else {
                $('#urun_uyari').addClass('dn');
                $.ajax({
                        type: "POST",
                        url: 'insert/shopcart/' + id + '/' + adet+'/'+variant,
                        success: function (data) {
                            if (data==="ok"){
                                sepetCount();
                                $('#urun_uyari').removeClass('dn').removeClass('uyari_kirmizi').addClass('uyari_yesil').fadeIn().html('Ürün sepete eklenmiştir!');
                            }else {

                                $('#urun_uyari').removeClass('dn').removeClass('uyari_yesil').addClass('uyari_kirmizi').fadeIn().html('Bir sorun oluştu kütfen daha sonra tekrar deneyiniz!!');
                            }

                        },
                    }
                );
            }

        }
    }

    $.ratePicker("#rating-1", {

            rate: function (stars) {
                document.getElementById("rating-2").value = stars;
            }
        }
    );
    var starWidth = 40;

    var starWidth = 40;


    function sepetCount() {
        $.get("{{ url('sepet/count') }}", function (repsonse) {
            let count = 0;
            if (repsonse) {
                count = repsonse;
            }
            $('a.sepetm span').html(count);
            $('#sepet span').html(count);
            $('#sepet_adet').html(count);
            $('.sepet i span').html(count);
        });
    }

</script>
