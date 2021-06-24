<div class="sayfa">
    <div class="syf_ort">

        {{ partial('uye/inc/sidebar') }}

        <div class="syf_icerik pr">
            <h2>{{ cevir._('puanlarim') }}</h2>
            <div class="uyari dn" id="urun_uyari"></div>
            <!--işlem sonrası mesaj başlar-->
            <div class="syf_mesaj hata dn ">{{ cevir._('adres_eklenildi_text') }}</div>
            <!--işlem sonrası mesaj biter-->

            <div class="syf_bolum">
              <span>Toplam kazanılan puan: {% if total_point is defined%} {{ total_point }} {% endif %}</span>
                <br>
                <span>Puan karşılığı: {% if total_point is defined%} {% if setting is defined%} <b>{{ total_point/setting }} TL</b>  {% endif %}{% endif %}</span>
                {% if total_point is defined%}
                    {% if total_point!=0%}
                        <a href="javascript:;" id="point_cevir" class="btn_w100 ttu mt-50" lang="tr">Hediye çekine dönüştür</a>
                    {% endif %}
                {% endif %}
            </div>

        </div>

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
    $('#point_cevir').click(function (){
        $.ajax({
            type:'post',
            url:'uye/pointcevir/',
            success:function (response){
                if (response==="ok"){
                    $('#urun_uyari').removeClass('dn').addClass('uyari_yesil').fadeIn().html('İşlem başşarılı bir şekilde gerçekleşti!');
                }else {
                    $('#urun_uyari').removeClass('dn').addClass('uyari_kirmizi').fadeIn().html('İşlem sırasında bir hata oluşdu!');
                }
            },
        })

    });
</script>