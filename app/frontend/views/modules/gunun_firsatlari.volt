{% if gununfirsatlari is defined %}
    <div class="gunun_firsatlari">
        <div class="gf_ort">
            <div class="gf_baslik">
                <h4 class="ttu" lang="tr">{{ cevir._('gunun_firsatlari') }}</h4>
                <span>{{ cevir._('gunun_firsatlari_metin') }}</span>
                <a href="{{ url('tum-firsatlar') }}" class="ttu" lang="tr">{{ cevir._('tum_firsatlar') }}<i class="fa fa-arrow-right"></i></a>
            </div>

            <div class="gf_cerceve swiper-container">
                <div class="gf_list swiper-wrapper">

                    {% if gununfirsatlari is defined %}
                        {% for gununfirsat in gununfirsatlari %}
                            <div class="urn swiper-slide">
                                <div class="urn_imgs">
                                    <?php $image = \Yabasi\Images::findFirst(array('conditions' => 'meta_key="product" and status=1 and content_id='.$gununfirsat->id, 'order' => 'showcase desc')); ?>
                                    {% set image_url = 'media/resimyok.png' %}
                                    {% if image %}
                                        {% set image_url = 'media/product/' ~ image.meta_value %}
                                    {% endif %}
                                    <a href="{{ url('urun/' ~ gununfirsat.sef) }}" style="background:url('{{ url(image_url) }}') center center no-repeat #fff;"></a>
                                    {% if gununfirsat.discount_rate is not 0 and gununfirsat.discount_rate is not '' %}
                                        <div class="discount_area">
                                            {{ totaldiscount(gununfirsat.id) }}
                                        </div>
                                    {% endif %}
                                </div>
                                <div class="noc">
                                    <h3><a href="{{ url('urun/' ~ gununfirsat.sef) }}">{{ gununfirsat.name }}</a></h3>
                                    <div class="kfiyat">
                                        <div class="kfiyat_son">{{ totalprice(gununfirsat.id) }}</div>
                                        {% if gununfirsat.discount_rate is not 0 and gununfirsat.discount_rate is not '' %}
                                            <del>{{ oldprice(gununfirsat.id) }}</del>
                                        {% endif %}
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    {% endif %}

                </div>
            </div>
            <script>
                var swiper = new Swiper('.gf_cerceve', {
                    slidesPerView: 5,
                    slidesPerGroup: 1,
                    spaceBetween: 10,
                    autoplay: {
                        delay:5000,
                    },
                    loop: false,
                    loopFillGroupWithBlank: true,
                    breakpoints: {  
                        768: {       
                            slidesPerView: 2,
                        }
                    },
                });
            </script>
        </div>
    </div>
{% endif %}