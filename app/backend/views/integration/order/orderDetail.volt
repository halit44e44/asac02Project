<div class="card card-custom">
    <div class="card-body p-0">
        <!--begin::Invoice-->
        <div class="row justify-content-center pt-8 px-8 pt-md-27 px-md-0">
            <div class="col-md-9">
                <!-- begin: Invoice header-->
                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                    <h1 class="display-4 font-weight-boldest mb-10">
                        {% if orderNumber is defined %}
                            #{{ orderNumber }}
                        {% endif %}
                    </h1>
                    <div class="d-flex flex-column align-items-md-end px-0">
                        <!--begin::Logo-->
                        <a href="#" class="mb-5 max-w-200px">
                            <img src="{{ url('/media/system/logo.png') }}" alt="Logo"/>
                        </a>
                        <!--end::Logo-->


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

                <!--end: Invoice header-->
                <!--begin: Invoice body-->
                <div class="row border-bottom pb-10">
                    <div class="col-md-9 py-md-10 pr-md-10">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="pt-1 pb-9 pl-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                        Ürün
                                    </th>
                                    <th class="pt-1 pb-9 pl-0 font-weight-bolder text-muted font-size-lg text-uppercase">
                                        Fiyat
                                    </th>
                                    <th class="pt-1 pb-9 text-right pr-0 font-weight-bolder text-muted font-size-lg text-uppercase ">
                                        Durum
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    {% if productList is defined %}
                                        {% for product in productList %}
                                            <tr class="font-weight-bolder font-size-lg">
                                                <td class="border-top-0 pl-0 pt-7 d-flex align-items-center">
                                                    <span class="navi-icon mr-2">
                                                        <img height="50" width="50" src="{{ url('/media/product/' ~ product['image']) }}"/>
                                                    </span>
                                                    {{ product['name'] }}
                                                </td>

                                            <td class="text pt-7">{{ product['amount'] ~ '₺'}}</td>
                                            <td class="text pt-7 text-right">
                                                {{ product['status'] }}
                                                </td>
                                            </tr>
                                        {% endfor %}
                                    {% endif %}
                                </tbody>
                            </table>
                        </div>
                        <div class="border-bottom w-100 mt-7 mb-13"></div>
                        <div class="d-flex flex-column flex-md-row">
                            <div class="d-flex flex-column mb-10 mb-md-0">
                                <div class="font-weight-bold font-size-h6 mb-3">KARGO BİLGİLERİ</div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-18">Kargo Adı:</span>
                                    <span class="text-right font-weight-boldest">
                                        {% if shipmentCompany is defined %}
                                            {{ shipmentCompany }}
                                        {% endif %}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between font-size-lg mb-3">
                                    <span class="font-weight-bold mr-15">Kargo Takip Kodu:</span>
                                    <span class="text-right font-weight-boldest">
                                        {% if shipmentTrackingNumber is defined %}
                                            {{ shipmentTrackingNumber }}
                                        {% endif %}
                                    </span>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 border-left-md pl-md-10 py-md-10 text-right">
                        <!--begin::Total Amount-->
                        <div class="font-size-h4 font-weight-bolder text-muted mb-3">TOPLAM TUTAR</div>
                        <div class="font-size-h1 font-weight-boldest">
                            {% if totalPrice is defined %}
                                {{ totalPrice ~ '₺' }}
                            {% endif %}
                        </div>

                        <div class="border-bottom w-100 mb-5"></div>
                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">MÜŞTERİ BİLGİLERİ</div>
                        <div class="font-size-lg mb-10">
                            {% if buyerName is defined %}{{ buyerName }}{% endif %}
                            <br>
                            TC No: {% if buyerTc is defined %}{{ buyerTc }}{% endif %}
                        </div>

                        <div class="border-bottom w-100 mb-5"></div>
                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">TESLİMAT ADRESİ</div>
                        <div class="font-size-lg mb-10">
                            {% if shippingAddress is defined %}
                                {{ shippingAddress }}
                            {% endif %}
                            <br>
                        </div>

                        <div class="border-bottom w-100 mb-5 mt-5"></div>
                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">FATURA ADRESİ</div>
                        <div class="font-size-lg mb-10">
                            {% if billingAddress is defined %}
                                {{ billingAddress }}
                            {% endif %}
                        </div>

                        <div class="border-bottom w-100 mb-5 mt-5"></div>

                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">SİPARİŞ TARİHİ</div>
                        <div class="font-size-lg ">
                            {% if orderDate is defined %}
                                {{ orderDate }}
                            {% endif %}

                        </div>

                        <div class="border-bottom w-100 mb-5 mt-5"></div>

                        <div class="text-dark-50 font-size-lg font-weight-bold mb-3">SİPARİŞ DURUMU</div>
                        <div class="font-size-lg ">
                            {% if status is defined %}
                                {{ status }}
                            {% endif %}

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
            <div class="col-md-9">
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
</script>