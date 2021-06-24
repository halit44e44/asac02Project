<style>
    #haftalik_chart { width: 100%; height: 400px; }
</style>

<!--#toplam veriler başlar-->
<div class="row">
    <div class="col-xl-3">
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ url('assets/theme7/media/svg/shapes/abstract-1.svg') }})">
            <div class="card-body">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <rect fill="#000000" opacity="0.3" x="2" y="2" width="10" height="12" rx="2"/>
                            <path d="M4,6 L20,6 C21.1045695,6 22,6.8954305 22,8 L22,20 C22,21.1045695 21.1045695,22 20,22 L4,22 C2.8954305,22 2,21.1045695 2,20 L2,8 C2,6.8954305 2.8954305,6 4,6 Z M18,16 C19.1045695,16 20,15.1045695 20,14 C20,12.8954305 19.1045695,12 18,12 C16.8954305,12 16,12.8954305 16,14 C16,15.1045695 16.8954305,16 18,16 Z" fill="#000000"/>
                        </g>
                    </svg>
                </span>
                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">
                    {% if totalorder is defined %}
                        {{ totalorder }}
                    {% endif %}
                </span>
                <span class="font-weight-bold text-muted font-size-sm">Toplam Kazanç</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ url('assets/theme7/media/svg/shapes/abstract-1.svg') }})">
            <div class="card-body">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M13,5 L15,5 L15,20 L13,20 L13,5 Z M5,5 L5,20 L3,20 C2.44771525,20 2,19.5522847 2,19 L2,6 C2,5.44771525 2.44771525,5 3,5 L5,5 Z M16,5 L18,5 L18,20 L16,20 L16,5 Z M20,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,19 C22,19.5522847 21.5522847,20 21,20 L20,20 L20,5 Z" fill="#000000"/>
                            <polygon fill="#000000" opacity="0.3" points="9 5 9 20 7 20 7 5"/>
                        </g>
                    </svg>
                </span>
                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{% if totalproduct is defined %}{{ totalproduct }}{% endif %}</span>
                <span class="font-weight-bold text-muted font-size-sm">Toplam Ürün</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ url('assets/theme7/media/svg/shapes/abstract-1.svg') }})">
            <div class="card-body">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                        </g>
                    </svg>
                </span>
                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{% if totaluser is defined %}{{ totaluser }}{% endif %}</span>
                <span class="font-weight-bold text-muted font-size-sm">Toplam Kullanıcı</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ url('assets/theme7/media/svg/shapes/abstract-1.svg') }})">
            <div class="card-body">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"/>
                            <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"/>
                        </g>
                    </svg>
                </span>
                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block">{% if totalcomment is defined %}{{ totalcomment }}{% endif %}</span>
                <span class="font-weight-bold text-muted font-size-sm">Toplam Yorum</span>
            </div>
        </div>
    </div>
</div>
<!--#toplam veriler biter-->

<!--#toplam diger veriler başlar-->
<div class="row">
    <div class="col-xl-3">
        <!--begin::Stats Widget 22-->
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url('{{ url('assets/theme7/media/svg/shapes/abstract-4.svg') }}')">
            <!--begin::Body-->
            <div class="card-body my-4">
                <a href="{{ url('backend/refund') }}" class="card-title font-weight-bolder text-success font-size-h6 mb-4 text-hover-state-dark d-block">İade Talepleri</a>
                <div class="font-weight-bold text-muted font-size-sm">
                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{% if total_refund is defined %}{{ total_refund }}{% endif %}</span>Bugüne kadar gerçekleşen <span class="font-weight-bolder text-black-50">iade talepleri</span></div>
                <div class="progress progress-xs mt-7 bg-success-o-60">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 67%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 22-->
    </div>
    <div class="col-xl-3">
        <!--begin::Stats Widget 22-->
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url('{{ url('assets/theme7/media/svg/shapes/abstract-3.svg') }}')">
            <!--begin::Body-->
            <div class="card-body my-4">
                <a href="{{ url('backend/pnotification') }}" class="card-title font-weight-bolder text-primary font-size-h6 mb-4 text-hover-state-dark d-block">Ödeme Bildirimleri</a>
                <div class="font-weight-bold text-muted font-size-sm">
                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{% if total_pnotification is defined %}{{ total_pnotification }}{% endif %}</span>Bugüne kadar gerçekleşen <span class="font-weight-bolder text-black-50">ödeme bildirimleri</span></div>
                <div class="progress progress-xs mt-7 bg-primary-o-60">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 67%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 22-->
    </div>
    <div class="col-xl-3">
        <!--begin::Stats Widget 22-->
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url('{{ url('assets/theme7/media/svg/shapes/abstract-2.svg') }}')">
            <!--begin::Body-->
            <div class="card-body my-4">
                <a href="{{ url('backend/setting/pointlogs') }}" class="card-title font-weight-bolder text-info font-size-h6 mb-4 text-hover-state-dark d-block">Kazanılan Puan</a>
                <div class="font-weight-bold text-muted font-size-sm">
                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{% if point_earning is defined %}{{ point_earning }}{% endif %}</span>Bugüne kadar kazanılan <span class="font-weight-bolder text-black-50">toplam puan</span></div>
                <div class="progress progress-xs mt-7 bg-info-o-60">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 67%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 22-->
    </div>
    <div class="col-xl-3">
        <!--begin::Stats Widget 22-->
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url('{{ url('assets/theme7/media/svg/shapes/abstract-2.svg') }}')">
            <!--begin::Body-->
            <div class="card-body my-4">
                <a href="javascript:;" class="card-title font-weight-bolder text-danger font-size-h6 mb-4 text-hover-state-dark d-block">Lisans bitiş tarihi</a>
                <div class="font-weight-bold text-muted font-size-sm">

                    <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2"> {% if licenceTarih is defined %}
                            {{ licenceTarih }} Gün
                        {% endif %}</span>
                    {% if tarih is defined %}
                        {{ tarih }}
                    {% endif %}<br>
                    <span class="font-weight-bolder text-black-50">lisansınızın bitişine kalan süre</span></div>
                <div class="progress progress-xs mt-7 bg-info-o-60">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 67%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 22-->
    </div>
</div>
<!--#toplam diger veriler biter-->

<!--#siparişler başlar-->
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header bg-light-light border-0 pt-5 mb-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Siparişler</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">Son verilen 5 sipariş</span>
                </h3>

            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-2">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-head-custom table-head-bg table-borderless table-vertical-center vizorRecentOrder">
                        <tbody>

                        {% if orders is defined %}
                            {% for order in orders %}
                                <?php
                                $user = \Yabasi\User::findFirst('id='.$order->user_id);
                                ?>
                                {% if user is not null %}
                                    <?php
                                    $parsed = json_decode($order->meta_value, true);
                                                                                                        $order_type = \Yabasi\Ordertype::findFirst($order->order_status);
                                                                                                        $payment_type = \Yabasi\Paymenttype::findFirst($parsed['payment_type']);

                                                                                                        ?>
                                    <tr onclick="window.location.href='{{ url('backend/order/detail/' ~ order.id) }}'">
                                        <td data-field="name" aria-label="" class="datatable-cell"><span style="width: 250px;">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-40 symbol-light-success flex-shrink-0">
                                                    <span class="symbol-label font-size-h4 font-weight-bold"><?php echo mb_substr($user->name, 0,1); ?></span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ user.name }}</div>
                                                    <a href="javascript:;" class="text-muted font-weight-bold text-hover-primary">{{ user.email }}</a>
                                                </div>
                                            </div>
                                        </span>
                                        </td>
                                        <td class="d-none d-sm-block">
                                            <span href="#" class=" font-weight-bolder font-size-lg mb-0">{{ parsed['code'] }}</span><br>
                                            <span class="text-muted font-weight-bold"><?php echo gmdate("d.m.Y H:i:s", $order->created_at); ?></span>
                                        </td>

                                        <td class="text-right">
                                            {% set type_color = '' %}
                                            {% if order_type.id is 1 %}
                                                {% set type_color = 'info' %}
                                            {% elseif order_type.id is 2 %}
                                                {% set type_color = 'info' %}
                                            {% elseif order_type.id is 3 %}
                                                {% set type_color = 'success' %}
                                            {% elseif order_type.id is 4 %}
                                                {% set type_color = 'warning' %}
                                            {% elseif order_type.id is 5 %}
                                                {% set type_color = 'success' %}
                                            {% elseif order_type.id is 6 %}
                                                {% set type_color = 'success' %}
                                            {% elseif order_type.id is 7 %}
                                                {% set type_color = 'primary' %}
                                            {% elseif order_type.id is 8 %}
                                                {% set type_color = 'success' %}
                                            {% elseif order_type.id is 9 %}
                                                {% set type_color = 'danger' %}
                                            {% else %}
                                                {% set type_color = 'success' %}
                                            {% endif %}
                                            <span class="label label-lg label-light-{{ type_color }} label-inline">{{ order_type.name }}</span>
                                        </td>

                                        <td class="text-right">
                                            <?php
                                            setlocale(LC_MONETARY, 'tr_TR');
                                            $ordertprice = number_format($order->total_price, 2, ',', '.');
                                            ?>
                                            <span class="text-danger font-weight-bolder d-block font-size-lg">{{ ordertprice }} {{ order.currency }}</span>
                                            <span class="text-muted font-weight-bold">{{ payment_type.name }}</span>
                                        </td>

                                    </tr>
                                {% endif %}
                            {% endfor %}
                        {% endif %}

                        </tbody>
                    </table>
                    <div class="text-center text-muted pt-10 pb-5 dn">
                        Kullanıcı henüz alışveriş yapmadı!
                    </div>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
<!--#siparişler biter-->

<!--#haftalık raporlar biter-->
<div class="row">
    <div class="col-xl-12">
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header h-auto border-0">
                <div class="card-title py-5">
                    <h3 class="card-label">
                        <span class="d-block text-dark font-weight-bolder">Haftalık Raporlar</span>
                        <span class="d-block text-muted mt-2 font-size-sm">Son 1 haftanın analiz edilen verileri</span>
                    </h3>
                </div>
                <div class="card-toolbar">
                    <span class="mr-5 d-flex align-items-center font-weight-bold"><i class="label label-dot label-xl label-primary mr-2"></i>Sipariş</span>
                    <span class="mr-5 d-flex align-items-center font-weight-bold"><i class="label label-dot label-xl label-info mr-2"></i>Üye</span>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-3 d-flex flex-column">
                        <!--begin::Block-->
                        <div class="bg-light-info p-8 rounded-xl flex-grow-1">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-circle symbol-white symbol-30 flex-shrink-0 mr-3">
                                    <div class="symbol-label">
                                        <span class="svg-icon svg-icon-md svg-icon-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-size-sm font-weight-bold">{% if weekly_earnings is defined %}{{ weekly_earnings }}{% endif %}</div>
                                    <div class="font-size-sm text-muted">Kazanç</div>
                                </div>
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-circle symbol-white symbol-30 flex-shrink-0 mr-3">
                                    <div class="symbol-label">
                                        <span class="svg-icon svg-icon-md svg-icon-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                    <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-size-sm font-weight-bold">{% if weekly_sales is defined %}{{ weekly_sales }}{% endif %}</div>
                                    <div class="font-size-sm text-muted">Satış adeti</div>
                                </div>
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-circle symbol-white symbol-30 flex-shrink-0 mr-3">
                                    <div class="symbol-label">
                                        <span class="svg-icon svg-icon-md svg-icon-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M9.07117914,12.5710461 L13.8326627,12.5710461 C14.108805,12.5710461 14.3326627,12.3471885 14.3326627,12.0710461 L14.3326627,0.16733734 C14.3326627,-0.108805035 14.108805,-0.33266266 13.8326627,-0.33266266 C13.6282104,-0.33266266 13.444356,-0.208187188 13.3684243,-0.0183579985 L8.6069408,11.8853508 C8.50438409,12.1417426 8.62909204,12.4327278 8.8854838,12.5352845 C8.94454394,12.5589085 9.00756943,12.5710461 9.07117914,12.5710461 Z" fill="#000000" opacity="0.3" transform="translate(11.451854, 6.119192) rotate(-270.000000) translate(-11.451854, -6.119192)" />
                                                    <path d="M9.23851648,24.5 L14,24.5 C14.2761424,24.5 14.5,24.2761424 14.5,24 L14.5,12.0962912 C14.5,11.8201488 14.2761424,11.5962912 14,11.5962912 C13.7955477,11.5962912 13.6116933,11.7207667 13.5357617,11.9105959 L8.77427814,23.8143047 C8.67172143,24.0706964 8.79642938,24.3616816 9.05282114,24.4642383 C9.11188128,24.4878624 9.17490677,24.5 9.23851648,24.5 Z" fill="#000000" transform="translate(11.500000, 18.000000) scale(1, -1) rotate(-270.000000) translate(-11.500000, -18.000000)" />
                                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="11" y="2" width="2" height="20" rx="1" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-size-sm font-weight-bold">{% if weekly_refund is defined %}{{ weekly_refund }}{% endif %}</div>
                                    <div class="font-size-sm text-muted">İade talepleri</div>
                                </div>
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-circle symbol-white symbol-30 flex-shrink-0 mr-3">
                                    <div class="symbol-label">
                                        <span class="svg-icon svg-icon-success svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"/>
                                                    <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-size-sm font-weight-bold">{% if weekly_comment is defined %}{{ weekly_comment }}{% endif %}</div>
                                    <div class="font-size-sm text-muted">Yorumlar</div>
                                </div>
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <div class="symbol symbol-circle symbol-white symbol-30 flex-shrink-0 mr-3">
                                    <div class="symbol-label">
                                        <span class="svg-icon svg-icon-primary svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-size-sm font-weight-bold">{% if weekly_user is defined %}{{ weekly_user }}{% endif %}</div>
                                    <div class="font-size-sm text-muted">Yeni kullanıcı</div>
                                </div>
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-white symbol-30 flex-shrink-0 mr-3">
                                    <div class="symbol-label">
                                        <span class="svg-icon svg-icon-danger svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-size-sm font-weight-bold">{% if weekly_request is defined %}{{ weekly_request }}{% endif %}</div>
                                    <div class="font-size-sm text-muted">Ürün talepleri</div>
                                </div>
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Block-->
                    </div>
                    <div class="col-12 col-lg-9">
                        <div id="haftalik_chart"></div>
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
<!--#haftalık raporlar biter-->

<!--#yorumlar başlar-->
<div class="card card-custom gutter-b">
    <div class="card-header border-0 py-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Yorumlar</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">Son yapılan 5 yorum</span>
        </h3>
    </div>
    <div class="card-body pt-0 pb-3">
        <div class="tab-content">
            <!--begin::Table-->
            <div class="table-responsive">
                <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                    <thead>
                    <tr class="text-left text-uppercase">
                        <th style="min-width: 250px" class="pl-7">ürün</th>
                        <th style="min-width: 150px;">puan</th>
                        <th style="min-width: 130px">yorum</th>
                        <th style="min-width: 80px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    {% if comments is defined %}
                    {% for item in comments %}
                        <?php
                        $pros = \Yabasi\Product::findFirst($item->pro_id);
                        $pro_name = '';
                        $pro_image = '';
                        $pro_sef = '';
                        if ($pros) {
                            $pro_name = $pros->getName();
                            $pro_sef  = $pros->getSef();
                            $images = Yabasi\Images::findFirst('status=1 and meta_key="product" and content_id=' . $pros->getId());
                            if ($images) {
                                $pro_image = $images->getMetaValue();
                            }
                        }
                        ?>

                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50 symbol-light mr-4">
                                    <span class="symbol-label">
                                        <i style="width: 100%; height: 100%;background: url('{{ url('media/product/' ~ pro_image) }}') center center no-repeat;background-size: 100%;"></i>
                                    </span>
                                </div>
                                <div>
                                    <a target="_blank" href="{{ 'urun/' ~ pro_sef }}" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ pro_name }}</a>
                                    <span class="text-muted font-weight-bold d-block">{{ item.ip_address }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            {% for i in 1..item.point %}
                                <i class="fa fa-star"></i>
                            {% endfor %}
                        </td>
                        <td>
                            <span class="text-muted font-weight-bold">{{ item.comment }}</span>
                        </td>
                        <td class="pr-0 text-right">
                            <a href="{{ url('backend/comment') }}" class="btn btn-light-success font-weight-bolder font-size-sm">Detay</a>
                        </td>
                    </tr>
                    {% endfor %}
                    {% endif %}
                    </tbody>
                </table>
            </div>
            <!--end::Table-->
        </div>
    </div>
</div>
<!--#yorumlar biter-->



<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>

    var _initChartsWidget6 = function () {

        var element = document.getElementById("haftalik_chart");

        if (!element) {
            return;
        }

        var options = {
            series: {% if weekly_chart is defined %}{{ weekly_chart }}{% endif %},
            chart: {
                stacked: true,
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    stacked: true,
                    horizontal: false,
                    endingShape: 'rounded',
                    columnWidth: ['12%']
                },
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            yaxis: {
                max: 10,
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            fill: {
                opacity: 1
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['base']['info'], KTApp.getSettings()['colors']['theme']['base']['primary'], KTApp.getSettings()['colors']['theme']['light']['primary']],
            grid: {
                borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                }
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    var _initChartsWidget3 = function() {
        var element = document.getElementById("aylik_chart");

        if (!element) {
            return;
        }

        var options = {
            series: [{
                name: 'Net Kazanç',
                data: [30, 40, 40, 90, 90, 70, 70]
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {

            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [KTApp.getSettings()['colors']['theme']['base']['info']]
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                },
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: KTApp.getSettings()['colors']['theme']['base']['info'],
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: KTApp.getSettings()['font-family']
                },
                y: {
                    formatter: function(val) {
                        return "₺" + val
                    }
                }
            },
            colors: [KTApp.getSettings()['colors']['theme']['light']['info']],
            grid: {
                borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                //size: 5,
                //colors: [KTApp.getSettings()['colors']['theme']['light']['danger']],
                strokeColor: KTApp.getSettings()['colors']['theme']['base']['info'],
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    }

    $(document).ready(function () {
        //_initChartsWidget6();
        _initChartsWidget3();
    });


</script>

<script>
    am4core.ready(function() {

        am4core.useTheme(am4themes_animated);

        var chart = am4core.create('haftalik_chart', am4charts.XYChart)
        chart.colors.step = 2;



        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
        xAxis.dataFields.category = 'category'
        xAxis.renderer.cellStartLocation = 0.1
        xAxis.renderer.cellEndLocation = 0.9
        xAxis.renderer.grid.template.location = 0;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries())
            series.dataFields.valueY = value
            series.dataFields.categoryX = 'category'
            series.columns.template.tooltipText = name+" : "+"{valueY}";
            series.columns.template.strokeWidth = 0;
            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet())
            bullet.interactionsEnabled = false
            bullet.dy = 30;
            bullet.label.fill = am4core.color('#ffffff')

            return series;
        }

        chart.dataSource.url = "api/v3/get/vizor";
        chart.dataSource.parser = new am4core.CSVParser();
        chart.dataSource.parser.options.useColumnNames = true;
        chart.dataSource.parser.options.reverse = true;
        chart.leftAxesContainer.layout = "vertical";


        createSeries('first', 'Yeni Sipariş',);
        createSeries('second', 'Yeni Üye',true);


        function arrangeColumns() {

            var series = chart.series.getIndex(0);

            var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
            if (series.dataItems.length > 1) {
                var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                var delta = ((x1 - x0) / chart.series.length) * w;
                if (am4core.isNumber(delta)) {
                    var middle = chart.series.length / 2;

                    var newIndex = 0;
                    chart.series.each(function(series) {
                        if (!series.isHidden && !series.isHiding) {
                            series.dummyData = newIndex;
                            newIndex++;
                        }
                        else {
                            series.dummyData = chart.series.indexOf(series);
                        }
                    })
                    var visibleCount = newIndex;
                    var newMiddle = visibleCount / 2;

                    chart.series.each(function(series) {
                        var trueIndex = chart.series.indexOf(series);
                        var newIndex = series.dummyData;

                        var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                        series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                        series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                    })
                }
            }
        }

    }); // end am4core.ready()
</script>
