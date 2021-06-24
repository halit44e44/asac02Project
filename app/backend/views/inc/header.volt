<div id="kt_header" class="header flex-column header-fixed">
    <div class="header-top">
        <div class="container">

            <div class="d-none d-lg-flex align-items-center mr-3">

                <a href="{{ url('backend') }}" class="mr-10">
                    <img alt="Logo" src="{{url('assets/theme7/img/logo.png')}}" class="max-h-40px" />
                </a>

                <ul class="header-tabs nav align-self-end font-size-lg" role="tablist">
                    {% if modulvizor is defined %}{% if modulvizor == "ok" %}
                    <li class="nav-item">
                        <a href="{{url('backend/')}}" class="nav-link py-4 px-6  {% if page is defined %}{% if page is 'index' %}active{% endif %}{% endif %}">{{cevir._('vizor')}}</a>
                    </li>
                    {% endif %}{% endif %}

                    {% if modulproduct is defined %}{% if modulproduct == "ok" %}
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link py-4 px-6  {% if page is defined %}{% if page is 'product' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#urunler_tab" role="tab">{{cevir._('urunler')}}</a>
                    </li>
                    {% endif %}{% endif %}
                    {% if modulorder is defined %}{% if modulorder == "ok" %}
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link py-4 px-6 {% if page is defined %}{% if page is 'order' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#siparisler_tab" role="tab">{{cevir._('siparisler')}}</a>
                    </li>
                    {% endif %}{% endif %}
                    {% if modulcontent is defined %}{% if modulcontent == "ok" %}
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link py-4 px-6 {% if page is defined %}{% if page is 'content' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#icerikler_tab" role="tab">{{cevir._('icerikler')}}</a>
                    </li>
                    {% endif %}{% endif %}
                    {% if modulvouchers is defined %}{% if modulvouchers == "ok" %}
                        <li class="nav-item mr-1">
                            <a href="#" class="nav-link py-4 px-6 {% if page is defined %}{% if page is 'campaign' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#kampanyanlar_tab" role="tab">{{cevir._('kampanyalar')}}</a>
                        </li>
                    {% endif %}{% endif %}
                    {% if modulstatistic is defined %}{% if modulstatistic == "ok" %}
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link py-4 px-6 {% if page is defined %}{% if page is 'statistic' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#istatistikler_tab" role="tab">{{cevir._('istatistikler')}}</a>
                    </li>
                    {% endif %}{% endif %}
                    {% if moduluser is defined %}{% if moduluser == "ok" %}
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link py-4 px-6 {% if page is defined %}{% if page is 'user' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#kullanicilar_tab" role="tab">{{cevir._('kullanicilar')}}</a>
                    </li>
                    {% endif %}{% endif %}
                    {% if moduluser is defined %}{% if moduluser == "ok" %}
                    <li class="nav-item mr-1">
                        <a href="#" class="nav-link py-4 px-6 {% if page is defined %}{% if page is 'integration' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#integration_tab" role="tab">Entegrasyonlar</a>
                    </li>
                    {% endif %}{% endif %}
                    {% if modulsetting is defined %}{% if modulsetting == "ok" %}
                    <li class="nav-item mr-1" {% if setting is defined %}{% if setting=='ok' %} style="display: none" {% endif %}{% endif %}>
                        <a href="#" class="nav-link py-4 px-6 {% if page is defined %}{% if page is 'setting' %}active{% endif %}{% endif %}" data-toggle="tab" data-target="#ayarlar_tab" role="tab">{{cevir._('ayarlar')}}  </a>
                    </li>
                    {% endif %}{% endif %}
                </ul>
            </div>

            <div class="topbar">

                <?php $user = Yabasi\User::find("seen=1");?>
                <?php $noti_comment = \Yabasi\Comment::find('seen="1"'); ?>
                <?php $noti_refund = \Yabasi\Refund::find('seen="1"'); ?>
                <?php $noti_order = \Yabasi\Order::find('seen="1"'." and meta_key='order'"); ?>
                <?php $noti_pnotification = \Yabasi\Pnotification::find('seen="1"'); ?>
                <?php $noti_request = \Yabasi\Request::find('seen="1"'); ?>
                <?php $totalNotification = $user->count()+$noti_comment->count()+$noti_request->count()+$noti_pnotification->count()+$noti_order->count()+$noti_refund->count(); ?>
                <?php if ($totalNotification > 0) { ?>
                <div class="dropdown">
                    <!--begin::Toggle-->
                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                        <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1 pulse pulse-white">
                            <span class="svg-icon svg-icon-xl">
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
                            <span class="pulse-ring"></span>
                        </div>
                    </div>
                    <!--end::Toggle-->

                    <!--begin::Dropdown-->
                    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                        <form>
                            <!--begin::Header-->
                            <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url({{ url('assets/theme7/media/misc/bg-1.jpg') }})">
                                <!--begin::Title-->

                                <h4 class="d-flex flex-center rounded-top">
                                    <span class="text-white">Bildirimler</span>
                                    <span class="btn btn-text btn-warning btn-sm font-weight-bold btn-font-md ml-2"> <?php  echo $totalNotification; ?> yeni</span>
                                </h4>

                            </div>
                            <!--end::Header-->
                            <!--begin::Content-->
                            <div class="tab-content">
                                <!--begin::Tabpane-->
                                <div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
                                    <!--begin::Scroll-->
                                    <div class="scroll pr-7 mr-n7" data-scroll="true" data-mobile-height="200" style="height: auto; max-height: 300px;">
                                        <!--begin::Item-->

                                        <?php foreach ($user as $users) { ?>
                                        <?php  if ($user->count()<3) { ?>

                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="{{ url('backend/user/index/seen') }}" class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo $users->getEmail();?></a>
                                                <span class="text-muted"><?php echo $users->getName()." isimli kullanıcı üye oldu"; ?></span>

                                            </div>

                                        </div>
                                        <?php } ?>
                                        <?php if ($user->count()>2) { ?>
                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="backend/user/index/seen" class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo "Kullancılar";  ?></a>
                                                <span class="text-muted"><?php echo $user->count()." tane Kullanıcı üye oldu"; ?></span>

                                            </div>

                                        </div>

                                        <?php break;  }  ?>

                                        <?php } ?>


                                        <?php foreach ($noti_pnotification as $alt) {?>
                                        <?php $email=\Yabasi\User::findFirst($alt->getUserId());?>
                                        <?php $order=\Yabasi\Order::findFirst($alt->getOrderId()); ?>
                                        <?php $json=json_decode($order->getMetavalue(),true); ?>
                                        <?php $bank=\Yabasi\Bank::findFirst($alt->getBankId()); ?>
                                        <?php  if ($noti_pnotification->count()<3) { ?>
                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="backend/pnotification/index/seen/"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo $email->getName();?></a>
                                                <span class="text-muted"><?php if($json && $bank){echo $json['code']." kodlu siparişe ".$bank->getName()." bankasına ödeme bildirimi yaptı"; }?></span>

                                            </div>

                                        </div>
                                        <?php } ?>
                                        <?php if ($noti_pnotification->count()>2) { ?>

                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="backend/pnotification/index/seen"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo "Ödeme Bildirimi";  ?></a>
                                                <span class="text-muted"><?php echo $noti_pnotification->count()." tane ödeme bildirimi yapıldı"; ?></span>
                                            </div>

                                        </div>
                                        <?php break;  }  ?>

                                        <?php } ?>

                                        <?php foreach ($noti_refund as $alt) {?>
                                        <?php $email=\Yabasi\User::findFirst($alt->getUserId());?>


                                        <?php  if ($noti_refund->count()<3) { ?>
                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="backend/refund/detail/<?php echo $alt->getId(); ?>"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo $email->getName();?></a>
                                                <span class="text-muted"><?php echo $alt->getCode()." kodlu siparişe  iade talebinde bulundu"; ?></span>

                                            </div>

                                        </div>
                                        <?php } ?>
                                        <?php if ($noti_refund->count()>2) { ?>

                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="backend/refund/index/seen"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo "İade Bildirimi";  ?></a>
                                                <span class="text-muted"><?php echo $noti_refund->count()." tane iade bildirimi yapıldı"; ?></span>
                                            </div>

                                        </div>
                                        <?php break;  }  ?>

                                        <?php } ?>
                                        <?php foreach ($noti_order as $alt) {?>
                                        <?php $email=\Yabasi\User::findFirst($alt->getUserId());?>
                                        <?php $json=json_decode($alt->getMetavalue(),true); ?>
                                        <?php  if ($noti_order->count()<3) { ?>
                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="backend/order/index/<?php echo $alt->getId();?>/seen/"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo $email->getName();?></a>
                                                <span class="text-muted"><?php echo $json['code']." kodlu sipariş alındı";?></span>

                                            </div>

                                        </div>
                                        <?php } ?>
                                        <?php if ($noti_order->count()>2) { ?>

                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="backend/order/index/0/seen"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo "Sipariş Bildirimi";  ?></a>
                                                <span class="text-muted"><?php echo $noti_order->count()." tane ödeme bildirimi yapıldı"; ?></span>
                                            </div>

                                        </div>
                                        <?php break;  }  ?>

                                        <?php } ?>

                                        <?php foreach ($noti_comment as $alt) {?>
                                        <?php $email=\Yabasi\User::findFirst($alt->getUserId());?>
                                        <?php $pro=\Yabasi\Product::findFirst($alt->getProId());?>
                                        <?php  if ($noti_comment->count()<3) { ?>
                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="backend/comment/index/seen/<?php echo $alt->getId();?>"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo $email->getName();?></a>
                                                <span class="text-muted"><?php echo $pro->getName()." isimli ürüne ".$alt->getComment()." yorumunu yaptı"; ?></span>

                                            </div>

                                        </div>
                                        <?php } ?>
                                        <?php if ($noti_comment->count()>2) { ?>

                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">
                                                <a href="backend/comment/index/seen"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo "Yorumlar";  ?></a>
                                                <span class="text-muted"><?php echo $noti_comment->count()." tane yorum yapıldı"; ?></span>
                                            </div>

                                        </div>
                                        <?php break;  }  ?>

                                        <?php } ?>

                                        <?php foreach ($noti_request as $request) { ?>
                                        <?php $email=\Yabasi\User::findFirst($request->getUserId());?>
                                        <?php $pro=\Yabasi\Product::findFirst($request->getProductId()); ?>
                                        <?php  if ($noti_request->count()<3) { ?>
                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="backend/request/index/seen"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo $email->getName();?></a>
                                                <span class="text-muted"><?php echo $pro->getName()." isimli ürüne ".$email->getName()." istek yaptı"; ?></span>

                                            </div>

                                        </div>
                                        <?php } ?>
                                        <?php if ($noti_request->count()>2) { ?>

                                        <div class="d-flex align-items-center mb-6">
                                            <!--begin::Symbol-->

                                            <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="d-flex flex-column font-weight-bold">

                                                <a href="backend/request/index/seen"  class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo "İstekler";  ?></a>
                                                <span class="text-muted"><?php echo $noti_request->count()." tane istek var"; ?></span>

                                            </div>

                                        </div>
                                        <?php break;  }  ?>

                                        <?php } ?>


                                </div>
                                </div>
                                <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                    <!--begin::Nav-->
                                    <div class="d-flex flex-center text-center text-muted min-h-200px">All caught up!
                                    <br />No new notifications.</div>
                                    <!--end::Nav-->
                                </div>
                                <!--end::Tabpane-->
                            </div>
                            <!--end::Content-->
                        </form>
                    </div>
                    <!--end::Dropdown-->

                </div>
                <?php } ?>
                <div class="topbar-item">
                    <div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                        <span class="symbol symbol-35">
                            <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30">
                                <span class="svg-icon svg-icon-warning svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                        </span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!--nav content başlar -->
    <div class="header-bottom">

        <div class="container">

            <div class="header-navs header-navs-left" id="kt_header_navs">

                <ul class="header-tabs p-5 p-lg-0 d-flex d-lg-none nav nav-bold nav-tabs" role="tablist">

                    <li class="nav-item mr-2">
                        <a href="{{ url('backend/') }}" class="nav-link btn btn-clean">{{cevir._('vizor')}}</a>
                    </li>

                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean" data-toggle="tab" data-target="#urunler_tab" role="tab">{{cevir._('urunler')}}</a>
                    </li>

                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean" data-toggle="tab" data-target="#siparisler_tab" role="tab">{{cevir._('siparisler')}}</a>
                    </li>

                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean" data-toggle="tab" data-target="#icerikler_tab" role="tab">{{cevir._('icerikler')}}</a>
                    </li>

                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean" data-toggle="tab" data-target="#istatistikler_tab" role="tab">{{cevir._('istatistikler')}}</a>
                    </li>

                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean" data-toggle="tab" data-target="#kullanicilar_tab" role="tab">{{cevir._('kullanicilar')}}</a>
                    </li>

                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean" data-toggle="tab" data-target="#integration_tab" role="tab">Entegrasyonlar</a>
                    </li>

                    <li class="nav-item mr-2">
                        <a href="#" class="nav-link btn btn-clean" data-toggle="tab" data-target="#ayarlar_tab" role="tab">{{cevir._('ayarlar')}}</a>
                    </li>

                </ul>

                <div class="tab-content">

                    <div class="tab-pane p-5 p-lg-0 justify-content-between  {% if page is defined %}{% if page is 'index' %}active{% endif %}{% endif %}" id="vizor_tab">

                        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center">

                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{ url('') }}" target="_blank" class="btn btn-light-primary font-weight-bold my-2 my-lg-0 mr-2"><i class="flaticon-home"></i> Anasayfa</a>
                            <a href="{{ url('backend/modul') }}" class="btn btn-light-danger font-weight-bold my-2 my-lg-0 mr-2"><i class="flaticon-tool"></i> Modüller</a>
                        </div>

                    </div>

                    <div  class="tab-pane py-5 p-lg-0 {% if page is defined %}{% if page is 'product' %}show active{% endif %}{% endif %}" id="urunler_tab">
                        <div class="header-menu header-menu-mobile header-menu-layout-default">

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true" {% if product is defined %}{% if product=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/product') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'product' %}text-primary{% endif %}{% endif %}">{{cevir._('urun_listesi')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if category is defined %}{% if category=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/category') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'category' %}text-primary{% endif %}{% endif %}">{{cevir._('urun_kategorileri')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if brand is defined %}{% if brand=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/brand') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'brand' %}text-primary{% endif %}{% endif %}">{{cevir._('markalar')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if feature is defined %}{% if feature=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/feature') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'feature' %}text-primary{% endif %}{% endif %}">{{cevir._('urun_ozellikleri')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if variant is defined %}{% if variant=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/variant') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'variant' %}text-primary{% endif %}{% endif %}">{{cevir._('varyasyonlar')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if product is defined %}{% if product=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/supplier') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'supplier' %}text-primary{% endif %}{% endif %}">{{cevir._('tedarikciler')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/request') }}" class="menu-link" {% if request is defined %}{% if request=='ok' %} style="display: none" {% endif %}{% endif %}>
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'request' %}text-primary{% endif %}{% endif %}">{{cevir._('talepler')}}</span>
                                    </a>
                                </li>
                                {% if modulupdate_product is defined %}{% if modulupdate_product=="ok" %}
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/productbulk/categoryupdate') }}" class="menu-link" {% if productbulk is defined %}{% if productbulk=='ok' %} style="display: none" {% endif %}{% endif %}>
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'productbulk' %}text-primary{% endif %}{% endif %}">{{cevir._('toplu_urun_guncelle')}}</span>
                                    </a>
                                </li>
                                {% endif %}{% endif %}
                            </ul>
                        </div>
                    </div>

                    <div  class="tab-pane py-5 p-lg-0 {% if page is defined %}{% if page is 'integration' %}show active{% endif %}{% endif %}" id="integration_tab">
                        <div class="header-menu header-menu-mobile header-menu-layout-default">
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/integration/product/index') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'integration_product' %}text-primary{% endif %}{% endif %}">Ürün listesi</span>
                                    </a>
                                </li>
                            </ul>

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/integration/order/index') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'integration_order' %}text-primary{% endif %}{% endif %}">Sipariş Listesi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane py-5 p-lg-0 {% if page is defined %}{% if page is 'order' %}show active{% endif %}{% endif %}" id="siparisler_tab">
                        <div class="header-menu header-menu-mobile header-menu-layout-default">

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true" {% if order is defined %}{% if order=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/order') }}" class="menu-link">
                                        <span class="menu-text {% if page is defined %}{% if page is 'order' %}{% if subpage is defined %}{% if subpage is 'order' %}text-primary{% endif %}{% endif %}{% endif %}{% endif %}">{{cevir._('siparis_listesi')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if bank is defined %}{% if bank=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/bank') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'bank' %}text-primary{% endif %}{% endif %}">{{cevir._('Bankalar')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if paymentnotification is defined %}{% if paymentnotification=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/pnotification') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'pnotification' %}text-primary{% endif %}{% endif %}">{{cevir._('odeme_bildirimleri')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if order is defined %}{% if order=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/refund') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'refund' %}text-primary{% endif %}{% endif %}">{{cevir._('iade_ve_iptal_talepleri')}}</span>
                                    </a>
                                </li>
                                <li class="menu-item" aria-haspopup="true" {% if cargo is defined %}{% if cargo=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/cargo') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'cargo' %}text-primary{% endif %}{% endif %}">{{cevir._('kargo_firmalari')}}</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane py-5 p-lg-0 {% if page is defined %}{% if page is 'content' %}show active{% endif %}{% endif %}" id="icerikler_tab">
                        <div class="header-menu header-menu-mobile header-menu-layout-default">

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true" {% if content is defined %}{% if content=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/content') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'content' %}text-primary{% endif %}{% endif %}">{{cevir._('icerikler')}}</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true" {% if contentcats is defined %}{% if contentcats=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/contentcats') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'contentcats' %}text-primary{% endif %}{% endif %}">{{cevir._('İçerik Kategorileri')}}</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/comment') }}" class="menu-link" {% if comment is defined %}{% if comment=='ok' %} style="display: none" {% endif %}{% endif %}>
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'comment' %}text-primary{% endif %}{% endif %}">{{cevir._('yorumlar')}}</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/tags') }}" class="menu-link" {% if content is defined %}{% if content=='ok' %} style="display: none" {% endif %}{% endif %}>
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'tags' %}text-primary{% endif %}{% endif %}">{{cevir._('etiketler')}}</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="tab-pane py-5 p-lg-0 {% if page is defined %}{% if page is 'campaign' %}show active{% endif %}{% endif %}" id="kampanyanlar_tab">
                        <div class="header-menu header-menu-mobile header-menu-layout-default">

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true" {% if vouchers is defined %}{% if vouchers=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/vouchers') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'vouchers' %}text-primary{% endif %}{% endif %}">{{cevir._('hediye_cekleri')}}</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="tab-pane py-5 p-lg-0 {% if page is defined %}{% if page is 'statistic' %}show active{% endif %}{% endif %}" id="istatistikler_tab">
                        <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/statistic/order') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'order' %}text-primary{% endif %}{% endif %}">Sipariş İstatistikleri</span>
                                    </a>
                                </li>
                            </ul>

                            <ul class="menu-nav">
                                <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                                    <a href="javascript:;" class="menu-link menu-toggle">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'product' %}text-primary{% endif %}{% endif %}">Ürün İstatistikleri</span>
                                        <span class="menu-desc"></span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                    <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                        <ul class="menu-subnav">
                                            <li class="menu-item {% if navpage is defined %}{% if navpage is 'product' %}menu-item-active{% endif %}{% endif %}" data-menu-toggle="hover" aria-haspopup="true">
                                                <a href="{{ url('backend/statistic/product') }}" class="menu-link" style="padding: 11px 20px;">
                                                    <span class="svg-icon menu-icon">
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M3,16 L21,16 C21,18.209139 19.209139,20 17,20 L7,20 C4.790861,20 3,18.209139 3,16 Z M3,11 L21,11 L21,12 C21,13.1045695 20.1045695,14 19,14 L5,14 C3.8954305,14 3,13.1045695 3,12 L3,11 Z" fill="#000000"/>
                                                                <path d="M3,5 L21,5 L21,7 C21,8.1045695 20.1045695,9 19,9 L5,9 C3.8954305,9 3,8.1045695 3,7 L3,5 Z" fill="#000000" opacity="0.3"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span class="menu-text">En çok sipariş verilen ürünler</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {% if navpage is defined %}{% if navpage is 'user' %}menu-item-active{% endif %}{% endif %}" aria-haspopup="true">
                                                <a href="{{ url('backend/statistic/products/user') }}" class="menu-link" style="padding: 11px 20px;">
                                                    <span class="svg-icon menu-icon">
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span class="menu-text">En çok sipariş veren kullanıcılar</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {% if navpage is defined %}{% if navpage is 'giro' %}menu-item-active{% endif %}{% endif %}" aria-haspopup="true">
                                                <a href="{{ url('backend/statistic/products/giro') }}" class="menu-link" style="padding: 11px 20px;">
                                                    <span class="svg-icon menu-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z" fill="#000000" fill-rule="nonzero"/>
                                                                <path d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span class="menu-text">Aylık ciro verileri</span>
                                                </a>
                                            </li>
                                            <li class="menu-item {% if navpage is defined %}{% if navpage is 'order' %}menu-item-active{% endif %}{% endif %}" aria-haspopup="true">
                                                <a href="{{ url('backend/statistic/products/order') }}" class="menu-link" style="padding: 11px 20px;">
                                                    <span class="svg-icon menu-icon">
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"/>
                                                                <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                <path d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z" fill="#000000"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <span class="menu-text">Ürün tabanlı sipariş verileri</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>



                            <ul class="menu-nav dn">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/statistic/visitor') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'visitor' %}text-primary{% endif %}{% endif %}">Ziyaretçi İstatistikleri</span>
                                    </a>
                                </li>
                            </ul>

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/statistic/user') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'user' %}text-primary{% endif %}{% endif %}">Kullanıcı İstatistikleri</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="tab-pane py-5 p-lg-0 justify-content-between {% if page is defined %}{% if page is 'user' %}show active{% endif %}{% endif %}" id="kullanicilar_tab">

                        <div class="header-menu header-menu-mobile header-menu-layout-default">
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true" {% if user is defined %}{% if user=='ok' %} style="display: none" {% endif %}{% endif %}>
                                    <a href="{{ url('backend/user') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'user' %}text-primary{% endif %}{% endif %}">{{cevir._('kullanici_listesi')}}</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/usergroup') }}" class="menu-link" {% if usergroup is defined %}{% if usergroup=='ok' %} style="display: none" {% endif %}{% endif %}>
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'usergroup' %}text-primary{% endif %}{% endif %}">{{cevir._('kullanici_gruplari')}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="tab-pane py-5 p-lg-0 {% if page is defined %}{% if page is 'setting' %}show active{% endif %}{% endif %}" id="ayarlar_tab" >
                        <div class="header-menu header-menu-mobile header-menu-layout-default">

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/setting') }}" class="menu-link">
                                        <span class="menu-text {% if page is defined %}{% if subpage is not defined %}{% if page is 'setting' %}text-primary{% endif %}{% endif %}{% endif %}">{{cevir._('genel_ayarlar')}}</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/setting/themes') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'themes' %}text-primary{% endif %}{% endif %}">{{cevir._('tasarim_ayarlari')}}</span>
                                    </a>
                                </li>
                            </ul>
                            {% if modulpayment is defined %}{% if modulpayment=='ok' %}
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/setting/paymentlist') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'paymentlist' %}text-primary{% endif %}{% endif %}">{{cevir._('odeme_ayarlari')}}</span>
                                    </a>
                                </li>
                            </ul>
                            {% endif %}{% endif %}

                            {% if modulpayment is defined %}{% if modulpayment=='ok' %}
                                <ul class="menu-nav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('backend/setting/paymenttype') }}" class="menu-link">
                                            <span class="menu-text {% if subpage is defined %}{% if subpage is 'paymenttype' %}text-primary{% endif %}{% endif %}">{{cevir._('odeme_yontemleri')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            {% endif %}{% endif %}

                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/setting/seo') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'seo' %}text-primary{% endif %}{% endif %}">{{cevir._('seo_ayarlari')}}</span>
                                    </a>
                                </li>
                            </ul>
                            {% if modulcurrency is defined %}{% if modulcurrency=='ok' %}
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/setting/currency') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'currency' %}text-primary{% endif %}{% endif %}">{{cevir._('doviz_kurlari')}}</span>
                                    </a>
                                </li>
                            </ul>
                            {% endif %}{% endif %}

                            {% if modulpoint is defined %}{% if modulpoint=='ok' %}
                            <ul class="menu-nav">
                                <li class="menu-item" aria-haspopup="true">
                                    <a href="{{ url('backend/setting/point') }}" class="menu-link">
                                        <span class="menu-text {% if subpage is defined %}{% if subpage is 'point' %}text-primary{% endif %}{% endif %}">{{cevir._('puan_sistemi')}}</span>
                                    </a>
                                </li>
                            </ul>
                            {% endif %}{% endif %}

                            {% if modulpoint is defined %}{% if modulpoint=='ok' %}
                                <ul class="menu-nav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('backend/setting/pointlogs') }}" class="menu-link">
                                            <span class="menu-text {% if subpage is defined %}{% if subpage is 'pointlogs' %}text-primary{% endif %}{% endif %}">{{cevir._('puan_kayitlari')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            {% endif %}{% endif %}
                            {% if modulpoint is defined %}{% if modulpoint=='ok' %}
                                <ul class="menu-nav">
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="{{ url('backend/setting/othersettings') }}" class="menu-link">
                                            <span class="menu-text {% if subpage is defined %}{% if subpage is 'othersetting' %}text-primary{% endif %}{% endif %}">{{cevir._('Diğer Ayarlar')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            {% endif %}{% endif %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function noti(el) {
        const id = $(el).data('id');

        const table = $(el).data('table');
        if (table==="user"){
            $.get(base_url + 'edit/do/', {table: table, id: id}).done(function (data) {

                if (data.status === "noauth") {
                    Swal.fire(
                        "Düzenlenemez!",
                        "Yetkiniz Yokdur!",
                        "warning"
                    );
                }
                else if (data.status === true) {


                    location.href="backend/user/profile/vizor/"+id;
                }


            });
        }
        else {
            $.get(base_url + 'edit/do/', {table: table, id: id}).done(function (data) {
                if (data.status === "noauth") {
                    Swal.fire(
                        "Düzenlenemez!",
                        "Yetkiniz Yokdur!",
                        "warning"
                    );
                }
                else if (data.status === true) {
                    if (table==="cats"){
                        location.href="backend/category/update/"+id;
                    }else {
                        location.href="backend/"+table+"/update/"+id;

                    }   }


            });
        }
    }
</script>