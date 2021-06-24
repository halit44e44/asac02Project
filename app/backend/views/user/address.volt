<div class="main d-flex flex-column flex-row-fluid">

    <div class="content flex-column-fluid" id="kt_content">
        <!--begin::Profile Change Password-->
        <div class="d-flex flex-row">

            <!--begin::Aside-->
            <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
                <!--begin::Profile Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Body-->
                    <div class="card-body pt-4">

                        <!--begin::User-->
                        <div class="d-flex align-items-center mt-4">
                            <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                <div class="symbol-label" style="background-image:url('{{ url(user_image) }}')"></div>
                                <i class="symbol-badge bg-success"></i>
                            </div>
                            <div>
                                <a href="javascript:;" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{% if user is defined %}{{ user.name }}{% endif %}</a>
                                <div class="text-muted">{% if user_group is defined %}{{ user_group }}{% endif %}</div>
                                <div class="text-muted">Toplam Puan: <span class="text-success font-weight-bolder">{% if total_point is defined %}{{ total_point }}{% endif %}</span></div>
                                <div class="mt-2">
                                    <a href="mailto:{% if user is defined %}{{ user.email }}{% endif %}" class="btn btn-sm btn-primary font-weight-bold py-2 px-3 px-xxl-5 my-1">Email Gönder</a>
                                </div>
                            </div>
                        </div>
                        <!--end::User-->

                        <!--begin::Contact-->
                        <div class="py-9">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">Email:</span>
                                <a href="#" class="text-muted text-hover-primary">{% if user is defined %}{{ user.email }}{% endif %}</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold mr-2">Gsm:</span>
                                <span class="text-muted">{% if user is defined %}{{ user.phone }}{% endif %}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="font-weight-bold mr-2">Şehir:</span>
                                <span class="text-muted">Malatya</span>
                            </div>
                        </div>
                        <!--end::Contact-->

                        <!--begin::Nav-->
                        <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                            <div class="navi-item mb-2">
                                <a href="{{ url('backend/user/profile/vizor/' ~ user.id) }}" class="navi-link py-4">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                                        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    <span class="navi-text font-size-lg">Kullanıcı Vizörü</span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a href="{{ url('backend/user/profile/personal/' ~ user.id) }}" class="navi-link py-4">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    <span class="navi-text font-size-lg">Kişisel Bilgiler</span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a href="{{ url('backend/user/profile/address/' ~ user.id) }}" class="navi-link py-4 active">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    <span class="navi-text font-size-lg">Adres Bilgileri</span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a href="{{ url('backend/user/profile/password/' ~ user.id) }}" class="navi-link py-4">
                                        <span class="navi-icon mr-2">
                                            <span class="svg-icon">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    <span class="navi-text font-size-lg">Şifre Güncelle</span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a href="{{ url('backend/user/profile/notification/' ~ user.id) }}" class="navi-link py-4">
                                <span class="navi-icon mr-2">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" fill="#000000" opacity="0.3" />
                                                <path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" fill="#000000" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                    <span class="navi-text font-size-lg">Bildirim Ayarları</span>
                                </a>
                            </div>
                            <div class="navi-item mb-2">
                                <a href="{{ url('backend/login') }}" class="navi-link py-4">
                                <span class="navi-icon mr-2">
                                    <span class="svg-icon svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M7.62302337,5.30262097 C8.08508802,5.000107 8.70490146,5.12944838 9.00741543,5.59151303 C9.3099294,6.05357769 9.18058801,6.67339112 8.71852336,6.97590509 C7.03468892,8.07831239 6,9.95030239 6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,9.99549229 17.0108275,8.15969002 15.3875704,7.04698597 C14.9320347,6.73472706 14.8158858,6.11230651 15.1281448,5.65677076 C15.4404037,5.20123501 16.0628242,5.08508618 16.51836,5.39734508 C18.6800181,6.87911023 20,9.32886071 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 C4,9.26852332 5.38056879,6.77075716 7.62302337,5.30262097 Z" fill="#000000" fill-rule="nonzero"/>
                                                <rect fill="#000000" opacity="0.3" x="11" y="3" width="2" height="10" rx="1"/>
                                            </g>
                                        </svg>
                                    </span>
                                </span>
                                    <span class="navi-text font-size-lg">Çıkış</span>
                                </a>
                            </div>
                        </div>
                        <!--end::Nav-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Profile Card-->
            </div>
            <!--end::Aside-->

            <!--begin::Content-->
            <div class="flex-row-fluid ml-lg-8">
                <!--begin::Card-->
                <div class="row">
                    {% if address is defined %}
                        {% for adres in address %}

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b card-stretch">
                            <!--begin::Body-->
                            <div class="card-body pt-4">

                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-7 mt-3">

                                    <!--begin::Title-->
                                    <div class="d-flex flex-column">
                                        <a href="javascript:;" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">{{ adres.user_info }}</a>
                                        <span class="text-muted font-weight-bold">{{ adres.name }}</span>
                                    </div>
                                    <!--end::Title-->
                                </div>
                                <!--end::User-->

                                <p class="mb-7">{{ adres.address }}</p>

                                <!--begin::Info-->
                                <div class="mb-7">

                                    <div class="d-flex justify-content-between align-items-center my-2">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Gsm:</span>
                                        <a href="tel:{{ adres.phone }}" class="text-muted text-hover-primary">{{ adres.phone }}</a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center my-2">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Ülke:</span>
                                        <span class="text-muted font-weight-bold">
                                            <?php
                                            $ulke = \Yabasi\Country::findFirst('CountryID='.$adres->country_id);
                                            if ($ulke) {
                                                echo $ulke->CountryName;
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center my-2">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Şehir:</span>
                                        <span class="text-muted font-weight-bold">
                                            <?php
                                            $sehir = \Yabasi\City::findFirst('CityID ='.$adres->city_id);
                                            if ($sehir) {
                                                echo $sehir->CityName;
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center my-2">
                                        <span class="text-dark-75 font-weight-bolder mr-2">İlçe:</span>
                                        <span class="text-muted font-weight-bold">
                                            <?php
                                            $bolge = \Yabasi\Town::findFirst('TownID='.$adres->town_id);
                                            if ($bolge) {
                                                echo $bolge->TownName;
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center my-2">
                                        <span class="text-dark-75 font-weight-bolder mr-2">Posta Kodu:</span>
                                        <span class="text-muted font-weight-bold">{{ adres.zip_code }}</span>
                                    </div>

                                </div>
                                <!--end::Info-->
                                <a href="javascript:;" data-toggle="modal" data-target=".adresModal_{{ adres.id }}" class="btn btn-block btn-sm btn-light-primary font-weight-bolder text-uppercase py-4">Düzenle</a>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>

                        <div class="modal fade adresModal_{{ adres.id }}" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form class="addressForm" data-id="{{ adres.id }}" id="addressForm_{{ adres.id }}">

                                    <input type="hidden" name="user_id" value="{{ user.id }}">
                                    <input type="hidden" name="tab" value="address">
                                    <input type="hidden" name="address_id" value="{{ adres.id }}">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Adresi Düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label>Adres Tanımı <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" value="{{ adres.name }}" />
                                            </div>

                                            <div class="form-group">
                                                <label>Alıcı Adı Soyadı <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="user_info" value="{{ adres.user_info }}" />
                                            </div>

                                            <div class="form-group">
                                                <label>Telefon Numarası <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="phone" value="{{ adres.phone }}" />
                                            </div>

                                            <div class="form-group">
                                                <label>Ülke <span class="text-danger">*</span></label>
                                                <select class="form-control" name="country_id" id="country_id">
                                                    {% if country is defined %}
                                                        {% for cntry in country %}
                                                        <option value="{{ cntry.CountryID }}" {% if cntry.CountryID is adres.country_id %}selected{% endif %}>{{ cntry.CountryName }}</option>
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Şehir <span class="text-danger">*</span></label>
                                                <select class="form-control" name="city_id" id="city_id">
                                                    {% if city is defined %}
                                                        {% for cty in city %}
                                                            <option value="{{ cty.CityID }}" {% if cty.CityID is adres.city_id %}selected{% endif %}>{{ cty.CityName }}</option>
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>İlçe <span class="text-danger">*</span></label>
                                                <select class="form-control" name="town_id" id="town_id">
                                                    {% if town is defined %}
                                                        {% for town in town %}
                                                            <option value="{{ town.TownID }}" {% if town.TownID is adres.town_id %}selected{% endif %}>{{ town.TownName }}</option>
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Belde <span class="text-danger">*</span></label>
                                                <select class="form-control" name="district_id" id="district_id">
                                                    {% if district is defined %}
                                                        {% for district in district %}
                                                            <option value="{{ district.DistrictID }}" {% if district.DistrictID is adres.dist_id %}selected{% endif %}>{{ district.DistrictName }}</option>
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Mahalle <span class="text-danger">*</span></label>
                                                <select class="form-control" name="neighborhood_id" id="neighborhood_id">
                                                    {% if neighborhood is defined %}
                                                        {% for neighborhood in neighborhood %}
                                                            <option value="{{ neighborhood.NeighborhoodID }}" {% if neighborhood.NeighborhoodID is adres.nei_id %}selected{% endif %}>{{ neighborhood.NeighborhoodName }}</option>
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Posta Kodu <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="zip_code" id="zip_code" value="{{ adres.zip_code }}" />
                                            </div>

                                            <div class="form-group mb-1">
                                                <label for="exampleTextarea">Adres <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="address" rows="2">{{ adres.address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Vazgeç</button>
                                            <button type="submit" class="btn btn-primary font-weight-bold postAdres" data-id="{{ adres.id }}">Değişiklikleri Kaydet</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {% endfor %}
                    {% endif %}
                </div>
            </div>
            <!--end::Content-->

        </div>
        <!--end::Profile Change Password-->
    </div>
    <!--end::Content-->
</div>

<script>
    $(document).ready(function () {
        $('#country_id').on('change', function () {
            const id = $(this).val();
            $.ajax({
                type: 'post',
                url: 'backend/user/country',
                data: 'id='+id,
                success: function (respond) {
                    $('#city_id').html(respond);
                }
            });
        });

        /* il getir */
        $('#city_id').on('change', function () {
            const id = $(this).val();
            $.ajax({
                type: 'post',
                url: 'backend/user/city',
                data: 'id='+id,
                success: function (respond) {
                    $('#town_id').html(respond);
                }
            });
        });

        /* ilce getir */
        $('#town_id').on('change', function () {
            const id = $(this).val();
            $.ajax({
                type: 'post',
                url: 'backend/user/town',
                data: 'id='+id,
                success: function (respond) {
                    $('#district_id').html(respond);
                }
            });
        });

        /* mahalle getir */
        $('#district_id').on('change', function () {
            const id = $(this).val();
            $.ajax({
                type: 'post',
                url: 'backend/user/district',
                data: 'id='+id,
                success: function (respond) {

                    $('#neighborhood_id').html(respond);
                }
            });
        });

        /* zip getir */
        $('#neighborhood_id').on('change', function () {
            const id = $(this).val();
            $.ajax({
                type: 'post',
                url: 'backend/user/neighborhood',
                data: 'id='+id,
                success: function (respond) {
                    $('#zip_code').val(respond);
                }
            });
        });



        $('.postAdres').click(function () {
            const id = $(this).data('id');

            /* address tab post */
            $('#addressForm_'+id).validate({
                rules: {
                    name: "required"
                },
                messages: {
                    name: "Lütfen bu alanı doldurunuz!"
                },
                submitHandler: function () {
                    $('.alert').addClass('dn');

                    const data = $('#addressForm_'+id).serialize();
                    $.ajax({
                        type: 'post',
                        url: '{{ url("backend/user/update") }}',
                        data: data,
                        success: function (response) {
                            if (response === 'ok') {
                                $('.alert').addClass('dn');
                                $('.adresModal_'+id).modal('hide');
                                $('body').removeClass('modal-open');
                                $('.modal-backdrop').remove();
                                window.location.reload();

                            } else {
                                $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir hata oluştu!');
                            }
                        }
                    });
                }
            });

        });
    });


</script>