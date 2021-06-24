<div class="card card-custom card-shadowless rounded-top-0">
    <div class="card-body p-0">
        <div class="row justify-content-center pr-20 pl-20 pt-10 pb-10">
            <div class="col-xl-12 col-xxl-12">
                <!--begin: Wizard Form-->
                <form class="form mt-0 mt-lg-10 fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
                    <!--begin: Wizard Step 1-->
                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">

                        <!--begin::Input-->
                        <div class="form-group fv-plugins-icon-container has-success">

                            <div class="row">
                                <div class="col-xl-6">
                                    <h1 class="display-4 font-weight-boldest mb-10">
                                        {% if refund_code is defined %}
                                            #{{ refund_code }}
                                        {% endif %}
                                    </h1>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="text-dark-50 font-size-lg font-weight-bold mb-3">SİPARİŞ
                                            DURUMU</label>
                                        <select onchange="orderstatus(this)" data-id="{{ id }}"
                                                class="form-control font-size-lg font-weight-bold" id="orderStatusValue"
                                                name="orderStatus">
                                            {% if orderStatus is defined %}
                                                {% for types in orderStatus %}
                                                    <option {% if orderStatusValue==types.id %} selected
                                                    {% endif %}
                                                            value="{{ types.id }}">{{ types.name }}</option>
                                                {% endfor %}
                                            {% endif %}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label>İsim Soyisim</label>
                            <!--<input type="text" class="form-control form-control-solid form-control-lg" name="fname" placeholder="First Name" value="John"> -->
                            <span class="form-control form-control-solid form-control-lg">
                                {% if user_name is defined %}
                                    {{ user_name }}
                                {% endif %}
                            </span>
                            <div class="fv-plugins-message-container"></div>
                        </div>
                        <!--end::Input-->
                        <!--begin::Input-->
                        <div class="form-group fv-plugins-icon-container has-success">

                            <!--end::Input-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>Telefon</label>
                                        <!--<input type="tel" class="form-control form-control-solid form-control-lg" name="phone" placeholder="phone" value="+61412345678">-->
                                        <span class="form-control form-control-solid form-control-lg">
                                        {% if user_phone is defined %}
                                            {{ user_phone }}
                                        {% endif %}
                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>Email</label>
                                        <span class="form-control form-control-solid form-control-lg">
                                            {% if user_email is defined %}
                                                {{ user_email }}
                                            {% endif %}

                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                        </div>
                        <!--end: Wizard Step 1-->
                        <!--begin: Wizard Step 2-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <div class="mb-10 font-weight-bold text-dark">İade / İptal Adresi</div>
                            <!--begin::Input-->
                            <div class="form-group fv-plugins-icon-container has-success">
                                <label>Müşteri Adresi</label>
                                <span class="form-control form-control-solid form-control-lg">
                                {% if user_address is defined %}
                                    {{ user_address }}
                                {% endif %}
                                </span>
                                <div class="fv-plugins-message-container"></div>
                            </div>
                            <!--end::Input-->

                            <div class="row">
                                <div class="col-xl-4">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>İlçe</label>
                                        <span class="form-control form-control-solid form-control-lg">
                                        {% if user_dist is defined %}
                                            {{ user_dist }}
                                        {% endif %}
                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-4">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>Şehir</label>
                                        <span class="form-control form-control-solid form-control-lg">
                                        {% if user_city is defined %}
                                            {{ user_city }}
                                        {% endif %}
                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-4">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>Ülke</label>
                                        <span class="form-control form-control-solid form-control-lg">
                                        {% if user_country is defined %}
                                            {{ user_country }}
                                        {% endif %}
                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <br/>
                            <div class="mb-10 font-weight-bold text-dark">Sipariş / İade Tarihi</div>
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>Sipariş Tarihi</label>
                                        <span class="form-control form-control-solid form-control-lg">
                                        {% if order_date is defined %}
                                            {{ date("d.m.Y  H:m:s", order_date) }}
                                        {% endif %}
                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>İade Tarihi</label>
                                        <span class="form-control form-control-solid form-control-lg">
                                        {% if create_at is defined %}
                                            {{ date("d.m.Y  H:m:s", create_at) }}
                                        {% endif %}
                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--end: Wizard Step 2-->
                        <!--begin: Wizard Step 3-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <div class="mb-10 font-weight-bold text-dark">Para İadesi  Bilgileri</div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <label>Hesap Sahibinin Adı</label>
                                    <span class="form-control form-control-solid form-control-lg">
                                    {% if user_name is defined %}
                                        {{ user_name }}
                                    {% endif %}
                                    </span>
                                    <div class="fv-plugins-message-container"></div>
                                    <!--end::Input-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label>Banka  Bilgileri</label>
                                        <span class="form-control form-control-solid form-control-lg">
                                        {% if refund.iban is defined %}
                                            {{ refund.iban }}
                                        {% endif %}
                                        </span>
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>

                        </div>
                        <!--end: Wizard Step 3-->
                        <!--begin: Wizard Step 4-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Section-->
                            <h4 class="mb-10 font-weight-bold text-dark">İade / İptal Edilmiş Ürün Bilgileri</h4>
                            <div class="text-dark-50 line-height-lg">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="pt-1 pb-9 pl-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                                Ürün
                                            </th>
                                            <th class="pt-1 pb-9 text-right font-weight-bolder text-muted font-size-lg text-uppercase">
                                                Fiyat
                                            </th>
                                            <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                                Tutar
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {% if refund_currency is defined %}
                                            {% if refund_currency === "TL" %}
                                                {% set refund_currency = "₺" %}
                                            {% elseif refund_currency === "USD" %}
                                                {% set refund_currency = "$" %}
                                            {% elseif refund_currency === "EURO" %}
                                                {% set refund_currency = "€" %}
                                            {% endif %}
                                        {% endif %}

                                        {% if products is defined %}
                                            {% set total = 0 %}
                                            {% for pro in products %}

                                                <?php
                                        $image_name = 'media/resimyok.png';
                                        $image = \Yabasi\Images::findFirst('content_id='.$pro['id'].' and meta_key="product" and status=1');
                                        if($image) {
                                           $image_name = 'media/product/'.$image->meta_value;
                                                                                                                                    }
                                                                                                                                    ?>

                                                <tr class="font-weight-bolder font-size-lg">
                                                    <td class="border-top-0 pl-0 pt-7 d-flex align-items-center">
                                                <span class="navi-icon mr-2">
                                                    <img height="50" width="50" src="{{ image_name }}"/>
                                                </span>
                                                        {{ pro['name'] }}
                                                    </td>

                                                    <td class="text-right pt-7">{{ pro['item_price'] ~ refund_currency }}</td>
                                                    <td class="pr-0 pt-7 font-size-h6 font-weight-boldest text-right">{{ (pro['item_price']) ~ refund_currency }}</td>
                                                </tr>
                                                {% set total +=  pro['item_price'] %}
                                            {% endfor %}
                                        {% endif %}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <h6 class="font-weight-bolder mb-3">Fiyat İşlemleri:</h6>
                            <div class="text-dark-50 line-height-lg">
                                <div>Toplam Fiyat :<span style="float:right;"><strong>
                                        {% if total_order is defined %}
                                            {{ total_order ~ refund_currency }}
                                        {% endif %}
                                        </strong></span></div>
                                <hr>
                                <div>İade Edilecek Tutar : <span style="float:right;"><strong>
                                        {% if refund_amount is defined %}
                                            {{ refund_amount ~ refund_currency }}
                                        {% endif %}
                                        </strong> </span>
                                </div>
                                <hr>
                                <div>Kalan Fiyat : <span style="float:right;"><strong>
                                        {% if total_order is defined %}
                                            {% if refund_amount is defined %}
                                                {{ total_order - refund_amount ~ refund_currency }}
                                            {% endif %}
                                        {% endif %}
                                        </strong></span></div>
                            </div>
                            <div class="separator separator-dashed my-5"></div>
                        </div>
                        <div class="form-group">
                            <label for="barcode_code">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <rect fill="#000000" opacity="0.3" x="4" y="5" width="16"
                                                              height="2" rx="1"/>
                                                        <rect fill="#000000" opacity="0.3" x="4" y="13" width="16"
                                                              height="2" rx="1"/>
                                                        <path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z"
                                                              fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </span>

                                Kullanıcı Yorumu
                            </label>
                            <textarea class="form-control form-control-solid" rows="4" name="short_content" id="short_content">{% if note is defined %}{{note}}{% endif %}</textarea>
                            <label>Ödenecek Tutar
                            </label>
                            <input class="form-control form-control-solid"  name="price" id="price" {% if note is defined %}value="{{ refund_amount }}"{% endif %}">

                        </div>
                        <!--end: Wizard Step 4-->
                        <!--begin: Wizard Actions-->
                        <div class="alert alert-secondary rounded-0 dn" role="alert"></div>
                        <div class="d-flex justify-content-between border-top mt-5 pt-10">
                            <div class="mr-2">
                                <a href="backend/refund/">
                                    <button type="button"
                                            class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4"
                                            data-wizard-type="action-prev"> Geri Dön
                                    </button>
                                </a>
                            </div>
                            <div>
                                <button type="button" data-id="{{ id }}" onclick="orderCancel(this)"
                                        class="btn btn-danger font-weight-bolder text-uppercase px-9 py-4"
                                        data-wizard-type="action-submit" >İptal Et
                                </button>
                                <button type="button" onclick="orderSave(this)" data-id="{{ id }}"
                                        class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                        data-wizard-type="action-next">Onayla
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end: Wizard Form-->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            trigger: 'focus',
            html: true,
            content: function () {
                return '<img class="img-fluid" src="' + $(this).data('img') + '" />';
            },
            title: 'Toolbox'
        })

    });

    function orderstatus(el) {
        const id = $(el).data('id');
        var e = document.getElementById("orderStatusValue");
        var status = e.options[e.selectedIndex].value;
        $.ajax(base_url + 'order/do/' + id + '/' + status, function (data) {

        });
    }

    function orderSave(el){
        const id=$(el).data('id');
        var text=document.getElementById('short_content').value;
        var price=document.getElementById('price').value;
        $.ajax({
            type: 'post',
            url: 'backend/refund/save/'+id+'/'+text+'/'+price,
            success: function (response) {
                if (response === 'ok') {
                    $('.alert').removeClass('dn').html('İşlem başarılı bir şekilde tamamlandı!');
                } else {
                    $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                }
            }
        });

    }
    function orderCancel(el){
        const id=$(el).data('id');
        var text=document.getElementById('short_content').value;
        var price=document.getElementById('price').value;
        $.ajax({
            type: 'post',
            url: 'backend/refund/cancel/'+id+"/"+text+"/"+price,
            success: function (response) {
                if (response === 'ok') {
                    $('.alert').removeClass('dn').html('İşlem başarılı bir şekilde tamamlandı!');
                } else {
                    $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                }
            }
        });

    }

</script>