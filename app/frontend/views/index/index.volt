<!--manset baslar-->
{{ partial('modules/manset') }}
<!--manset biter-->

<!--populer kategoriler baslar-->
{{ partial('modules/populer') }}
<!--populer kategoriler biter-->

<!--son eklenen ürünler baslan-->
{{ partial('modules/son_urunler') }}
<!--son eklenen ürünler biter-->

<!--gunun firsatlari baslar-->
{{ partial('modules/gunun_firsatlari') }}
<!--gunun firsatlari biter-->

<!--urun alt kategori başlar-->
{{ partial('modules/modul1') }}
<!--urun alt kategori biter-->

<!--ana urunler başlar-->
{{ partial('modules/modul2') }}
<!--ana urunler biter-->

<!--ana serit başlar-->
{#{{ partial('modules/modul3') }}#}
<!--ana serit biter-->

<!--urun alt kategori büyük başlar-->
{{ partial('modules/modul4') }}
<!--urun alt kategori büyük biter-->

<!--modal başlar-->
{{ partial('inc/modal') }}

{% if cerez.value is defined%}
    <input id="cerez" type="hidden" data-baslik="{{ cerez.value }}">
    <script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script>
    <script>
        var baslik=$('#cerez').data('baslik');
        window.start.init({Palette:"palette1",Theme:"wire",Mode:"floating left",Time:"1",LinkText:"Detaylı bilgi almak için tıklayınız",Location:"{{ url('sayfa/gizlilik-ve-cerez-politikasi') }}",Message:baslik,ButtonText:"kabul et",})
    </script>
{% endif %}
<!--modal biter-->