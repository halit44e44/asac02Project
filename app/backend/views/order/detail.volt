<div class="card card-custom">
    <div class="card-body p-0">
        <!--begin::Invoice-->
        <div class="row justify-content-center pt-8 px-8 pt-md-27 px-md-0">
            <div class="col-md-10">
                <!-- begin: Invoice header-->
                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10">
                        {% if code is defined %}
                            #{{ code }}
                        {% endif %}
                    </h1>
                    <div class="d-flex flex-column align-items-md-end px-0">

                        <a href="javascript:;" class="mb-5 max-w-200px">
                            <img src="{{ url('media/theme_content/logo/' ~ logo) }}" alt="Logo"/>
                        </a>

                        <span class="d-flex flex-column align-items-md-end font-size-h5 font-weight-bold text-muted">
                            <span>
                                {% if address is defined %}
                                    {{ address }}
                                {% endif %}
                            </span>
                            {% if district is defined %}
                                {% if city is defined %}
                                    <span>{{ district ~ ", " ~ city }}</span>
                                {% endif %}
                            {% endif %}
                            {% if country is defined %}
                                <span>{{ country }}</span>
                            {% endif %}
                        </span>


                    </div>
                </div>

                <div class="row border-bottom pb-10">
                    <div class="col-md-9 py-md-10 pr-md-10">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0  font-weight-bolder text-muted font-size-lg text-uppercase">
                                        Ürün
                                    </th>
                                    <th lang="tr" class="pt-1 pb-9 pl-0 text-center font-weight-bolder text-muted font-size-lg text-uppercase">
                                        Fiyat
                                    </th>

                                    <th class="pt-1 pb-9 text-center pr-0 font-weight-bolder text-muted font-size-lg text-uppercase ">
                                        Adet
                                    </th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase ">
                                        Durum
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                {% if products is defined %}
                                    {% set total = 0 %}
                                    {% for pro in products %}

                                        <?php
                                        $image_name = 'media/resimyok.png';
                                        $image = \Yabasi\Images::findFirst('content_id='.$pro['id'].' and meta_key="product" and status=1');
                                        if($image) {
                                           $image_name = 'media/product/'.$image->meta_value; } ?>
                                        <tr class="font-weight-bolder font-size-lg">

                                            <td class="pl-0 pt-7 d-flex align-items-center">
                                                <span class="navi-icon mr-2">
                                                    <img height="50" width="50" src="{{ image_name }}"/>
                                                </span>
                                                <span class="navi-icon mr-2">
                                                    {{ pro['name'] }}<br>
                                                    <small>{{ pro['variant'] }}</small>
                                                </span>


                                            </td>

                                        <td class="text text-center pt-7">{{ pro['item_price'] ~ " " ~ order_currency }}</td>
                                        <td class="text text-center pt-7">{{ pro['piece'] }}</td>
                                        <td class="text pt-7 text-right">
                                            <select onchange="orderstatus(this)" data-id="{{ pro['order_id'] }}"
                                                    class="form-control font-size-lg font-weight-bold" id="orderStatusValue_{{  pro['order_id'] }}"
                                                    style="width: 150px; float: right;"
                                                    name="orderStatus">
                                                {% if pro['status'] is defined %}
                                                    {% for types in orderStatus %}
                                                        <option {% if pro['status'] ==types.id %} selected {% endif %}value="{{ types.id }}">{{ types.name }}</option>
                                                    {% endfor %}
                                                {% endif %}
                                            </select>
                                        </td>
                                        </tr>

                                    {% endfor %}
                                {% endif %}
                                </tbody>
                            </table>
                        </div>
                        <div class="border-bottom w-100 mt-7 mb-13"></div>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="col-12 flex-column mb-10 mb-md-0">
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Ödeme Tipi:</span>
                                    <span class="text-right font-weight-boldest">
                                        {% if payment_type is defined %}
                                            {{ payment_type.name }}
                                        {% endif %}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom w-100 mt-7 mb-13"></div>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="col-12 mb-10 mb-md-0">
                                <div class="d-flex justify-content-between font-size-lg mb-5">
                                    <span class="font-weight-bold mr-18">Kargo Adı:</span>
                                    <span class="text-right font-weight-boldest">
                                        {% if cargo is defined %}
                                            {{ cargo }}
                                        {% endif %}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-5">
                                    <span class="font-weight-bold mr-15">Kargo Ücreti:</span>
                                    <span class="text-right font-weight-boldest">
                                        {% if cargo_price is defined %}
                                            {{ cargo_price ~ " " ~ currency }}
                                        {% endif %}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-5">
                                    <span class="font-weight-bold mr-15">Kargo Takip Numarası:</span>
                                    <span class="text-right font-weight-boldest">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" id="cargo_number" data-id="{{ id }}" class="form-control" placeholder="Kargo takip numarasını yazınız.." value="{% if order.cargo_number is defined %}{{ order.cargo_number}}{% endif %}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="cargo_button" type="button">Kaydet</button>
                                                </div>
                                            </div>
                                        </div>
                                    </span>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 border-left-md pl-md-10 py-md-10 text-right">
                        <!--begin::Total Amount-->
                        <div class="font-size-h4 font-weight-bolder text-muted mb-3">TOPLAM TUTAR</div>
                        <div class="font-size-h1 font-weight-boldest text-success">
                            {% if order.total_price is defined %}
                                <?php setlocale(LC_MONETARY, 'tr_TR'); echo number_format($order->total_price, 2, ',', '.')." ". $currency; ?>
                            {% endif %}
                        </div>
                        <div class="text-muted font-weight-bold mb-5">Vergiler + Kargo dahil</div>

                        <div class="border-bottom w-100 mb-5"></div>
                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">MÜŞTERİ BİLGİLERİ</div>
                        <div class="font-size-lg mb-10">
                            {% if user_name is defined %}{{ user_name }}{% endif %}
                            <br>
                            TC No: {% if user_idno is defined %}{{ user_idno }}{% endif %}
                        </div>

                        <div class="border-bottom w-100 mb-5"></div>
                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">TESLİMAT ADRESİ</div>
                        <div class="font-size-lg mb-10">
                            {% if delivery_address is defined %}
                                {{ delivery_address }}
                            {% endif %}
                            <br>
                        </div>

                        <div class="border-bottom w-100 mb-5 mt-5"></div>
                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">FATURA ADRESİ</div>
                        <div class="font-size-lg mb-10">
                            {% if invoice_address is defined %}
                                {{ invoice_address }}
                            {% endif %}
                        </div>

                        <div class="border-bottom w-100 mb-5 mt-5"></div>

                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">SİPARİŞ TARİHİ</div>
                        <div class="font-size-lg ">
                            {% if order_date is defined %}
                                {{ date("d.m.Y  H:m:s", order_date) }}
                            {% endif %}

                        </div>
                        <div class="border-bottom w-100 mb-5 mt-5"></div>
                        <div class="form-group">
                            <label class="text-dark-50 font-size-lg font-weight-bold mb-3">SİPARİŞ DURUMU</label>
                            <select onchange="orderstatus(this)" data-id="{{ id }}" data-type="order"
                                    class="form-control font-size-lg font-weight-bold" id="orderStatusValue_{{ id }}"
                                    name="orderStatus">
                                {% if orderStatus is defined %}
                                    {% for types in orderStatus %}
                                        <option {% if orderStatusValue==types.id %} selected
                                                                                    {% endif %}value="{{ types.id }}">{{ types.name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>


                    </div>
                <!--end: Invoice body-->
            </div>
        </div>

        <!-- begin: Invoice action-->

        <!-- end: Invoice action-->

        <!--end::Invoice-->
    </div>
        <div class="row justify-content-center py-8 px-8 py-md-28 px-md-0">
            <div class="col-md-10">
                <div class="d-flex font-size-sm flex-wrap">
                    <button type="button" class="btn btn-primary font-weight-bolder py-4 mr-3 mr-sm-14 my-1"
                            onclick="window.print();">Yazdır
                    </button>
                    <button type="button" class="btn btn-dark font-weight-bolder ml-sm-auto my-1"
                            onclick="window.print();">İndir
                    </button>

                </div>
            </div>
        </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $('#cargo_button').click(function (){
            var cargo=$('#cargo_number').val();
            var id=$('#cargo_number').data('id');
            $.ajax(base_url + 'order/cargo/'+ id+'/'+cargo, function (data) {
            });
        });
        $('[data-toggle="popover"]').popover({
            trigger: 'focus',
            html: true,
            content: function () {
                return '<img class="img-fluid" src="' + $(this).data('img') + '" />';
            },
            title: 'Toolbox'
        });


    });

    function orderstatus(el) {
        const id = $(el).data('id');
        var e = document.getElementById("orderStatusValue_"+id);
        var status = e.options[e.selectedIndex].value;
        $.ajax(base_url + 'order/do/' + id + '/' + status+'/', function (data) {
        });
    }


</script>