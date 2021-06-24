{% if top_metin is defined %}
    {% if top_metin is not null %}
        <div class="topbar">
            {{ top_metin }}
        </div>
    {% endif %}
{% endif %}

<!--header başlar-->
<header class="{% if header_class is defined %}{{ header_class }}{% endif %}">
    <div id="hust" class="dn">
        <div id="hu_ort">

            <ul id="dmenu">
                <li>
                    {% for dil in ['turkish','english','arabic','spanish'] %}
                        {% if language is defined %}
                            {% if language is dil %}
                                <a href="javascript:;" data-lang="{{ dil }}"><i
                                            class="fa fa-angle-down"></i>{{ cevir._(dil) }}</a>
                            {% endif %}
                        {% endif %}
                    {% endfor %}
                    <div class="amenu">
                        <i></i>
                        <ul>
                            {% for dil in ['turkish','english','arabic','spanish'] %}
                                {% if language is defined %}
                                    {% if language is not dil %}
                                        <li><a href="javascript:;" data-lang="{{ dil }}"
                                               class="changelang">{{ cevir._(dil) }}</a></li>
                                    {% endif %}
                                {% endif %}
                            {% endfor %}
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>

    <div id="hlogo">
        <div id="hl_ort">
            <h1><a href="{{ url('') }}" style="background:url('{{ url('media/theme_content/logo/' ~ genelayarLogo(activetheme) ) }}') center center no-repeat;background-size: 70%;"></a></h1>

            <i class="fa fa-bars"></i>
			<script>
            $("header #hlogo #hl_ort i.fa-bars").click(function(){
                $('header #hmenu #hm_ort>ul>li#tumu>.alt_menu').slideToggle(200);
            });
            </script>


            <div id="hl_menu">
                <form action="{{ url('sonuc/') }}" method="GET">
                    <input type="text" name="q" placeholder="{{ cevir._('arama_metin') }}">
                    <i class="fas fa-search"></i>
                </form>

                {% if auth is defined %}
                    <!--kullanici giriş yapmış ise başlar-->
                    <ul class="umenu">
                        <li class="profil">
                            <a href="" lang="tr" class="ttu">
                                <i class="icon-user"></i>
                            </a>
                            <div>Hesabım</div>
                            <div class="amenu">
                                <i></i>
                                <ul>
                                    <li><a href="{{ url('uye/') }}"><i class="fa fa-user"></i>{{ cevir._('hesabim') }}</a></li>
                                    <li><a href="{{ url('uye/siparis') }}"><i class="fas fa-check-double"></i>{{ cevir._('siparislerim') }}</a></li>
                                    <li><a href="{{ url('uye/puan') }}"><i class="fas fa-coins"></i>{{ cevir._('puanlarim') }}</a></li>
                                    <li><a href="{{ url('uye/bilgi') }}"><i class="fas fa-shield-alt"></i>{{ cevir._('kullanici_bilgilerim') }}</a></li>
                                    <li><a href="{{ url('uye/kupon') }}"><i class="fas fa-percentage"></i>{{ cevir._('indirim_kuponlarim') }}</a></li>
                                    <li><a href="{{ url('uye/adres') }}"><i class="fas fa-map-marked-alt"></i>{{ cevir._('adres_bilgilerim') }}</a></li>
                                    <li><a href="{{ url('uye/cikis') }}"><i class="fas fa-sign-out-alt"></i>{{ cevir._('cikis') }}</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="profil">
                            <a href="{{ url('uye/favori') }}" class="ttu" lang="tr">
                                <i class="icon-heart"></i>
                            </a>
                            <div>Favorilerim</div>
                        </li>
                        <li class="profil">
                            <a href="{{ url('sepet/') }}" class="sepetm ttu" lang="tr">
                                <i class="icon-basket"></i>
                                <span>{{ count }}</span>
                            </a>
                            <div>Sepetim</div>
                        </li>
                    </ul>
                    <!--kullanici giriş yapmış ise biter-->

                    <script>
                        $('ul.umenu>li>.amenu').hover(
                            function () {
                                $(this).parent().find('a').addClass('aktif');
                            },
                            function () {
                                $(this).parent().find('a').removeClass('aktif');
                            }
                        );
                    </script>

                {% else %}

                    <ul>
                        <li class="profil">
                            <a href="{{ url('uye/giris') }}" title="{{ cevir._('oturum_ac') }}" class="ttu" lang="tr">
                                <i class="icon-user"></i>
                            </a>
                            <div>{{ cevir._('oturum_ac') }}</div>
                        </li>
                        <li class="profil">
                            <a href="{{ url('uye/giris') }}" title="{{ cevir._('favorilerim') }}" class="ttu" lang="tr">
                                <i class="icon-heart"></i>
                            </a>
                            <div>{{ cevir._('favorilerim') }}</div>
                        </li>
                        <li class="profil">
                            <a href="{{ url('sepet/') }}" class="sepetm ttu" lang="tr">
                                <i class="icon-basket"></i>
                                <span></span>
                                {#<span>{{ count }}</span>#}
                            </a>
                            <div>{{ cevir._('sepetim') }}</div>
                        </li>
                    </ul>

                {% endif %}


            </div>
        </div>
    </div>

    <!--
    <nav>
        <ul>
            {% if navmenu is defined %}
                {% for nav in navmenu %}
                    <?php $catnav = \Yabasi\Cats::findFirst('status=1 and id='.$nav->getCatsId()); ?>
                    {% if catnav.sef is defined and catnav.name %}
                    <li><a lang="tr" href="{{ url('kategori/' ~ catnav.sef) }}">{{ catnav.name }}</a></li>
                    {% endif %}
                {% endfor %}
            {% endif %}
        </ul>
    </nav>
    -->

    <div id="hmenu">
        <div id="hm_ort">
            <ul>
                <li id="tumu">
					<a href="javascript:void(0)" lang="tr"><i class="fa fa-arrow-down"></i><span>Tüm</span> Kategoriler</a>
					<div class="alt_menu">
						<div class="amc">
							<div class="tmenu">
							    <ul>
                                    <?php $allcats = \Yabasi\Cats::find('status=1 and top_id=0'); ?>
                                    <?php $allcount = count($allcats); ?>
                                    {% if allcount > 0 %}
                                        {% for all in allcats %}
                                        <li><a title="{{ all.name }}" href="{{ url('kategori/' ~ all.sef) }}" lang="tr">{{ all.name }}<i class="fa fa-arrow-right"></i></a>
                                            <ul>
                                                <?php $subcat = \Yabasi\Cats::find('top_id='.$all->id); ?>
                                                <?php $count = count($subcat); ?>
                                                {% if count > 0 %}
                                                    {% for sub in subcat %}
                                                        <li><a href="{{ url('kategori/' ~ sub.sef) }}">{{ sub.name }}<i class="fa fa-arrow-right"></i></a></li>
                                                    {% endfor %}
                                                {% endif %}
                                            </ul>
                                        </li>
                                        {% endfor %}
                                    {% endif %}
                                </ul>
                            </div>
						</div>
					</div>
                </li>
                
                <!--alt kategorili menu-->
                {% if navmenu is defined %}
                    {% for nav in navmenu %}
                    <?php $catnav = \Yabasi\Cats::findFirst('status=1 and id='.$nav->getCatsId()); ?>
                    {% if catnav.sef is defined and catnav.name %}
                    <li>
                        <a href="{{ url('kategori/' ~ catnav.sef) }}" lang="tr">{{catnav.name}}</a>
                        <?php $subcat = \Yabasi\Cats::find('top_id='.$catnav->id); ?>
                        <?php $count = count($subcat); ?>
                        {% if count > 0 %}
                        <div class="alt_menu">
                            <div class="amc">
                                <h3>{{catnav.name}}</h3>
                                <ul>
                                {% for sub in subcat %}
                                    <li><a href="{{ url('kategori/' ~ sub.sef) }}">{{ sub.name }}<i class="fa fa-arrow-right"></i></a></li>
                                {% endfor %}
                                </ul>
                            </div>
                        </div>
                        {% endif %}
                    </li>
                    {% endif %}
                    {% endfor %}
                {% endif %}
                
                <!--<li id="indirimli"><a href="#"><i class="fa fa-tag"></i>İndirimli Ürünler</a></li>-->
            </ul>
        </div>
    </div>
</header>
<!--header biter-->


<!--
    ismail yeni mobil ekleme
    bu alanın altındaki kısımlar duzenlenmesi gerekiyor gerekli düzenlemeleri yazarım yada sorarsınız!
-->
<div id="header_mobil">
    <a href="{{ url('') }}" id="mobil_logo" style="background:url('{{ url('media/theme_content/logo/' ~ genelayarLogo(activetheme) ) }}') center center no-repeat"></a>
    <a href="javascript:void(0)" class="fas fa-bars"></a>
    <script>
        $('#header_mobil .fa-bars').click(function() {
            $('#mobil_arama').hide();
            $('#mobil_menu').toggle();
        });
    </script>
    <a href="javascript:;" class="fas fa-search"></a>
    <script>
        $('#header_mobil .fa-search').click(function() {
            $('#mobil_menu').hide();
            $('#mobil_arama').toggle();
        });
    </script>

    <a href="{{ url('sepet/') }}" id="sepet">
        <i class="fas fa-shopping-cart"></i>
        <span></span>
    </a>
    <a href="{{ url('uye/favori') }}" class="fas fa-user"></a>
    
    <div id="mobil_menu">
        <ul>


            {% if navmenu is defined %}
                {% for nav in navmenu %}
                <li>
                    <?php $menu0 = \Yabasi\Cats::findFirst('status=1 and id='.$nav->getCatsId()); ?>
                    {% if menu0.sef is defined and menu0.name is defined %}
                    <a href="javascript:void(0)">{{ menu0.name }}<i class="fas fa-chevron-right"></i></a>
                        <?php $menu1 = \Yabasi\Cats::findFirst('status=1 and top_id='.$menu0->getId()); ?>
                        {% if menu1.sef is defined and menu1.name is defined %}
                        <ul>
                            <?php $menu2 = \Yabasi\Cats::find('status=1 and top_id='.$menu1->getTopId()); ?>
                            <?php $cmenu2 = count($menu2); ?>
                            {% if cmenu2 > 0 %}
                                {% for menu2 in menu2 %}
                                <li><a href="{{ url('kategori/' ~ menu2.sef) }}">{{ menu2.name }}<i class="fas fa-chevron-right"></i></a></li>
                                <li>
                                    <a href="{{ url('kategori/' ~ menu2.sef) }}">{{ menu2.name }}<i class="fas fa-chevron-right"></i></a>
                                    <?php $menu3 = \Yabasi\Cats::findFirst('status=1 and top_id='.$menu2->getId()); ?>
                                    {% if menu3.sef is defined and menu3.name is defined %}
                                        <ul class="23">
                                            <?php $lmenu3 = \Yabasi\Cats::find('status=1 and top_id='.$menu2->getId()); ?>
                                            <?php $cmenu3 = count($lmenu3); ?>
                                            {% if cmenu3 > 0 %}
                                                {% for lmenu3 in lmenu3 %}
                                                    <li><a href="{{ url('kategori/' ~ lmenu3.sef) }}">{{ lmenu3.name }}<i class="fas fa-chevron-right"></i></a></li>
                                                {% endfor %}
                                            {% endif %}
                                            <li class="tumu"><a href="{{ url('tum-urunler') }}">Tüm ürünler<i class="fas fa-plus"></i></a></li>
                                        </ul>
                                    {% endif %}
                                </li>
                                {% endfor %}
                            {% endif %}

                        </ul>
                        {% endif %}
                    {% endif %}
                </li>
                {% endfor %}
            {% endif %}
            <li><a href="#">Pantolanlar<i class="fas fa-chevron-right"></i></a></li>
        </ul>
    </div>

    <div id="mobil_arama">
        <form action="{{ url('sonuc/') }}" method="GET">
            <i class="fas fa-search"></i>
            <input type="text" name="q" placeholder="{{ cevir._('arama_metin') }}">
        </form>
    </div>
</div>

<div id="header_menu">
    <ul>
        <li>
            <a href="{% if auth is defined %}{{ url('uye/puan') }}{% else %}{{ url('uye/giris') }}{% endif %}" title="Giriş yap">
                <i class="fas fa-user"></i>
                <span>{% if auth is defined %}Hesabım{% else %}Üye Girişi{% endif %}</span>
            </a>
        </li>

        <li>
            <a href="{{ url('uye/siparis') }}" title="Siparişlerim">
                <i class="fas fa-shopping-cart"></i>
                <span>Siparislerim</span>
            </a>
        </li>

        <li>
            <a href="{{ url('uye/favori') }}" title="Favorilerim">
                <i class="far fa-heart"></i>
                <span>Favorilerim</span>
            </a>
        </li>

        <li>
            <a href="{{ url('sepet/') }}" title="Sepetim">
                <i class="fas fa-shopping-cart"></i>
                <span>Sepetim</span>
                <span id="sepet_adet"></span>
            </a>
        </li>
    </ul>
</div>