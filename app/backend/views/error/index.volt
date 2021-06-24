

<div class="d-flex flex-column flex-root">
    <!--begin::Error-->
    <div class="d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url({{ url('/assets/theme7/media/error/bg2.jpg') }})">
        <!--begin::Content-->
        <div class="d-flex flex-row-fluid flex-column justify-content-end align-items-center text-center text-white pb-40">
            <h1 class="display-1 font-weight-bold">HATA!</h1>
            <span class="display-4 font-weight-boldest mb-8">{% if text is defined %}{{ text }}{% endif %}</span>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Error-->
</div>