<!--footer başlar-->
<footer class="{% if footer_class is defined %}{{ footer_class }}{% endif %}">
    <div id="fbilgi">
        <div id="fb_ort">
            <div class="fb_kutu">
                <h4>HIZLI TESLİMAT</h4>
                <i class="fas fa-shipping-fast"></i>
                <span>Saat 14:00 dan önce verdiğiniz tüm siparişler aynı gün kargoluyoruz.</span>
            </div>

            <div class="fb_kutu">
                <h4>GÜVENLİ ALIŞVERİŞ</h4>
                <i class="fas fa-shield-alt"></i>
                <span>Bilgilerinizi ve adreslerinizi kaydedin, güvenle alışveriş yapın.</span>
            </div>

            <div class="fb_kutu">
                <h4>KOLAY İADE</h4>
                <i class="fas fa-recycle"></i>
                <span>Tüm ürünleri sorgusuz sualsiz iade etmek çok kolay.</span>
            </div>

            <div class="fb_kutu">
                <h4>ALIŞVERİŞ CEBİNİZDE</h4>
                <i class="fas fa-mobile-alt"></i>
                <span>Mobil uygulamalarımız ile heryerden hızlı ulaşın.</span>
            </div>
        </div>
    </div>

    <div id="fseo">
        <div id="fseo_ort">
{#            <div id="fseo_text">#}
{#                {{ footerMenu(activetheme) }}#}
{#            </div>#}
{#            <a href="javascript:devami()" class="devami"><i class="fa fa-angle-double-down"></i>devamını göster</a>#}
            <div class="cl"></div>
        </div>
    </div>

    <script>
        //burayı cok boktan yazdık sonra değiştirelim!
        var dvm_btn = 0;
        var fsth = $('#fseo_text').height();
        $('#fseo_text').css('height', '135px');

        function devami() {
            if (dvm_btn == 0) {
                $('#fseo_text').css('height', fsth + 'px');
                $('#fseo_ort a.devami').html('<i class="fa fa-angle-double-up"></i>devamını gizle');
                dvm_btn = 1;
            } else {
                $('#fseo_text').css('height', '135px');
                $('#fseo_ort a.devami').html('<i class="fa fa-angle-double-down"></i>devamını göster');
                dvm_btn = 0;
            }
        }
    </script>

    <div id="fmenu">
        <div id="fm_ort">

            {% if footercats is defined %}
                {% for fcats in footercats %}
                    <div class="fmenu" id="fmenu">
                        <h4>{{ fcats.name }}</h4>
                        <ul>
                            <?php $subcats = \Yabasi\Content::find(array('conditions' => 'content_cat_id='.$fcats->getId(), 'limit' => 4)); ?>
                            <?php if ($subcats) {?>
                            {% for subs in subcats %}
                                <li><a href="{{ url('sayfa/' ~ subs.sef) }}">{{ subs.name }}</a></li>
                            {% endfor %}
                            <?php } ?>
                        </ul>
                    </div>
                {% endfor %}
            {% endif %}

            <div class="fmenu" id="fpopuler">
                <h4>Popüler Kategoriler</h4>
                <ul>
                    {% if footermenu is defined %}
                        {% for footer in footermenu %}
                            <?php $cat = \Yabasi\Cats::findFirst('status=1 and id='.$footer->getCatsId()); ?>
                            <li><a lang="tr" href="{{ url('kategori/' ~ cat.sef) }}">{{ cat.name }}</a></li>
                        {% endfor %}
                    {% endif %}
                </ul>
            </div>
        </div>
    </div>


    <div id="fsosyal">
        <div id="fs_ort">

            <span>
                {% if socialmedia(activetheme)[activetheme] is defined %}
                    {{ socialmedia(activetheme) }}
                {% endif %}
            </span>
            <ul>
                {% if socialmediaFace(activetheme)[activetheme] is defined %}
                    <li><a href="{{ url(socialmediaFace(activetheme)) }}" class="fab fa-facebook-f"></a></li>
                {% endif %}
                {% if socialmediaTwiter(activetheme)[activetheme] is defined %}
                    <li><a href="{{ url(socialmediaTwiter(activetheme)) }}" class="fab fa-twitter"></a></li>
                {% endif %}
                {% if socialmediaInstagram(activetheme)[activetheme] is defined %}
                    <li><a href="{{ url(socialmediaInstagram(activetheme)) }}" class="fab fa-instagram"></a></li>
                {% endif %}
                {% if socialmediaYoutube(activetheme)[activetheme] is defined %}
                    <li><a href="{{ url(socialmediaYoutube(activetheme)) }}" class="fab fa-youtube"></a></li>
                {% endif %}
                {% if socialmediaPinterest(activetheme)[activetheme] is defined %}
                    <li><a href="{{ url(socialmediaPinterest(activetheme)) }}" class="fab fa-pinterest-p"></a></li>
                {% endif %}
                {% if socialmediaLinkedin(activetheme)[activetheme] is defined %}
                    <li><a href="{{ url(socialmediaLinkedin(activetheme)) }}" class="fab fa-linkedin-in"></a></li>
                {% endif %}
            </ul>

            <a class="muygulama" href="">
                <i class="fab fa-apple"></i>
                <span>IOS Cihazlar</span>
                <span>IOS Store üzerinden indirin</span>
            </a>
            <a class="muygulama" href="">
                <i class="fab fa-android"></i>
                <span>Android Cihazlar</span>
                <span>Play Store üzerinden indirin</span>
            </a>
            <div class="cl"></div>
        </div>
    </div>

    <div id="fcop">
        <div id="fcop_ort">
            <p>{{ footerCopyright(activetheme) }}</p>

            <div id="eticaret">
                <p>Bu site <a href="https://www.oyos.com.tr" target="_blank" title="oyos akıllı eticaret">oyos akıllı eticaret</a> sistemleri ile hazırlanmıştır.</p>
                <!--<a href="http://www.oyos.com.tr" title="akıllı e-ticaret sistemleri" target="_blank"
                   style="background:url('media/logo.png')">eticaret sitesi</a>-->
            </div>
        </div>
    </div>

</footer>
<body>
<div id="myDiv"></div>
</body>
<!--footer biter-->

{% if socialmediaWhatsapp(activetheme)[activetheme] is defined %}
<div class="wsLink">
    <a href="https://api.whatsapp.com/send?phone=9{{ socialmediaWhatsapp(activetheme) }}" target="_blank" title="Bize Ulaşın!" style="background:url('{{ url('assets/frontend/images/sm/whatsapp.png') }}') no-repeat center;"> </a>
</div>
{% endif %}


{% if socialmediaHemenara(activetheme)[activetheme] is defined %}
<div class="hotline-phone-ring-wrap">
    <div class="hotline-phone-ring">
        <div class="hotline-phone-ring-circle"></div>
        <div class="hotline-phone-ring-circle-fill"></div>
        <div class="hotline-phone-ring-img-circle">
            <a href="tel:+9{{ socialmediaHemenara(activetheme) }}" class="pps-btn-img"><img src="{{ url('assets/frontend/images/sm/phone.png') }}" alt="Bizi arayın" style="height: 20px;"/></a>
        </div>
    </div>
    <div class="hotline-bar">
        <a href="tel:+9{{ socialmediaHemenara(activetheme) }}"><span class="text-hotline">+9{{ socialmediaHemenara(activetheme) }}</span></a>
    </div>
</div>
{% endif %}