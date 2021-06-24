{% if modul1 is defined %}
    <div class="urn_kategori modul1">
        <div id="muk" class="urnk_ort">
            {% if modul1 is defined %}
                {% for moduls1 in modul1 %}
                    <div class="urnk_baslik" style="background-image:url('http://localhost/app/media/resim_yok.png');">
                        <h4><a href="{{ url('kategori/' ~ moduls1.sef) }}">{{ moduls1.name }}</a></h4>
                        <h5 class="ttu" lang="tr">{{ cevir._('kacirilmayacak_firsatlar') }}</h5>
                        <a href="{{ url('kategori/' ~ moduls1.sef) }}" class="urnk_lnk">{{ cevir._('tum_urunler') }}<i class="fa fa-arrow-right"></i></a>
                    </div>
                {% endfor %}
            {% endif %}

            <i class="fa fa-angle-left"></i>
            <i class="fa fa-angle-right"></i>

            <div class="urnk_cerceve fix_cerceve swiper-container">
                <div class="urnk_list swiper-wrapper">

                    {% if modul1_cats is defined %}
                        {% for cats in modul1_cats %}
                            <?php $image = \Yabasi\Images::findFirst(array('conditions' => 'meta_key="category" and status=1 and content_id='.$cats->id, 'order' => 'showcase desc')); ?>
                            {% set image_url = 'media/resimyok.png' %}
                            {% if image %}
                                {% set image_url = 'media/category/' ~ image.meta_value %}
                            {% endif %}
                            <div class="urnk swiper-slide">
                                <h3><a href="{{ url('kategori/' ~ cats.sef) }}">{{ cats.name }}<i class="fa fa-angle-right"></i></a></h3>
                                <a href="{{ url('kategori/' ~ cats.sef) }}" style="background:url('{{ url(image_url) }}') center center no-repeat;" class="urnk_img"></a>
                            </div>
                        {% endfor %}
                    {% endif %}

                </div>
            </div>

            <script>
                var swiper = new Swiper('#muk .urnk_cerceve', {
                    slidesPerView: 3,
                    slidesPerGroup: 1,
                    spaceBetween: 10,
                    autoplay: {
                        delay:5000,
                    },
                    loop: false,
                    loopFillGroupWithBlank: true,
                    navigation: {
                        nextEl: '#muk .fa-angle-left',
                        prevEl: '#muk .fa-angle-right',
                    },
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