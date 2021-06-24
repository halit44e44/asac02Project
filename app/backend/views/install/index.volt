
<link href="assets/theme7/css/pages/wizard/wizard-5.css" rel="stylesheet" type="text/css" />

<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->

            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Card-->
                        <div class="card card-custom">
                            <!--begin::Card Body-->
                            <div class="card-body p-0">
                                <!--begin::Wizard 5-->
                                <div class="wizard wizard-5 d-flex flex-column flex-lg-row flex-row-fluid" id="kt_wizard">
                                    <!--begin::Aside-->
                                    <div class="wizard-aside bg-white d-flex flex-column flex-row-auto w-100 w-lg-300px w-xl-400px w-xxl-500px">
                                        <!--begin::Aside Top-->
                                        <div class="d-flex flex-column-fluid flex-column px-xxl-30 px-10">
                                            <!--begin: Wizard Nav-->
                                            <div class="wizard-nav d-flex d-flex justify-content-center pt-10 pt-lg-20 pb-5">
                                                <!--begin::Wizard Steps-->
                                                <div class="wizard-steps">
                                                    <!--begin::Wizard Step 1 Nav-->
                                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                                        <div class="wizard-wrapper">
                                                            <div class="wizard-icon">
                                                                <i class="wizard-check ki ki-check"></i>
                                                                <span class="wizard-number">1</span>
                                                            </div>
                                                            <div class="wizard-label">
                                                                <h3 class="wizard-title">Database Bilgileri</h3>
                                                                <div class="wizard-desc">Kurulum için gerekli alanlar</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Wizard Step 1 Nav-->
                                                    <!--begin::Wizard Step 2 Nav-->
                                                    <div class="wizard-step" data-wizard-type="step">
                                                        <div class="wizard-wrapper">
                                                            <div class="wizard-icon">
                                                                <i class="wizard-check ki ki-check"></i>
                                                                <span class="wizard-number">2</span>
                                                            </div>
                                                            <div class="wizard-label">
                                                                <h3 class="wizard-title">Firma Bilgileri</h3>
                                                                <div class="wizard-desc">Firma erişim bilgileri</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Wizard Step 2 Nav-->
                                                    <!--begin::Wizard Step 3 Nav-->
                                                    <div class="wizard-step" data-wizard-type="step">
                                                        <div class="wizard-wrapper">
                                                            <div class="wizard-icon">
                                                                <i class="wizard-check ki ki-check"></i>
                                                                <span class="wizard-number">3</span>
                                                            </div>
                                                            <div class="wizard-label">
                                                                <h3 class="wizard-title">Modüller</h3>
                                                                <div class="wizard-desc">Kurulacak modüller</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Wizard Step 3 Nav-->
                                                </div>
                                                <!--end::Wizard Steps-->
                                            </div>
                                            <!--end: Wizard Nav-->
                                        </div>
                                        <!--end::Aside Top-->
                                        <!--begin::Aside Bottom-->
                                        <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-y-bottom bgi-position-x-center bgi-size-contain pt-2 pt-lg-5 h-350px" style="background-image: url(assets/theme7/media/svg/illustrations/features.svg)"></div>
                                        <!--end::Aside Bottom-->
                                    </div>
                                    <!--begin::Aside-->
                                    <!--begin::Content-->
                                    <div class="wizard-content bg-gray-100 d-flex flex-column flex-row-fluid py-15 px-5 px-lg-10">

                                        <!--begin::Form-->
                                        <div class="d-flex justify-content-center flex-row-fluid">
                                            <form class="pb-5 w-100 w-md-450px w-lg-500px" novalidate="novalidate" id="kt_form" method="post">
                                                <!--begin: Wizard Step 1-->
                                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                                    <!--begin::Title-->
                                                    <div class="pb-10 pb-lg-15">
                                                        <h3 class="font-weight-bolder text-dark font-size-h2">Veritabanı Bilgileri</h3>
                                                        <div class="text-muted font-weight-bold font-size-h5">Eksiksiz birşekilde tamamlayınız.</div>
                                                    </div>
                                                    <!--begin::Title-->
                                                    <!--begin::Form Group-->
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Sunucu Adı</label>
                                                        <input type="text" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="servername" id="servername" placeholder="Sunucu Adı" value="localhost" />
                                                    </div>
                                                    <!--end::Form Group-->
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Lisans Numarası</label>
                                                        <input type="text" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="licence" id="licence" placeholder="Lisans Key" value="" />
                                                    </div>
                                                    <div class="alert alert-secondary lisans_hata dn" role="alert"></div>
                                                    <div class="form-group text-right">
                                                        <button id="lisansButton" type="button" class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3">İleri
                                                            <span class="svg-icon svg-icon-md ml-1">
                                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                                        <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                                    </g>
                                                                </svg>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div id="nextstep" class="dn">
                                                        <div class="form-group">
                                                            <label class="font-size-h6 font-weight-bolder text-dark">Veritabanı Kullanıcı Adı</label>
                                                            <input type="text" class="form-control h-auto p-6 border-0 rounded-lg font-size-h6" name="db_username" placeholder="VT Kullanıcı Adı" value="root" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-size-h6 font-weight-bolder text-dark">Veritabanı Parola</label>
                                                            <input type="password" class="form-control h-auto p-6 border-0 rounded-lg font-size-h6" name="db_pass" placeholder="VT Parola" value="" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="font-size-h6 font-weight-bolder text-dark">Veritabanı Adı</label>
                                                            <input type="text" class="form-control h-auto p-6 border-0 rounded-lg font-size-h6" name="db_name" placeholder="Veritabanı Adı" value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end: Wizard Step 1-->
                                                <!--begin: Wizard Step 2-->
                                                <div class="pb-5" data-wizard-type="step-content">
                                                    <!--begin::Title-->
                                                    <div class="pb-10 pb-lg-15">
                                                        <h3 class="font-weight-bolder text-dark font-size-h2">Firma Bilgileri</h3>
                                                        <div class="text-muted font-weight-bold font-size-h4">Panel giriş bilgileri ve firma bilgileri</div>
                                                    </div>
                                                    <!--end::Title-->
                                                    <!--begin::Form Group-->
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Ad Soyad</label>
                                                        <input type="text" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="name" placeholder="Ad Soyad" value="" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">E-Mail</label>
                                                        <input type="email" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="email" placeholder="E posta" value="" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Parola</label>
                                                        <input type="password" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="password" id="password" placeholder="Parola" value="" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Tc Kimlik</label>
                                                        <input type="email" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="id_no" placeholder="Tc Kimlik" value="" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Telefon</label>
                                                        <input type="email" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="phone" placeholder="Telefon" value="" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Doğum Tarihi</label>
                                                        <input type="email" class="form-control h-auto p-5 border-0 rounded-lg font-size-h6"id="birth_date" name="birth_date" placeholder="Doğum Tarihi" value="" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-size-h6 font-weight-bolder text-dark">Cinsiyet</label>
                                                        <select  class="form-control h-auto p-5 border-0 rounded-lg font-size-h6" name="gender">
                                                            <option value="1">Erkek</option>
                                                            <option value="2">Kadın</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end: Wizard Step 2-->
                                                <!--begin: Wizard Step 3-->
                                                <div class="pb-5" data-wizard-type="step-content">
                                                    <!--begin::Title-->
                                                    <div class="pb-10 pb-lg-15">
                                                        <h3 class="font-weight-bolder text-dark font-size-h2">Modüller </h3>
                                                        <div class="form-group">

                                                            <div class="checkbox-list">
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="toplu_mail_gönderimi"/>
                                                                    <span></span>
                                                                    Toplu mail gönderimi
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="instagram_facebook"/>
                                                                    <span></span>
                                                                    InstaShop && Facebook Store
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark" >
                                                                    <input type="checkbox" name="google_merchant"/>
                                                                    <span></span>
                                                                    Google Merchant
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="ziyaretci_cıkıs_teklifi"/>
                                                                    <span></span>
                                                                    Ziyaretçi çıkış teklifi
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="b2b"/>
                                                                    <span></span>
                                                                    Bayi (B2B) altyapısı
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="shopcart_order"/>
                                                                    <span></span>
                                                                    Sepet ve sipariş hatırlatma
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="xml"/>
                                                                    <span></span>
                                                                    XML entegrasyonları
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="urun_karsilastirma"/>
                                                                    <span></span>
                                                                    Ürün karşılaştırma
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="e_fatura"/>
                                                                    <span></span>
                                                                    E-Fatura modülü
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="urun_kisisellestirme"/>
                                                                    <span></span>
                                                                    Ürün kişiselleştirme
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="alisverissiz_tahsilat"/>
                                                                    <span></span>
                                                                    Alışverişsiz tahsilat
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="n11"/>
                                                                    <span></span>
                                                                    N11 Entegrasyonu
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="hepsiburada"/>
                                                                    <span></span>
                                                                    Hepsiburada entegrasyonu
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="gittigidiyor"/>
                                                                    <span></span>
                                                                    Gittigidiyor entegrasyonu
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="amazon"/>
                                                                    <span></span>
                                                                    Amazon entegrasyonu
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="trendyol"/>
                                                                    <span></span>
                                                                    Trendyol entegrasyonu
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="muhasebe"/>
                                                                    <span></span>
                                                                    Muhabse programı entegrasyonları
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="seo"/>
                                                                    <span></span>
                                                                    Rakip SEO analizi
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="ios"/>
                                                                    <span></span>
                                                                    Özel IOS uygulama
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="android"/>
                                                                    <span></span>
                                                                    Özel Android uygulama
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="konsept_tasarim"/>
                                                                    <span></span>
                                                                    Konsept tasarım
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="sureli_popup"/>
                                                                    <span></span>
                                                                    Süreli popup
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="popup_voucher"/>
                                                                    <span></span>
                                                                    Süreli popup ile kampanya
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox" name="dil"/>
                                                                    <span></span>
                                                                    Çoklu dil desteği
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="coklu_para_birimi"/>
                                                                    <span></span>
                                                                    Çoklu para birimi
                                                                </label>
                                                                <label class="checkbox font-size-h6 font-weight-bolder text-dark">
                                                                    <input type="checkbox"  name="api"/>
                                                                    <span></span>
                                                                    Gelişmiş api modülü
                                                                </label>



                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Title-->
                                                    <!--begin::Section-->


                                                    <!--end::Section-->
                                                </div>
                                                <!--end: Wizard Step 3-->
                                                <!--begin: Wizard Actions-->
                                                <div class="d-flex justify-content-between pt-3">
                                                    <div class="mr-2">
                                                        <button type="button" class="btn btn-light-primary font-weight-bolder font-size-h6 pl-6 pr-8 py-4 my-3 mr-3" data-wizard-type="action-prev">
																<span class="svg-icon svg-icon-md mr-1">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24" />
																			<rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1" />
																			<path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)" />
																		</g>
																	</svg>
                                                                    <!--end::Svg Icon-->
																</span>Geri</button>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3" data-wizard-type="action-submit">Kaydet
                                                            <span class="svg-icon svg-icon-md ml-2">
																	<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
																	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																			<polygon points="0 0 24 0 24 24 0 24" />
																			<rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
																			<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
																		</g>
																	</svg>
                                                                <!--end::Svg Icon-->
																</span></button>
                                                        <button id="nextButton" type="button" class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3 dn" data-wizard-type="action-next">İleri
                                                            <span class="svg-icon svg-icon-md ml-1">
                                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                                        <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                                                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                                    </g>
                                                                </svg>
                                                            <!--end::Svg Icon-->
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--end: Wizard Actions-->
                                            </form>
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wizard 5-->
                            </div>
                            <!--end::Card Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->

            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->

<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="assets/theme7/js/pages/custom/wizard/wizard-5.js"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>