<style>
    header nav {background:{{ renkTema(activetheme) ~";" }}}
    header nav ul li a { color: {{ renkTemaYazi(activetheme) }}}
    header nav ul li a {border-left:1px solid {{ renkMenuCizgi(activetheme)~";" }}}
    header nav ul li a:hover {background: {{ renkMenuHover(activetheme) ~";" }};  border-color: {{ renkMenuHoverKenar(activetheme)~";" }}; color: {{ renkMenuHoverYazi(activetheme)~";" }}}

    #hmenu { background:{{ renkTema(activetheme) ~" !important;" }} }
    header #hmenu #hm_ort>ul>li>a, header #hmenu #hm_ort ul li#tumu {border-right:1px solid {{ renkMenuCizgi(activetheme)~" !important;" }}}
    #hmenu #hm_ort ul li:not(#tumu) {}

    .urn .urn_detay .fiyat span {background:{{ renkTema(activetheme) ~";" }}; color: {{ renkTemaYazi(activetheme) }}}
    #urun_detay #urnd_ort #urn_sag .urn_fyt .urn_ind {background:{{ renkTema(activetheme) ~";" }}}
    #urun_detay #urnd_ort #urn_sag .urn_spt .urnspt_satir .spt_ekle {background:{{ renkTema(activetheme) ~";" }}; color: {{ renkTemaYazi(activetheme)~";" }}}
    #urun_detay #urnd_ort #urn_sag .urn_fyt .urn_ind {color:{{ renkTemaYazi(activetheme) ~ ";" }};}
    .ana_serit .as_ort .aserit a.as_lnk {color:{{ renkButtonYazi(activetheme) ~ ";" }}; background:{{ renkButton(activetheme) ~";" }}}
    #manset #mns_ort #amns #amns_kucuk ul li.swiper-slide-thumb-active a {border:5px solid {{ sliderCerceveRengi(activetheme) ~";"}}}

    .son_urunler .aurunler_ort .au_cerceve .urn .urn_imgs a {height:{{ setheight(activetheme, "1") }};}
    .ana_urunler .aurunler_ort .au_cerceve {height:{{ setheight(activetheme, "610") }};}
    .ana_urunler .aurunler_ort .au_cerceve .urn {height:{{ setheight(activetheme, "100") }};}
    .ana_urunler .aurunler_ort .au_cerceve .urn .urn_imgs a {height:{{ setheight(activetheme, "1") }};}
    .gunun_firsatlari .gf_ort .gf_cerceve .urn .urn_imgs a {height:{{ setheight(activetheme, "1") }};}
    .son_urunler .aurunler_ort .au_cerceve .urn {min-height: {{ setheight(activetheme, "100") }} !important; height: {{ setheight(activetheme, "100") }} !important;}

    .urunler .urn_cerceve .urn .urn_imgs a {height:{{ setheight(activetheme, "100") }};}
    .son_urunler .aurunler_ort .au_cerceve .urn .urn_imgs img {height:{{ setheight(activetheme, "100") }};}

    .gunun_firsatlari .gf_ort .gf_cerceve {height: {{ setheight(activetheme, "140") }};}
    .ana_urunler .aurunler_ort .au_sidebar {min-height:{{ setheight(activetheme, "610") }} !important;}
    #urun_detay #urnd_ort #urn_slide #urns_buyuk {height:{{ setheight(activetheme, "340") }} !important;}
    #urun_detay #urnd_ort #urn_slide #urns_buyuk ul li a {height:{{ setheight(activetheme, "515") }} !important;}

    .urn_kategori .urnk_ort {height: {{ setheight(activetheme, "190") }};}
    .urn_kategori .urnk_ort .urnk_cerceve .urnk a.urnk_img {height:{{ setheight(activetheme, "100") }};}
    .urn_kategori .urnk_ort .urnk_baslik {height:{{ setheight(activetheme, "200") }};}

    .modul4 .urnk_ort {height: auto !important; }
    .modul4.urnk_buyuk .urnk_ort .urnk_cerceve  {height:{{ setheight(activetheme, "570") }};}
    .modul4.urnk_buyuk .urnk_ort .urnk_baslik  {height:{{ setheight(activetheme, "570") }};}

    .urunler .urn_cerceve .urn {height:{{ setheight(activetheme, "200") }};}

    .modul4.urnk_buyuk .urnk_ort .urnk_cerceve .urn {width:240px; margin-right:10px; margin-bottom:20px;}
    .modul4.urnk_buyuk .urnk_ort .urnk_cerceve .urn .urn_imgs a  {height:350px;}
</style>