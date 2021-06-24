{% if page is not 'login' %}
<!--sidebar başlar-->
<div class="sidebar">
    <ul>
        <li><a href="{{url('backend/')}}"><i class="la la-home"></i>{{cevir._('baslangic')}}</a></li>
        <li>
            <a href="javascript:;"><i class="la la-shopping-bag"></i>{{cevir._('urunler')}}</a>
            <div class="amenu">
                <h4>{{cevir._('urun_yonetimi')}}</h4>
                <ul>
                    <li><a href="{{url('backend/product')}}">{{cevir._('tum_urunler')}}</a></li>
                    <li><a href="{{url('backend/product/insert')}}">{{cevir._('yeni_urun_ekle')}}</a></li>
                </ul>

                <h4>{{cevir._('urun_kategorileri')}}</h4>
                <ul>
                    <li><a href="{{url('backend/category')}}">{{cevir._('tum_urun_kategorileri')}}</a></li>
                    <li><a href="{{url('backend/category/insert')}}">{{cevir._('yeni_urun_kategorisi_ekle')}}</a></li>
                </ul>

                <h4>{{cevir._('markalar')}}</h4>
                <ul>
                    <li><a href="{{url('backend/brand')}}">{{cevir._('tum_markalar')}}</a></li>
                    <li><a href="{{url('backend/brand/insert')}}">{{cevir._('yeni_marka_ekle')}}</a></li>
                </ul>

                <h4>{{cevir._('varyasyonlar')}}</h4>
                <ul>
                    <li><a href="{{url('backend/variant')}}">Varyasyon kategorileri</a></li>
                    <li><a href="{{url('backend/variant')}}">Yeni varyasyon kategori</a></li>
                    <li><a href="{{url('backend/variant')}}">Tüm varyasyonlar</a></li>
                    <li><a href="{{url('backend/variant')}}">Yeni varyasyon</a></li>
                </ul>

                <h4>{{cevir._('diger')}}</h4>
                <ul>
                    <li><a href="{{url('backend/comment')}}">{{cevir._('urun_yorumlari')}}</a></li>
                </ul>
            </div>
        </li>
        <li><a href="{{url('backend/order')}}"><i class="la la-shopping-cart"></i>{{cevir._('siparis')}}<span>12</span></a></li>
        <li><a href="{{url('backend/content')}}"><i class="la la-rocket"></i>{{cevir._('kampanyalar')}}</a></li>
        <li><a href="javascript:;"><i class="la la-user"></i>{{cevir._('kullanicilar')}}</a>
            <div class="amenu">
                <h4>{{cevir._('kullanici_yonetimi')}}</h4>
                <ul>
                    <li><a href="{{url('backend/user')}}">{{cevir._('tum_kullanicilar')}}</a></li>
                    <li><a href="{{url('backend/user/insert')}}">{{cevir._('yeni_kullanici_ekle')}}</a></li>
                </ul>

                <h4>{{cevir._('kullanici_gruplari')}}</h4>
                <ul>
                    <li><a href="javascript:;">{{cevir._('tum_kullanici_gruplari')}}</a></li>
                    <li><a href="javascript:;">{{cevir._('yeni_kullanici_grubu_ekle')}}</a></li>
                </ul>

                <h4>{{cevir._('bayiler')}}</h4>
                <ul>
                    <li><a href="javascript:;">{{cevir._('tum_bayiler')}}</a></li>
                    <li><a href="javascript:;">{{cevir._('yeni_bayi_ekle')}}</a></li>
                </ul>

                <h4>{{cevir._('diger')}}</h4>
                <ul>
                    <li><a href="{{url('backend/comment')}}">{{cevir._('urun_yorumlari')}}</a></li>
                </ul>
            </div>
        </li>
        <li><a href="{{url('backend/content')}}"><i class="la la-pen"></i>{{cevir._('icerikler')}}</a></li>
        <li><a href="{{url('backend/statistic')}}"><i class="la la-chart-pie"></i>{{cevir._('raporlar')}}</a></li>
        <li><a href="{{url('backend/setting')}}"><i class="la la-brush"></i>{{cevir._('tasarim')}}</a></li>
        <li><a href="{{url('backend/setting')}}"><i class="la la-box"></i>{{cevir._('moduller')}}</a></li>
        <li><a href="{{url('backend/setting')}}"><i class="la la-cog"></i>{{cevir._('ayarlar')}}</a></li>
    </ul>
</div>
<!--sidebar biter-->
{% endif %}