<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
    <!--begin::Aside-->
    <div class="login-aside d-flex flex-column flex-row-auto" style="background: #333;">
        <!--begin::Aside Top-->
        <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
            <!--begin::Aside header-->
            <a href="#" class="text-center mb-10">
                <img src="{{ url('assets/theme7/img/logo-big.png') }}" class="max-h-70px" alt="" />
            </a>
            <!--end::Aside header-->
            <!--begin::Aside title-->
            <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #ffffff;">akıllı e-ticaret sistemleri</h3>
            <!--end::Aside title-->
        </div>
        <!--end::Aside Top-->
        <!--begin::Aside Bottom-->
        <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url({{ url('assets/theme7/img/login.png') }})"></div>
        <!--end::Aside Bottom-->
    </div>
    <!--begin::Aside-->
    <!--begin::Content-->
    <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
        <!--begin::Content body-->
        <div class="d-flex flex-column-fluid flex-center">
            <!--begin::Signin-->
            <div class="login-form login-signin">
                <!--begin::Form-->
                <form class="" method="post" novalidate="novalidate" id="kt_login_signin_form">
                    <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                    </div>
                    <!--begin::Title-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="email" autocomplete="off" value="" />
                    </div>
                    <!--end::Form group-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Şifre</label>
                        </div>
                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off" value="" />
                    </div>
                    <!--end::Form group-->
                    <!--begin::Action-->
                    <div class="pb-lg-0 pb-5">
                        <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Giriş Yap</button>

                    </div>
                    <!--end::Action-->
                </form>
                <!--end::Form-->
            </div>

            <div class="login-form login-forgot">
                <form class="form" novalidate="novalidate" id="kt_login_forgot_form">

                    <div class="pb-13 pt-lg-0 pt-5">
                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Şifremi Unuttum</h3>
                        <p class="text-muted font-weight-bold font-size-h4">Şifreniz, email adresinize gönderilecektir.</p>
                    </div>

                    <div class="form-group">
                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                    </div>
                    <div class="form-group d-flex flex-wrap pb-lg-0">
                        <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Gönder</button>
                        <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Vazgeç</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
            <a href="https://www.oyos.com.tr/hizmetlerimiz" class="text-primary font-weight-bolder font-size-h5">Hizmetlerimiz</a>
            <a href="https://www.oyos.com.tr/iletisim" class="text-primary ml-10 font-weight-bolder font-size-h5">İletişim</a>
        </div>

    </div>

</div>
<script>
    history.pushState(null, null, null);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, null);
    });
</script>