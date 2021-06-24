<div class="sayfa">
    <div class="syf_ort">

        {{ partial('uye/inc/sidebar') }}

        <div class="syf_icerik">
            <h2>{{ cevir._('siparislerim') }}</h2>
            <div class="uyari uyari_kirmizi mb-0 bru dn" id="uyari" style="">İşlem yapma yetkiniz yoktur!</div>
            <div class="siparis_area">
                {% if orders is defined %}
                    {% for order in orders %}
                        <?php
                        $value = json_decode($order->getMetaValue());
                       $durum = \Yabasi\Ordertype::findFirst($order->getOrderStatus());
                       $orderAnyPros = \Yabasi\Order::findFirst('top_id='.$order->id);
                       $image = 'media/resimyok.png';
                       if ($orderAnyPros) {
                       $images = \Yabasi\Images::findFirst('meta_key="product" and status=1 and content_id='.$orderAnyPros->pro_id);
                       if ($images) {
                       $image = 'media/product/'.$images->meta_value;
                       }
                       }
                       ?>
                        <div class="siparis" id="siparis_{{ order.id }}">
                            <div class="siparis_sol">
                                <div class="siparis_gorsel">
                                    <img src="{{ url(image) }}" width="50" title="Saat"/>
                                </div>
                                <div class="siparis_info">
                                    <p>Sipariş No: <b>{{ value.code }}</b></p>
                                    <p>{{ date('m.d.Y H:i:s', order.created_at) }}</p>
                                </div>
                            </div>
                            <div class="siparis_sag">
                                <div class="siparis_durum">
                                    <?php
                                setlocale(LC_MONETARY, 'tr_TR');
                                $format = number_format($order->total_price, 2, ',', '.');
                                    ?>
                                    <p>{{ format }} {{ order.currency }}</p>
                                    <span>{{ durum.name }}</span>
                                </div>
                                <div class="siparis_ac">
                                    <a href="javascript:;" title="Sipariş Detayı">
                                        <div class="siparis_ok" id="ok_{{ order.id }}" data-id="{{ order.id }}">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="dn"></div>

                        <div class="siparis_detay" id="detay_{{ order.id }}" style="display: none;">
                            <input type="hidden" id="uyari">
                            <div class="siparis_durum_onmobile">
                                <?php
                                setlocale(LC_MONETARY, 'tr_TR');
                                $format = number_format($order->total_price, 2, ',', '.');
                                ?>
                                <p>{{ format }} {{ order.currency }}</p>
                                <span>{{ durum.name }}</span>
                            </div>
                            <div class="product_list">
                                <h3>Sipariş verilen ürünler</h3>

                                <ul>
                                    <?php
                                    $products = \Yabasi\Order::find('top_id='.$order->id);
                                    ?>
                                    {% if products is not null %}
                                        {% for product in products %}
                                            <?php
                                            $parse = json_decode($product->meta_value);
                                            $pros = \Yabasi\Product::findFirst($product->pro_id); ?>
                                            {% if pros is not null %}
                                                <?php
                                                $image = 'media/resimyok.png';
                                                $images = \Yabasi\Images::findFirst('meta_key="product" and status=1 and content_id='.$product->pro_id);
                                                      if ($images) {
                                                      $image = 'media/product/'.$images->meta_value;
                                                      }
                                                      $variants = '';
                                                      if ($parse->variant) {
                                                      $varcheck = explode(',',$parse->variant);
                                                      foreach ($varcheck as $var) {
                                                      $items = \Yabasi\Variant::findFirst($var);
                                                      if ($items) {
                                                      $variants .= $items->getName().", ";
                                                      }
                                                      }
                                                      $variants = substr(trim($variants), 0, -1);
                                                      }
                                                      ?>
                                                <li>

                                                    <div class="product_content">
                                                        <div class="product_left w50">
                                                            <div class="product_image">
                                                                <img src="{{ url(image) }}" alt="ürün" width="90"/>
                                                            </div>
                                                            <div class="product_title">
                                                                <h6>
                                                                    <span class="fw700">{{ product.piece }} x </span>{{ pros.name }}
                                                                </h6>
                                                                <p class="variant">{{ variants }}</p>
                                                                <?php $format = number_format($product->total_price, 2,
                                                                ',', '.'); ?>
                                                                <p class="product_price">{{ format }} {{ product.currency }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="product_right w50 tar">

                                                            <div class="w100 iade dn" id="iade_{{ product.id }}">
                                                                <form class="w100">
                                                                    <div class="frmk_ic">
                                                                        <div class="frm_kutu grid-5 pl-16">
                                                                            <input type="text" name="name" value="" placeholder="Varsa notunuz">
                                                                        </div>
                                                                        <div class="frm_kutu grid-2">
                                                                            <select name="gun">
                                                                                <option value="00">İade</option>
                                                                                <option value="00">İptal</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="frm_kutu grid-2">
                                                                            <input type="number" class="input_number" min="0" max="{{ product.piece }}" name="name" value="{{ product.piece }}" placeholder="Adet">
                                                                        </div>
                                                                        <div class="frm_kutu iade input_button">
                                                                            <div class="vam">
                                                                                <a href="javascript:;" data-id="{{ product.id }}" class="btn btn_mavi iadeislem">işlemi başlat</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="w100 iade open-iade" data-id="{{ product.id }}">
                                                                <div class="vam">
                                                                    <a href="javascript:;" class="btn btn_mavi">iade veya iptal et</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </li>

                                            {% endif %}
                                        {% endfor %}
                                    {% endif %}
                                </ul>
                            </div>

                            <h3>Adres bilgileri</h3>
                            <div class="siparis_adresleri">
                                <div class="teslimat">
                                    <h6>Teslimat Adresi</h6>
                                    <p>{{ value.delivery_address }}</p>
                                </div>
                                <div class="fatura">
                                    <h6>Fatura Adresi</h6>
                                    <p>{{ value.invoice_address }}</p>
                                </div>
                            </div>

                            <div class="siparis_adresleri">
                                <div class="siparis_odeme w50">
                                    <h3 class="p10-0">Ödeme ve kargo bilgileri</h3>
                                    <?php $ptype = \Yabasi\Paymenttype::findFirst($value->payment_type);?>
                                    {% if ptype is not null %}
                                        <p><b>Ödeme yöntemi</b>: {{ ptype.name }}</p>
                                    {% endif %}
                                    <?php $cargo = \Yabasi\Cargo::findFirst($value->cargo);?>
                                    {% if cargo is not null %}
                                        <p><b>Kargo</b>: {{ cargo.name }}</p>
                                    {% endif %}
                                    {% if order.cargo_number is not '' %}
                                        <p><b>Kargo takip numarası: </b> {{ order.cargo_number }}</p>
                                    {% endif %}
                                </div>

                                <div class="siparis_odeme w50">
                                    <h3 class="p10-0">Sipariş detayları</h3>
                                    <p>
                                        <b>Hediye paketi: </b> {% if value.gift_package is '1' %}İstiyorum{% else %}İstemiyorum{% endif %}
                                    </p>
                                    {% if value.gift_note is not '' %}
                                        <p><b>Sipariş nou: </b> {{ value.gift_note }}</p>
                                    {% endif %}

                                </div>
                            </div>

                        </div>
                    {% endfor %}
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

    $(document).ready(function () {

        $('.siparis_ok').click(function () {
            const id = $(this).data('id');
            cleanbg();
            $('#siparis_' + id).addClass('gray-bg');
            $('#detay_' + id).slideToggle(function () {
                if ($(this).is(":hidden")) {
                    $('#ok_' + id + ' i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                } else {
                    $('#ok_' + id + ' i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                }
            });
        });

        $('.open-iade').click(function () {
            const id = $(this).data('id');
            $(this).addClass('dn');
            $('#iade_'+id).removeClass('dn');
        });

        $('.iadeislem').click(function () {
            $('#uyari').removeClass('dn');
        });

    });

    function cleanbg() {
        $('.siparis').each(function () {
            $(this).removeClass('gray-bg');
        });
    }

</script>

