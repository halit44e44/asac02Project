<style>
    .fix-sidebar-image {
        max-width: 250px !important; height: unset !important;
    }
    .seo_url_widget {
        border: unset;
        background: #ebedf3;
        border-radius: 5px 0px 0px 5px !important;
        color: #9da2a7 !important;
    }
    .w100 {
        width: 100% !important;
        min-width: 100% !important;
    }
    .fixbtn {
        background: #f3f6f9 !important;
        border: 1px solid #f3f6f9 !important;
        padding: 11px !important;
        font-size: 13px !important;
        color: #8a8a8a !important;
    }

    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: #e5e7ec;
    }

    .ck-toolbar {
        background: #f3f6f9 !important;
        border: 1px solid #f3f6f9 !important;
    }

    .bg-light {
        background-color: #f3f6f9 !important;
    }

    .fixpreviewimage {
        position: absolute;
        right: 55px;
        top: 55px;
    }

    .catArea {background: #d1e8ff; padding: 10px;margin-bottom: 15px;}

    .scrollside {

        width: 330px;
        height: 770px;
        overflow-y: auto;
    }

    .scrollside::-webkit-scrollbar {
        width: 5px;
    }

    .scrollside::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .scrollside::-webkit-scrollbar-thumb {
        background: #a6d2ff;
    }

    .scrollside::-webkit-scrollbar-thumb:hover {
        background: #73b9ff;
    }

    .padding-right-none {
        padding-right: 0!important;
    }

    .fixVaryantImage {
        width: 50px !important;
        height: 50px !important;
        border: unset !important;
        box-shadow: unset !important;
    }

    @media screen and (max-width:768px) {
        .padding-none-m {
            padding: 0!important
        }
    }
</style>
<input type="hidden" id="users" value="{{ user.group_id }}">
<form id="proForm" autocomplete="off">
    <div class="d-flex flex-row" data-sticky-container>
        <!--begin::Aside-->
        <div class="flex-column offcanvas-mobile w-300px w-xl-325px sticky" data-sticky="true" data-margin-top="140px" data-sticky-for="1023" data-sticky-class="kt-sticky" id="kt_profile_aside">
            <!--begin::Forms Widget 13-->
            <div class="card card-custom gutter-b">

                <div class="card-body pt-4">

                    <div class="d-flex justify-content-between pt-5">
                        <div class="w100 flex-shrink-0 bg-light p-5 product-preview">
                            <div id="previewImage">
                                <!--<img class="fix-sidebar-image w100" src="{{ url('media/product/resimyok.jpg') }}" />-->
                            </div>
                            <div class="mt-5">
                                <h4 class="font-size-h5">
                                    <a href="javascript:;" class="text-dark-75 font-weight-bold text-hover-primary" id="preview_name"></a>
                                </h4>
                                <div class="text-muted" id="preview_price"><span class="text-dark-75 font-weight-bolder">Satış Fiyatı: </span> <span class="price"></span><span class="currency"></span></div>
                                <div class="text-muted" id="preview_vat"><span class="text-dark-75 font-weight-bolder">KDV:</span> <span class="vat">Dahil / 18%</span></div>
                                <div class="text-muted" id="preview_discount"><span class="text-dark-75 font-weight-bolder">İndirim:</span> <span class="discount"></span></div>
                                <div class="text-muted" id="preview_transfer_discount"><span class="text-dark-75 font-weight-bolder">Havale indirimi:</span> <span class="discount"></span></div>
                                <div class="text-muted" id="preview_shipping_fee"><span class="text-dark-75 font-weight-bolder">Kargo ücreti:</span> <span class="fee"></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">

                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">İlişkili Ürün</label>
                            <select class="form-control form-control-solid form-control-lg picker" data-live-search="true" multiple="multiple" name="top_id[]">
                                {% if products is defined %}
                                    {% for pro in products %}
                                        <option value="{{ pro.id }}">{{ pro.name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="catArea">
                            <div class="form-group mb-3">
                                <label class="font-weight-bolder">Kategori</label>
                                <input class="form-control form-control-solid form-control-lg pl-4" type="text" id="catPicker" placeholder="Kategori seç" autocomplete="off"/>
                                <input type="text" id="cat_id" name="cat_id" hidden>
                            </div>
                            <label id="cat_error" class="error dn">Bu alan zorunludur!</label>
                        </div>

                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">Marka</label>
                            <select class="form-control form-control-solid form-control-lg" name="brand_id">
                                <option>Seçim yapınız</option>
                                {% if brands is defined %}
                                    {% for brand in brands %}
                                        <option value="{{ brand.id }}">{{ brand.name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">Tedarikçi</label>
                            <select class="form-control form-control-solid form-control-lg" name="supplier_id">
                                <option>Seçim yapınız</option>
                                {% if supplierList is defined %}
                                    {% for supplier in supplierList %}
                                        <option value="{{ supplier.id }}">{{ supplier.name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">Ürün Özellikleri</label>
                            <select class="form-control form-control-solid form-control-lg picker" data-live-search="true" multiple="multiple" name="feature_id[]">
                                {% if features is defined %}
                                    {% for feature in features %}
                                        <optgroup label="{{ feature.name }}">
                                            <?php $sub = \Yabasi\Feature::find('top_id='.$feature->id);
                                            if ($sub) {
                                            foreach ($sub as $sub) {
                                            ?>
                                            <option value="{{ sub.id }}">{{ sub.name }}</option>
                                            <?php }} ?>
                                        </optgroup>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">Varyantlar</label>
                            <div class="input-group">
                                <select class="form-control form-control-solid form-control-lg picker variant_id" data-live-search="true" multiple="multiple" name="variant_id[]">
                                    {% if variant is defined %}
                                        {% for variant in variant %}
                                            <optgroup label="{{ variant.name }}" data-id="{{ variant.id}} ">
                                                <?php $subvars = \Yabasi\Variant::find('top_id='.$variant->id);
                                                if ($subvars) {
                                                foreach ($subvars as $sub) {
                                                ?>
                                                <option value="{{ sub.id }}" data-id="{{ sub.name }}" data-top_id="{{ sub.top_id }}">{{ sub.name }}</option>
                                                <?php }} ?>
                                            </optgroup>
                                        {% endfor %}
                                    {% endif %}
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">Hediye Ürünler</label>
                            <select class="form-control form-control-solid form-control-lg picker" data-live-search="true" multiple="multiple" name="gift_id[]">
                                {% if products is defined %}
                                    {% for pro in products %}
                                        <option value="{{ pro.id }}">{{ pro.name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>

                        <div class="form-group mb-8">
                            <label class="font-weight-bolder">Tavsiye Ürünler</label>
                            <select class="form-control form-control-solid form-control-lg picker" data-live-search="true" multiple="multiple" name="recommended_products[]">
                                {% if products is defined %}
                                    {% for pro in products %}
                                        <option value="{{ pro.id }}">{{ pro.name }}</option>
                                    {% endfor %}
                                {% endif %}
                            </select>
                        </div>
                        <button type="submit" id="submitBtn" class="btn btn-primary font-weight-bolder mr-2 mb-10 px-8 col-md-12">Kaydet</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="flex-row-fluid ml-lg-8">
            <div class="card mb-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Ürün Bilgileri</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xxl-12 col-lg-12">

                            <div class="card card-custom card-shadowless">
                                <div class="card-body p-0">

                                    <div class="form-group">
                                        <label for="name">
                                                    <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M3,19 L5,19 L5,21 L3,21 L3,19 Z M8,19 L10,19 L10,21 L8,21 L8,19 Z M13,19 L15,19 L15,21 L13,21 L13,19 Z M18,19 L20,19 L20,21 L18,21 L18,19 Z" fill="#000000" opacity="0.3"/>
                                                                <path d="M10.504,3.256 L12.466,3.256 L17.956,16 L15.364,16 L14.176,13.084 L8.65000004,13.084 L7.49800004,16 L4.96000004,16 L10.504,3.256 Z M13.384,11.14 L11.422,5.956 L9.42400004,11.14 L13.384,11.14 Z" fill="#000000"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                            Ürün İsmi</label>
                                        <input type="text" class="form-control form-control-solid" id="name" name="name">
                                    </div>

                                    <div class="form-group">
                                        <label for="stock_code">
                                                    <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                                <path d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z" fill="#000000" opacity="0.3"/>
                                                                <path d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 18.661508) rotate(-90.000000) translate(-11.959697, -18.661508) "/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                            Stok Kodu</label>
                                        <input type="text" class="form-control form-control-solid" id="stock_code" name="stock_code">
                                    </div>

                                    <div class="form-group">
                                        <label for="barcode_code">
                                                    <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M13,5 L15,5 L15,20 L13,20 L13,5 Z M5,5 L5,20 L3,20 C2.44771525,20 2,19.5522847 2,19 L2,6 C2,5.44771525 2.44771525,5 3,5 L5,5 Z M16,5 L18,5 L18,20 L16,20 L16,5 Z M20,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,19 C22,19.5522847 21.5522847,20 21,20 L20,20 L20,5 Z" fill="#000000"/>
                                                                <polygon fill="#000000" opacity="0.3" points="9 5 9 20 7 20 7 5"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                            Barkod kodu</label>
                                        <input type="text" class="form-control form-control-solid" id="barcode_code" name="barcode_code">
                                    </div>

                                    <div class="form-group">
                                        <label for="warranty_period">
                                                    <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                                                <polygon fill="#000000" opacity="0.3" points="11.3333333 18 16 11.4 13.6666667 11.4 13.6666667 7 9 13.6 11.3333333 13.6"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                            Garanti Süresi (Ay)</label>
                                        <input type="number" min="0" max="50" class="form-control form-control-solid" id="warranty_period" name="warranty_period" value="0">
                                    </div>

                                    <div class="form-group">
                                        <label for="stock_quantity">
                                                <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M4,9.67471899 L10.880262,13.6470401 C10.9543486,13.689814 11.0320333,13.7207107 11.1111111,13.740321 L11.1111111,21.4444444 L4.49070127,17.526473 C4.18655139,17.3464765 4,17.0193034 4,16.6658832 L4,9.67471899 Z M20,9.56911707 L20,16.6658832 C20,17.0193034 19.8134486,17.3464765 19.5092987,17.526473 L12.8888889,21.4444444 L12.8888889,13.6728275 C12.9050191,13.6647696 12.9210067,13.6561758 12.9368301,13.6470401 L20,9.56911707 Z" fill="#000000"/>
                                                        <path d="M4.21611835,7.74669402 C4.30015839,7.64056877 4.40623188,7.55087574 4.5299008,7.48500698 L11.5299008,3.75665466 C11.8237589,3.60013944 12.1762411,3.60013944 12.4700992,3.75665466 L19.4700992,7.48500698 C19.5654307,7.53578262 19.6503066,7.60071528 19.7226939,7.67641889 L12.0479413,12.1074394 C11.9974761,12.1365754 11.9509488,12.1699127 11.9085461,12.2067543 C11.8661433,12.1699127 11.819616,12.1365754 11.7691509,12.1074394 L4.21611835,7.74669402 Z" fill="#000000" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            Stok Bilgileri</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control form-control-solid" id="stock_quantity" name="stock_quantity">
                                            <div class="input-group-append">
                                                <select class="form-control form-control-solid" id="stock_type" name="stock_type">
                                                    <option value="1">Adet</option>
                                                    <option value="2">Cm</option>
                                                    <option value="3">Düzine</option>
                                                    <option value="4">Gram</option>
                                                    <option value="5">Kg</option>
                                                    <option value="6">Kişi</option>
                                                    <option value="7">Paket</option>
                                                    <option value="8">Metre</option>
                                                    <option value="9">M2</option>
                                                    <option value="10">Çift</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="stock_quantity_error"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cargo_weight">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                            <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path d="M8.34232922,9 L15.6576708,9 C17.0342737,9 18.234223,9.93689212 18.5680983,11.2723931 L21,21 L3,21 L5.43190172,11.2723931 C5.76577697,9.93689212 6.96572629,9 8.34232922,9 Z M11.264,18 L12.608,18 L12.608,12.336 L11.376,12.336 L9.512,13.704 L10.208,14.656 L11.264,13.84 L11.264,18 Z" fill="#000000"/>
                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="5.5" r="2.5"/>
                                                </g>
                                            </svg>
                                        </span>
                                            Kargo Ağırlığı</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control form-control-solid" id="cargo_weight" name="cargo_weight">
                                            <div class="input-group-append">
                                                <span class="input-group-text">kg/desi</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-10">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Fiyat Ayarları</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xxl-12 col-lg-12">
                            <div class="card card-custom card-shadowless">
                                <div class="card-body p-0">


                                    <div class="form-group">
                                        <label for="purchase_price">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <g transform="translate(12.500000, 12.000000) rotate(-315.000000) translate(-12.500000, -12.000000) translate(6.000000, 1.000000)" fill="#000000" opacity="0.3">
                                                            <path d="M0.353553391,7.14644661 L3.35355339,7.14644661 C3.4100716,7.14644661 3.46549471,7.14175791 3.51945496,7.13274826 C3.92739876,8.3050906 5.04222146,9.14644661 6.35355339,9.14644661 C8.01040764,9.14644661 9.35355339,7.80330086 9.35355339,6.14644661 C9.35355339,4.48959236 8.01040764,3.14644661 6.35355339,3.14644661 C5.04222146,3.14644661 3.92739876,3.98780262 3.51945496,5.16014496 C3.46549471,5.15113531 3.4100716,5.14644661 3.35355339,5.14644661 L0.436511831,5.14644661 C0.912589923,2.30873327 3.3805571,0.146446609 6.35355339,0.146446609 C9.66726189,0.146446609 12.3535534,2.83273811 12.3535534,6.14644661 L12.3535534,19.1464466 C12.3535534,20.2510161 11.4581229,21.1464466 10.3535534,21.1464466 L2.35355339,21.1464466 C1.24898389,21.1464466 0.353553391,20.2510161 0.353553391,19.1464466 L0.353553391,7.14644661 Z" transform="translate(6.353553, 10.646447) rotate(-360.000000) translate(-6.353553, -10.646447) "/>
                                                            <rect x="2.35355339" y="13.1464466" width="8" height="2" rx="1"/>
                                                            <rect x="3.35355339" y="17.1464466" width="6" height="2" rx="1"/>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                            Alış Fiyatı</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-solid" id="purchase_price" name="purchase_price">
                                            <div class="input-group-append">
                                                <select class="form-control form-control-solid" id="purchase_price_exchange_rate" name="purchase_price_exchange_rate">
                                                    {% if currency_list is defined %}
                                                        {% for currency in currency_list %}
                                                            {% if loop.first %}
                                                                <option value="{{ loop.index }}" selected>{{ currency }}</option>
                                                            {% else %}
                                                                <option value="{{ loop.index }}">{{ currency }}</option>
                                                            {% endif %}
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>
                                        </div>
                                        <div id="purchase_price_label"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="market_price">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <g transform="translate(12.500000, 12.000000) rotate(-315.000000) translate(-12.500000, -12.000000) translate(6.000000, 1.000000)" fill="#000000" opacity="0.3">
                                                            <path d="M0.353553391,7.14644661 L3.35355339,7.14644661 C3.4100716,7.14644661 3.46549471,7.14175791 3.51945496,7.13274826 C3.92739876,8.3050906 5.04222146,9.14644661 6.35355339,9.14644661 C8.01040764,9.14644661 9.35355339,7.80330086 9.35355339,6.14644661 C9.35355339,4.48959236 8.01040764,3.14644661 6.35355339,3.14644661 C5.04222146,3.14644661 3.92739876,3.98780262 3.51945496,5.16014496 C3.46549471,5.15113531 3.4100716,5.14644661 3.35355339,5.14644661 L0.436511831,5.14644661 C0.912589923,2.30873327 3.3805571,0.146446609 6.35355339,0.146446609 C9.66726189,0.146446609 12.3535534,2.83273811 12.3535534,6.14644661 L12.3535534,19.1464466 C12.3535534,20.2510161 11.4581229,21.1464466 10.3535534,21.1464466 L2.35355339,21.1464466 C1.24898389,21.1464466 0.353553391,20.2510161 0.353553391,19.1464466 L0.353553391,7.14644661 Z" transform="translate(6.353553, 10.646447) rotate(-360.000000) translate(-6.353553, -10.646447) "/>
                                                            <rect x="2.35355339" y="13.1464466" width="8" height="2" rx="1"/>
                                                            <rect x="3.35355339" y="17.1464466" width="6" height="2" rx="1"/>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                            Piyasa Fiyatı</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-solid" id="market_price" name="market_price">
                                            <div class="input-group-append">
                                                <select class="form-control form-control-solid" id="market_price_exchange_rate" name="market_price_exchange_rate">
                                                    {% if currency_list is defined %}
                                                        {% for currency in currency_list %}
                                                            {% if loop.first %}
                                                                <option value="{{ loop.index }}" selected>{{ currency }}</option>
                                                            {% else %}
                                                                <option value="{{ loop.index }}">{{ currency }}</option>
                                                            {% endif %}
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sale_price">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <g transform="translate(12.500000, 12.000000) rotate(-315.000000) translate(-12.500000, -12.000000) translate(6.000000, 1.000000)" fill="#000000" opacity="0.3">
                                                            <path d="M0.353553391,7.14644661 L3.35355339,7.14644661 C3.4100716,7.14644661 3.46549471,7.14175791 3.51945496,7.13274826 C3.92739876,8.3050906 5.04222146,9.14644661 6.35355339,9.14644661 C8.01040764,9.14644661 9.35355339,7.80330086 9.35355339,6.14644661 C9.35355339,4.48959236 8.01040764,3.14644661 6.35355339,3.14644661 C5.04222146,3.14644661 3.92739876,3.98780262 3.51945496,5.16014496 C3.46549471,5.15113531 3.4100716,5.14644661 3.35355339,5.14644661 L0.436511831,5.14644661 C0.912589923,2.30873327 3.3805571,0.146446609 6.35355339,0.146446609 C9.66726189,0.146446609 12.3535534,2.83273811 12.3535534,6.14644661 L12.3535534,19.1464466 C12.3535534,20.2510161 11.4581229,21.1464466 10.3535534,21.1464466 L2.35355339,21.1464466 C1.24898389,21.1464466 0.353553391,20.2510161 0.353553391,19.1464466 L0.353553391,7.14644661 Z" transform="translate(6.353553, 10.646447) rotate(-360.000000) translate(-6.353553, -10.646447) "/>
                                                            <rect x="2.35355339" y="13.1464466" width="8" height="2" rx="1"/>
                                                            <rect x="3.35355339" y="17.1464466" width="6" height="2" rx="1"/>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </span>
                                            Satış Fiyatı</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-solid" id="sale_price" name="sale_price">
                                            <div class="input-group-append">
                                                <select class="form-control form-control-solid" id="sale_price_exchange_rate" name="sale_price_exchange_rate">
                                                    {% if currency_list is defined %}
                                                        {% for currency in currency_list %}
                                                            {% if loop.first %}
                                                                <option value="{{ loop.index }}" selected>{{ currency }}</option>
                                                            {% else %}
                                                                <option value="{{ loop.index }}">{{ currency }}</option>
                                                            {% endif %}
                                                        {% endfor %}
                                                    {% endif %}
                                                </select>
                                            </div>
                                        </div>
                                        <div id="sale_price_label"></div>
                                    </div>

                                    <div class="separator separator-dashed separator-border-1 mb-10 mt-10"></div>

                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label for="vat_definition">KDV Tanımı</label>
                                            <select class="form-control form-control-solid" id="vat_definition" name="vat_definition">
                                                <option value="included">KDV Dahil</option>
                                                <option value="notincluded">KDV Hariç</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="vat_rate">KDV Oranı</label>
                                            <input type="number" value="18" min="0" max="100" class="form-control form-control-solid" id="vat_rate" name="vat_rate">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="shipping_fee">Kargo Ücreti</label>
                                            <input type="text" class="form-control form-control-solid" id="shipping_fee" name="shipping_fee">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label for="discount_type">İndirim Tipi</label>
                                            <select class="form-control form-control-solid" id="discount_type" name="discount_type">
                                                <option value="">Seçim yapınız</option>
                                                <option value="price">Fiyat</option>
                                                <option value="percentage">Yüzdesel</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="discount_rate">İndirim Oranı</label>
                                            <input type="number" class="form-control form-control-solid" min="0" id="discount_rate" name="discount_rate" disabled="true">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="transfer_discount">Havale İndirimi</label>
                                            <input type="number" class="form-control form-control-solid" min="0" id="transfer_discount" name="transfer_discount">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mb-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">İçerik Ayarları</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xxl-12 col-lg-12">

                            <div class="card card-custom card-shadowless">
                                <div class="card-body p-0">

                                    <div class="form-group">
                                        <label for="short_content">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1"/>
                                                        <rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1"/>
                                                        <path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            Kısa Açıklama</label>
                                        <textarea class="form-control form-control-solid" rows="4" name="short_content" id="short_content" maxlength="300"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="barcode_code">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <rect fill="#000000" opacity="0.3" x="4" y="5" width="16" height="2" rx="1"/>
                                                        <rect fill="#000000" opacity="0.3" x="4" y="13" width="16" height="2" rx="1"/>
                                                        <path d="M5,9 L13,9 C13.5522847,9 14,9.44771525 14,10 C14,10.5522847 13.5522847,11 13,11 L5,11 C4.44771525,11 4,10.5522847 4,10 C4,9.44771525 4.44771525,9 5,9 Z M5,17 L13,17 C13.5522847,17 14,17.4477153 14,18 C14,18.5522847 13.5522847,19 13,19 L5,19 C4.44771525,19 4,18.5522847 4,18 C4,17.4477153 4.44771525,17 5,17 Z" fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            Ürün Açıklaması</label>
                                        <textarea name="content" id="content"></textarea>
                                        <label id="content_error" class="error dn" for="content">Bu alan zorunludur!</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">SEO Ayarları</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xxl-12 col-lg-12">
                            <!--begin::Card-->
                            <div class="card card-custom card-shadowless">
                                <div class="card-body p-0">

                                    <div class="seo_preview dn">
                                        <div class="seo_preview_title">ARAMA GÖRÜNÜMÜ</div>
                                        <h1 class="slugTitle"></h1>
                                        <span>{{ site_url }}/</span><span><strong class="slugText"></strong></span>
                                        <p class="slugDesc w100"></p>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">
                                            <span class="svg-icon svg-icon-primary svg-icon-lg">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M1,12 L1,14 L6,14 L6,12 L1,12 Z M0,10 L20,10 C20.5522847,10 21,10.4477153 21,11 L21,15 C21,15.5522847 20.5522847,16 20,16 L0,16 C-0.55228475,16 -1,15.5522847 -1,15 L-1,11 C-1,10.4477153 -0.55228475,10 0,10 Z" fill="#000000" fill-rule="nonzero" transform="translate(10.000000, 13.000000) rotate(-225.000000) translate(-10.000000, -13.000000) "/>
                                                        <path d="M17.5,12 L18.5,12 C18.7761424,12 19,12.2238576 19,12.5 L19,13.5 C19,13.7761424 18.7761424,14 18.5,14 L17.5,14 C17.2238576,14 17,13.7761424 17,13.5 L17,12.5 C17,12.2238576 17.2238576,12 17.5,12 Z M20.5,9 L21.5,9 C21.7761424,9 22,9.22385763 22,9.5 L22,10.5 C22,10.7761424 21.7761424,11 21.5,11 L20.5,11 C20.2238576,11 20,10.7761424 20,10.5 L20,9.5 C20,9.22385763 20.2238576,9 20.5,9 Z M21.5,13 L22.5,13 C22.7761424,13 23,13.2238576 23,13.5 L23,14.5 C23,14.7761424 22.7761424,15 22.5,15 L21.5,15 C21.2238576,15 21,14.7761424 21,14.5 L21,13.5 C21,13.2238576 21.2238576,13 21.5,13 Z" fill="#000000" opacity="0.3"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            Seo Başlığı</label>
                                        <input name="seo_title" id="seotitle" type="text" class="form-control form-control-solid" />
                                    </div>

                                    <div class="form-group">
                                        <label for="name">
                                        <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M6,7 C7.1045695,7 8,6.1045695 8,5 C8,3.8954305 7.1045695,3 6,3 C4.8954305,3 4,3.8954305 4,5 C4,6.1045695 4.8954305,7 6,7 Z M6,9 C3.790861,9 2,7.209139 2,5 C2,2.790861 3.790861,1 6,1 C8.209139,1 10,2.790861 10,5 C10,7.209139 8.209139,9 6,9 Z" fill="#000000" fill-rule="nonzero"/>
                                                        <path d="M7,11.4648712 L7,17 C7,18.1045695 7.8954305,19 9,19 L15,19 L15,21 L9,21 C6.790861,21 5,19.209139 5,17 L5,8 L5,7 L7,7 L7,8 C7,9.1045695 7.8954305,10 9,10 L15,10 L15,12 L9,12 C8.27142571,12 7.58834673,11.8052114 7,11.4648712 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path d="M18,22 C19.1045695,22 20,21.1045695 20,20 C20,18.8954305 19.1045695,18 18,18 C16.8954305,18 16,18.8954305 16,20 C16,21.1045695 16.8954305,22 18,22 Z M18,24 C15.790861,24 14,22.209139 14,20 C14,17.790861 15.790861,16 18,16 C20.209139,16 22,17.790861 22,20 C22,22.209139 20.209139,24 18,24 Z" fill="#000000" fill-rule="nonzero"/>
                                                        <path d="M18,13 C19.1045695,13 20,12.1045695 20,11 C20,9.8954305 19.1045695,9 18,9 C16.8954305,9 16,9.8954305 16,11 C16,12.1045695 16.8954305,13 18,13 Z M18,15 C15.790861,15 14,13.209139 14,11 C14,8.790861 15.790861,7 18,7 C20.209139,7 22,8.790861 22,11 C22,13.209139 20.209139,15 18,15 Z" fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                </svg>
                                            </span>
                                            Ürün URL'si</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text seo_url_widget">{{ site_url }}/</span>
                                            </div>
                                            <input name="slugurl" type="text" class="form-control form-control-solid slugurl" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="name">
                                        <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                            <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M3.52270623,14.028695 C2.82576459,13.3275941 2.82576459,12.19529 3.52270623,11.4941891 L11.6127629,3.54050571 C11.9489429,3.20999263 12.401513,3.0247814 12.8729533,3.0247814 L19.3274172,3.0247814 C20.3201611,3.0247814 21.124939,3.82955935 21.124939,4.82230326 L21.124939,11.2583059 C21.124939,11.7406659 20.9310733,12.2027862 20.5869271,12.5407722 L12.5103155,20.4728108 C12.1731575,20.8103442 11.7156477,21 11.2385688,21 C10.7614899,21 10.3039801,20.8103442 9.9668221,20.4728108 L3.52270623,14.028695 Z M16.9307214,9.01652093 C17.9234653,9.01652093 18.7282432,8.21174298 18.7282432,7.21899907 C18.7282432,6.22625516 17.9234653,5.42147721 16.9307214,5.42147721 C15.9379775,5.42147721 15.1331995,6.22625516 15.1331995,7.21899907 C15.1331995,8.21174298 15.9379775,9.01652093 16.9307214,9.01652093 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                            Anahtar Kelime</label>
                                        <input name="keyword" id="etiket" class="form-control form-control-solid tagify" value=""  />
                                    </div>

                                    <div class="form-group">
                                        <label for="name">
                                        <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                            <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5"/>
                                                    <path d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L12.5,10 C13.3284271,10 14,10.6715729 14,11.5 C14,12.3284271 13.3284271,13 12.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z" fill="#000000" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                            Site Açıklama</label>
                                        <textarea type="text" rows="2" class="form-control form-control-solid" id="description" maxlength="150" name="description"></textarea>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Etiket Ayarları</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xxl-12 col-lg-12">
                            <!--begin::Card-->
                            <div class="card card-custom card-shadowless">
                                <div class="card-body p-0">

                                    <div class="form-group">
                                        <label for="name">
                                        <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                            <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M3.52270623,14.028695 C2.82576459,13.3275941 2.82576459,12.19529 3.52270623,11.4941891 L11.6127629,3.54050571 C11.9489429,3.20999263 12.401513,3.0247814 12.8729533,3.0247814 L19.3274172,3.0247814 C20.3201611,3.0247814 21.124939,3.82955935 21.124939,4.82230326 L21.124939,11.2583059 C21.124939,11.7406659 20.9310733,12.2027862 20.5869271,12.5407722 L12.5103155,20.4728108 C12.1731575,20.8103442 11.7156477,21 11.2385688,21 C10.7614899,21 10.3039801,20.8103442 9.9668221,20.4728108 L3.52270623,14.028695 Z M16.9307214,9.01652093 C17.9234653,9.01652093 18.7282432,8.21174298 18.7282432,7.21899907 C18.7282432,6.22625516 17.9234653,5.42147721 16.9307214,5.42147721 C15.9379775,5.42147721 15.1331995,6.22625516 15.1331995,7.21899907 C15.1331995,8.21174298 15.9379775,9.01652093 16.9307214,9.01652093 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                            Yardımcı Arama Kelimeleri</label>
                                        <input name="search_keywords" id="search_keywords" class="form-control form-control-solid tagify" value=""  />
                                    </div>

                                    <div class="form-group">
                                        <label for="name">
                                        <span class="svg-icon svg-icon-primary svg-icon-lg pr-2">
                                            <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M3.52270623,14.028695 C2.82576459,13.3275941 2.82576459,12.19529 3.52270623,11.4941891 L11.6127629,3.54050571 C11.9489429,3.20999263 12.401513,3.0247814 12.8729533,3.0247814 L19.3274172,3.0247814 C20.3201611,3.0247814 21.124939,3.82955935 21.124939,4.82230326 L21.124939,11.2583059 C21.124939,11.7406659 20.9310733,12.2027862 20.5869271,12.5407722 L12.5103155,20.4728108 C12.1731575,20.8103442 11.7156477,21 11.2385688,21 C10.7614899,21 10.3039801,20.8103442 9.9668221,20.4728108 L3.52270623,14.028695 Z M16.9307214,9.01652093 C17.9234653,9.01652093 18.7282432,8.21174298 18.7282432,7.21899907 C18.7282432,6.22625516 17.9234653,5.42147721 16.9307214,5.42147721 C15.9379775,5.42147721 15.1331995,6.22625516 15.1331995,7.21899907 C15.1331995,8.21174298 15.9379775,9.01652093 16.9307214,9.01652093 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                </g>
                                            </svg>
                                        </span>
                                            Sayfa Etiketleri</label>
                                        <input name="page_keywords" id="page_keywords" class="form-control form-control-solid tagify" value=""  />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<!-- variant alanı -->
<div class="d-flex flex-column-fluid dn" id="variant_options">
    <div class="container padding-right-none">
        <div class="col-lg-9 col-sm-12 float-right padding-none-m padding-right-none">
            <div class="mb-10 dns">
                <div class="card mb-10 dns">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-7">
                            <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Varyant Stok Yapılandırma</h6>
                        </div>

                        <form id="variantOptionsForm">
                            <input type="hidden" name="id" value="1" class="lastid" />
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th class="text-left" scope="col">Varyant Adı</th>
                                    <th class="text-center" scope="col">Stok</th>
                                    <th class="text-center" scope="col">Ağırlık</th>
                                    <th class="text-center" scope="col">Alış Fiyatı</th>
                                    <th class="text-center" scope="col">Satış Fiyatı</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="form-group text-right">
                                <button type="button" id="saveVariantOptions" class="btn btn-primary btn-sm">Stok bilgilerini kaydet</button>
                            </div>
                        </form>

                        <div class="alert alert-secondary dn" id="variantSuccess" role="alert"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-column-fluid photoUploadCpnteiner dn">
    <div class="container padding-right-none">
        <div class="col-lg-9 col-sm-12 float-right padding-none-m padding-right-none">

            <div class="card mb-10 dns">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-7">
                        <h6 class="font-weight-bolder text-dark font-size-h6 mb-0">Fotoğraf Ayarları</h6>
                    </div>

                    <form class="dropzone dropzone-default dropzone-primary photoupload">
                        <input type="hidden" class="lastid" name="id" value="" />
                        <input type="hidden" class="table" name="table" value="product" />
                        <div class="dropzone-msg dz-message needsclick">
                            <h3 class="dropzone-msg-title">Fotoğrafları buraya sürükle veya tıklayarak yükle.</h3>
                            <span class="dropzone-msg-desc">Aynı anda 10 fotoğraf yükleyebilirsiniz.</span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container padding-right-none">
        <div class="col-lg-9 col-sm-12 float-right padding-none-m padding-right-none">
            <div class="mb-10 dns">
                <div id="uploadedphotos"></div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        ClassicEditor
            .create( document.querySelector( '#content' ), {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo'
                    ]
                },
                table: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                language: 'tr',


            } )
            .catch( error => {
                console.log( error );
            } );

        showPreview();
        setScrollPosition();
        onChangeSelect();
        saveVariantOptions();

        $(".variant_sprice, .variant_pprice").inputmask('999999.99', {
            numericInput: true
        });

        var avatar1 = new KTImageInput('varyantImage');

        $(".varyant_image").change(function() {
            readURL(this);
        });

        $('.btn-light').addClass('fixbtn');

        $("#purchase_price, #market_price, #sale_price, #shipping_fee").inputmask('999999.99', {
            numericInput: true
        });

        new Tagify(document.getElementById('search_keywords'));
        new Tagify(document.getElementById('page_keywords'));

        const sticky = new Sticky('.sticky');

        $('.picker').selectpicker({
            style: 'fixbtn',
            noneSelectedText: 'Seçim yapınız'
        });

        const categoryPicker = $('#catPicker').comboTree({
            source : {{ catList }},
            isMultiple: true,
            cascadeSelect: true,
            collapse: false,
            required: true,
            selected: ['0']
        });


        if ($('form.photoupload').length) {
            const photoUpload = new Dropzone('form.photoupload', {
                url: "{{ url('backend/upload/set') }}",
                uploadMultiple: true,
                autoProcessQueue: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                maxFiles: 10,
                maxFilesize: 5000,
                thumbnailWidth: 222,
                thumbnailHeight: 222,
                accept: function (file, done) {
                    if (file.size > 5242880) {
                        done('Dosya boyutu çok yüksek!');
                    } else {
                        if (file.status === 'error') {
                            done('Görsel yüklenemedi!');
                        } else {
                            done();
                        }
                    }
                },
                thumbnail: function(file, dataUrl) {
                    $(".fix-sidebar-image").attr("src",dataUrl);
                    if($(".fix-sidebar-image").attr("src") == "/media/product/resimyok.jpg"){
                        $(".fix-sidebar-image").attr("src",dataUrl);
                    }
                },
                success: function (file, response) {
                    $('#uploadedphotos').html(response);
                    changePreviewImage();
                    prepeareCheckbox();
                }
            });
        }

        $('#proForm').validate({
            rules: {
                name: "required",
                stock_type: "required",
                slugurl: "required",
                vat_definition: "required",
                vat_rate: "required",
                seo_title: "required",
                stock_code: "required",
                barcode_code: "required",
                warranty_period: {
                    required: false,
                    maxlength: 50
                }
            },
            messages: {
                name: "Bu alan zorunludur!",
                warranty_period: "Lütfen garanti süresini 50 ay üzerinde bir değer girmeyiniz!",
                stock_type: "Bu alan zorunludur!",
                vat_definition: "Bu alan zorunludur!",
                vat_rate: "Bu alan zorunludur!",
                seo_title: "Bu alan zorunludur!",
                slugurl: "Bu alan zorunludur!",
                stock_code: "Bu alan zorunludur!",
                barcode_code: "Bu alan zorunludur!"
            },
            invalidHandler: function(e, validator) {

                const errors = validator.numberOfInvalids();

                const stockCode  = $('.stock_quantity_error');
                const stockQuantity  = $('#stock_quantity');
                stockCode.html('');

                if (stockQuantity.val().length <= 0) {
                    stockCode.html('<label class="error" for="stock_quantity">Bu alan zorunludur!</label>');
                } else {
                    stockCode.html('');
                }

                stockCode.keypress(function () {
                    if($(this).val().length > 1) {
                        stockCode.html('');
                    } else {
                        stockCode.html('<label class="error" for="stock_quantity">Bu alan zorunludur!</label>');
                    }
                });


                const purchasePrice = $('#purchase_price');
                const purchasePriceLabel = $('#purchase_price_label');
                purchasePriceLabel.html('');

                // if (purchasePrice.val().length <= 0) {
                //     purchasePriceLabel.html('<label class="error" for="stock_quantity">Bu alan zorunludur!</label>');
                // } else {
                //     purchasePriceLabel.html('');
                // }
                //
                // purchasePrice.keypress(function () {
                //     if($(this).val().length > 1) {
                //         purchasePriceLabel.html('');
                //     } else {
                //         purchasePriceLabel.html('<label class="error" for="stock_quantity">Bu alan zorunludur!</label>');
                //     }
                // });

                const salePrice = $('#sale_price');
                const salePriceLabel = $('#sale_price_label');
                salePriceLabel.html('');

                if (salePrice.val().length <= 0) {
                    salePriceLabel.html('<label class="error" for="stock_quantity">Bu alan zorunludur!</label>');
                } else {
                    salePriceLabel.html('');
                }

                salePrice.keypress(function () {
                    if($(this).val().length > 1) {
                        salePriceLabel.html('');
                    } else {
                        salePriceLabel.html('<label class="error" for="stock_quantity">Bu alan zorunludur!</label>');
                    }
                });

            },
            submitHandler: function (form) {
                $("#cat_id").val(categoryPicker.getSelectedIds());
                const data = $('#proForm').serialize();


                const user=$('#users').val();
                if (user === "3") {

                    //Swal.fire("Hata!", "Ekleme yetkiniz bulunmamaktadır!", "warning");


                    prepeareVariant();

                    $(".variant_sprice, .variant_pprice").inputmask('999999.99', {
                        numericInput: true
                    });

                    //$('html, body').animate({ scrollTop: $(".footer").offset() }, 2000);
                    //$(document).scrollTo(".footer");
                    $(window).scrollTop($('#variant_options').offset().top);

                    return false;
                }else {
                    $('#cat_error').addClass('dn');
                    if (categoryPicker.getSelectedNames()===null){
                        $('#cat_error').removeClass('dn').show().html('Bu alan zorunludur!');
                        $('html, body').animate({ scrollTop: $(".show").offset().top }, 1000);
                        return false;
                    }else {
                        $.ajax({
                            type: 'post',
                            url: '{{ url("backend/product/insert/") }}',
                            data: data,
                            success: function (response) {
                                const obj = jQuery.parseJSON(response);
                                if (obj.status === 'ok') {
                                    $("#submitBtn").prop('disabled', true);
                                    $('.photoUploadCpnteiner').removeClass('dn');
                                    $('.lastid').val(obj.id);

                                    prepeareVariant();

                                    $(".variant_sprice, .variant_pprice").inputmask('999999.99', {
                                        numericInput: true
                                    });

                                    $('html, body').animate({ scrollTop: $(".photoUploadCpnteiner").offset().top }, 2000);
                                } else {
                                    goTop();
                                }
                            }
                        });
                    }

                }

            }
        });

    });

    function saveVariantOptions() {

            $('#saveVariantOptions').click(function () {
                const data = $('#variantOptionsForm').serialize();
                $('#variantSuccess').addClass('dn');
                const user=$('#users').val();
                if (user === "3") {
                    Swal.fire("Hata!", "Ekleme yetkiniz bulunmamaktadır!", "warning");
                    return false;
                }else {
                    $.ajax({
                        type: 'post',
                        url: '{{ url('backend/product/variant') }}',
                        data: data,
                        success: function (response) {
                            if (response === 'ok') {
                                $('#variantSuccess').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('Varyant stok bilgileri başarılı bir şekilde kaydedilmiştir.');
                            } else {
                                $('#variantSuccess').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Lütfen doldurduğunuz bilgileri tekrar kontrol ediniz!');
                            }
                        }
                    });
                }
            });

    }

    function prepeareVariant() {
        var label= $('.variant_id option:selected').parent();
        const options = $('.variant_id option:selected');
        let selected = [];
        const selected2 = [];
        const selected3 = [];
        const selected4 = [];
        let id = [];
        const id2 = [];
        const id3 = [];
        const id4 = [];

        dizi=[];
        let i=0;
        $(label).each(function(){
            dizi.push($(this).data('id'));
        });

        $(options).each(function(){
            top_id=$(this).data('top_id');

            if (dizi.length===1){
                selected.push($(this).val());
                id.push($(this).data('id'));
                variant(selected,id);
            }
            if (dizi.length===2){
                for (a=0;a<dizi.length;a++){
                    if (a===0){
                        if (top_id==dizi[0]){
                            selected.push($(this).val());
                            id.push($(this).data('id'));
                        }
                    }
                    if (a===1){
                        if (top_id==dizi[1]){
                            selected2.push($(this).val());
                            id2.push($(this).data('id'));
                        }
                    }
                }
                variant(selected,id,selected2,id2);
            }
            if (dizi.length===3){
                for (a=0;a<dizi.length;a++){
                    if (a===0){
                        if (top_id==dizi[0]){
                            selected.push($(this).val());
                            id.push($(this).data('id'));
                        }
                    }
                    if (a===1){
                        if (top_id==dizi[1]){
                            selected2.push($(this).val());
                            id2.push($(this).data('id'));
                        }
                    }
                    if (a===2){
                        if (top_id==dizi[2]){
                            selected3.push($(this).val());
                            id3.push($(this).data('id'));
                        }
                    }
                }
                variant(selected,id,selected2,id2,selected3,id3);
            }
            if (dizi.length===4){
                for (a=0;a<dizi.length;a++){
                    if (a===0){
                        if (top_id==dizi[0]){
                            selected.push($(this).val());
                            id.push($(this).data('id'));
                        }
                    }
                    if (a===1){
                        if (top_id==dizi[1]){
                            selected2.push($(this).val());
                            id2.push($(this).data('id'));
                        }
                    }
                    if (a===2){
                        if (top_id==dizi[2]){
                            selected3.push($(this).val());
                            id3.push($(this).data('id'));
                        }
                    }
                    if (a===3){
                        if (top_id==dizi[3]){
                            selected4.push($(this).val());
                            id4.push($(this).data('id'));
                        }
                    }
                }
                variant(selected,id,selected2,id2,selected3,id3,selected4,id4);

            }

        });

    }

    function variant(dizi,id,dizi2,id2,dizi3,id3,dizi4,id4) {

        let returned = '';
        let variantids = '';

        for (i=0;i<dizi.length;i++){
            if (dizi2){
                for(j=0;j<dizi2.length;j++){
                    if (dizi3){
                        for (a=0;a<dizi3.length;a++){
                            if (dizi4){
                                for (b=0;b<dizi4.length;b++){
                                    variantids = dizi[i]+","+dizi2[j]+","+dizi3[a]+","+dizi4[b];
                                    returned += '<tr data-vars="'+variantids+'"><input type="hidden" name="variant_id[]" value="'+dizi[i]+","+dizi2[j]+","+dizi3[a]+","+dizi4[b]+'" /> <input type="hidden" name="name[]" value="'+id[i]+","+id2[j]+","+id3[a]+","+id4[b]+'" /><td width="200" class="pt-6 text-left">'+id[i]+","+id2[j]+","+id3[a]+","+id4[b]+'</td> <td class="text-center"><input type="number" name="stock[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="number" name="weight[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="text" name="purchase_price[]" class="form-control form-control-solid variant_pprice"></td> <td class="text-center"><input type="text" name="sale_price[]" class="form-control form-control-solid variant_sprice"></td> </tr>';
                                }
                            }else {
                                variantids = dizi[i]+","+dizi2[j]+","+dizi3[a];
                                returned += '<tr data-vars="'+variantids+'"><input type="hidden" name="variant_id[]" value="'+dizi[i]+","+dizi2[j]+","+dizi3[a]+'" /> <input type="hidden" name="name[]" value="'+id[i]+","+id2[j]+","+id3[a]+'" /><td width="200" class="pt-6 text-left">'+id[i]+","+id2[j]+","+id3[a]+'</td> <td class="text-center"><input type="number" name="stock[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="number" name="weight[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="text" name="purchase_price[]" class="form-control form-control-solid variant_pprice"></td> <td class="text-center"><input type="text" name="sale_price[]" class="form-control form-control-solid variant_sprice"></td> </tr>';
                            }
                        }
                    }
                    else {
                        variantids = dizi[i]+","+dizi2[j];
                        returned += '<tr data-vars="'+variantids+'"><input type="hidden" name="variant_id[]" value="'+dizi[i]+","+dizi2[j]+'" /> <input type="hidden" name="name[]" value="'+id[i]+","+id2[j]+'" /><td width="200" class="pt-6 text-left">'+id[i]+"-"+id2[j]+'</td> <td class="text-center"><input type="number" name="stock[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="number" name="weight[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="text" name="purchase_price[]" class="form-control form-control-solid variant_pprice"></td> <td class="text-center"><input type="text" name="sale_price[]" class="form-control form-control-solid variant_sprice"></td> </tr>';
                    }
                }
            }else {
                variantids = dizi[i];
                returned += '<tr data-vars="'+variantids+'"><input type="hidden" name="variant_id[]" value="'+dizi[i]+'" /> <input type="hidden" name="name[]" value="'+id[i]+'" /><td width="200" class="pt-6 text-left">'+id[i]+'</td> <td class="text-center"><input type="number" name="stock[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="number" name="weight[]" min="0" value="0" class="form-control form-control-solid"></td> <td class="text-center"><input type="text" name="purchase_price[]" class="form-control form-control-solid variant_pprice"></td> <td class="text-center"><input type="text" name="sale_price[]" class="form-control form-control-solid variant_sprice"></td> </tr>';
            }
        }
        showvariant(returned);
    }

    function showvariant(el) {
        $('#variant_options').removeClass('dn');
        $('#variant_options table tbody').append(el);
        isthere();
    }

    function isthere() {
        const vars = $('tr[data-vars]');
        const found = {};

        vars.each(function(){
            const $this = $(this);
            if(found[$this.data('vars')]){
                $this.remove();
            }  else{
                found[$this.data('vars')] = true;
            }
        });
    }

    function changePreviewImage() {
        $('input[name=showcase]').on('click', function () {
            const image = $(this).data("image");

            if($(".fix-sidebar-image").attr("src") == "/media/product/resimyok.jpg"){
                $(".fix-sidebar-image").attr("src",image);
            }else{
                $(".fix-sidebar-image").attr("src", "/media/product/resimyok.jpg");
            }
        });
    }

    function showPreview() {
        const preview_image = $('#previewImage');
        const product_preview = $('.product-preview');
        const preview_name = $('#preview_name');
        const preview_price = $('#preview_price span.price');
        const preview_currency = $('#preview_price span.currency');
        const sale_price_exchange_rate = $('#sale_price_exchange_rate');
        const preview_vat = $('#preview_vat span.vat');
        const preview_discount = $('#preview_discount span.discount');
        const preview_transfer_discount = $('#preview_transfer_discount span.discount');
        const preview_shipping_fee = $('#preview_shipping_fee span.fee');


        $('#name').on('input', function () {
            const val = $(this).val();
            if (val.length > 0) {
                preview_name.html(val);
            } else {
                preview_name.html('');
            }
        });

        $('#sale_price').on('input', function () {
            const currency = $('#sale_price').val();
            const cur_re = /\D*(\d+|\d.*?\d)(?:\D+(\d{2}))?\D*$/;
            const parts = cur_re.exec(currency);
            const number = parseFloat(parts[1].replace(/\D/, '') + '.' + (parts[2] ? parts[2] : '00'));
            const sale_price = number.toFixed(2);

            if (sale_price.length > 0) {
                preview_price.html(sale_price);
                preview_currency.html(" " + sale_price_exchange_rate.val());
            } else {
                preview_price.html('');
                preview_currency.html('');
            }
        });

        function getVat() {
            var output = "";

            if($("#vat_definition").val() == "included"){
                output += "Dahil ";
            }else{
                output += "Değil ";
            }

            output += "<b>"+$("#vat_rate").val()+""+"%</b>";

            preview_vat.html(output);
        }

        $('#vat_definition').on('change', getVat);
        $('#vat_rate').on('change', getVat);

        function getDiscount() {
            var output = "";
            var discount_type = $("#discount_type").val();
            var discount_rate = $("#discount_rate").val();

            if(discount_rate == ""){
                discount_rate = 0;
            }

            if(discount_type != ""){
                if(discount_type == 'price'){
                    output = discount_rate+" "+$("#sale_price_exchange_rate").val();
                }else if(discount_type == 'percentage'){
                    output = discount_rate+""+'%';
                }
            }

            preview_discount.html(output);
        }

        $('#discount_type').on('change', getDiscount);
        $('#discount_rate').on('change', getDiscount);

        $('#transfer_discount').on('input', function () {
            var output = "";
            var transfer_discount = $(this).val();

            if(transfer_discount != "" || transfer_discount != 0){
                output = transfer_discount+" "+$("#sale_price_exchange_rate").val();
            }

            preview_transfer_discount.html(output);
        });

        $('#shipping_fee').on('input', function () {
            var output = "";
            var shipping_fee = $(this).val();
            var cur_re = /\D*(\d+|\d.*?\d)(?:\D+(\d{2}))?\D*$/;
            var parts = cur_re.exec(shipping_fee);
            var number = parseFloat(parts[1].replace(/\D/, '') + '.' + (parts[2] ? parts[2] : '00'));
            shipping_fee = number.toFixed(2);

            if(shipping_fee != "" || shipping_fee != 0){
                output = shipping_fee+" "+$("#sale_price_exchange_rate").val();
            }

            preview_shipping_fee.html(output);
        });
    }

    function setScrollPosition() {
        $( window ).scroll(function() {
            const html = $(window).scrollTop();
            if (html > 100) {
                $('.scrollside').attr('style', 'margin-top: -90px');
            }

            if (html === 0) {
                $('.scrollside').attr('style', 'margin-top:unset');
            }
        });

    }

    function onChangeSelect() {
        $('#sale_price_exchange_rate').on('change',function () {
            const val = $(this).val();
            $('.currency').html(' ' + val);
        });

        $('#discount_type').on('change', function () {
            const val = $(this).val();
            if (val === "price" || val === 'percentage') {
                $('#discount_rate').prop("disabled", false);
            } else {
                $('#discount_rate').prop("disabled", true);
            }
        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            const id = $(input).data('id');
            const reader = new FileReader();
            reader.onload = function (e) {
                const image = $('#fixVaryantImage_'+id+' img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    prepeareCheckbox();
    function prepeareCheckbox() {
        $("input:checkbox").on('click', function() {
            // in the handler, 'this' refers to the box clicked on
            var $box = $(this);
            if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the group/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    }
</script>
