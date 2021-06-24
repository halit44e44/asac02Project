<div id="manset">
    <div id="mns_ort">
        {% if mansetler is defined %}
            <div id="amns">
                <div id="amns_buyuk" class="swiper-container">
                    <ul class="swiper-wrapper">
                        {% if mansetler is defined %}
                            {% for manset in mansetler %}
                                <?php $image = \Yabasi\Images::findFirst('meta_key="content" and status=1 and showcase=1 and content_id='.$manset->id);?>
                                {% if image %}
                                    <li class="swiper-slide"><a
                                                href="{% if manset.redirect_url is not '' %}{{ manset.redirect_url }}{% else %}tum-firsatlar{% endif %}"><img
                                                    src="{{ url('media/content/' ~ image.meta_value) }}" alt=""></a>
                                    </li>
                                {% endif %}
                            {% endfor %}
                        {% endif %}
                    </ul>
                </div>
                {% if sliderIleriGeriButon(activetheme)[activetheme] is defined %}
                    {% if sliderIleriGeriButon(activetheme) === "on" %}
                        <div id="amns_kucuk" class="swiper-container">
                            <ul class="swiper-wrapper">
                                {% if mansetler is defined %}
                                    {% for manset in mansetler %}
                                        <?php $image = \Yabasi\Images::findFirst('meta_key="content" and status=1 and showcase=0 and content_id='.$manset->id);?>
                                        {% if image %}
                                            <li class="swiper-slide"><a href="javascript:void(0)"
                                                                        style="background:url('{{ url('media/content/' ~ image.meta_value) }}') center center no-repeat;"></a>
                                            </li>
                                        {% endif %}
                                    {% endfor %}
                                {% endif %}
                            </ul>
                        </div>
                    {% endif %}
                {% endif %}
            </div>
            <script>

                var amns_kucuk = new Swiper('#amns_kucuk', {
                    spaceBetween: 10,
                    slidesPerView: 10,
                    freeMode: true,
                    watchSlidesVisibility: false,
                    watchSlidesProgress: true,
                    autoplay: {
                        delay: {{ sliderResimDegisme(activetheme) }},
                    }
                });

                var amns_buyuk = new Swiper('#amns_buyuk', {
                    effect: '{{ sliderGecisTipi(activetheme) }}',
                    spaceBetween: 0,
                    autoplay: {
                        delay: {{ sliderResimDegisme(activetheme) }},
                    },
                    {% if sliderIleriGeriButon(activetheme)[activetheme] is defined %}
                    {% if sliderIleriGeriButon(activetheme) === "on" %}
                    thumbs: {
                        swiper: amns_kucuk
                    }
                    {% endif %}
                    {% endif %}
                });
            </script>
        {% endif %}
    </div>
</div>