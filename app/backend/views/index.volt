<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>oyos akıllı e-ticaret</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <base href="{{url('')}}" />

    {{ stylesheet_link('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700') }}

    {{ stylesheet_link('assets/theme7/plugins/global/plugins.bundle.css') }}

    {{ stylesheet_link('assets/theme7/plugins/custom/prismjs/prismjs.bundle.css') }}
    {{ stylesheet_link('assets/theme7/css/style.bundle.css') }}
    {{ stylesheet_link('assets/theme7/plugins/codemirror/lib/codemirror.css') }}
    {{ stylesheet_link('assets/theme7/plugins/codemirror//theme/base16-dark.css') }}
    {{ stylesheet_link('assets/theme7/plugins/codemirror//theme/base16-light.css') }}

    {{ stylesheet_link('assets/theme7/css/pages/login/login-1.css') }}
    {{ stylesheet_link('assets/theme7/css/app.css')}}
    {{ stylesheet_link('assets/theme7/css/jkanban.css')}}

    {{ javascript_include('assets/theme7/plugins/global/plugins.bundle.js') }}
    {{ javascript_include('assets/theme7/plugins/custom/prismjs/prismjs.bundle.js') }}
    {{ javascript_include('assets/theme7/js/scripts.bundle.js') }}

    {{ javascript_include('assets/theme7/js/jkanban.js') }}

    {% if subpage is defined %}
        {% if subpage is 'seo' %}
            {{ javascript_include('assets/theme7/plugins/codemirror/lib/codemirror.js') }}
            {{ javascript_include('assets/theme7/plugins/codemirror/mode/javascript/javascript.js') }}
            {{ javascript_include('assets/theme7/plugins/codemirror/lib.codemirror.js') }}
        {% elseif subpage is 'content' %}
            {{ javascript_include('assets/theme7/plugins/codemirror/lib/codemirror.js') }}
            {{ javascript_include('assets/theme7/plugins/codemirror/mode/javascript/javascript.js') }}
            {{ javascript_include('assets/theme7/plugins/codemirror/lib.codemirror.js') }}
        {% elseif subpage is 'footer' %}
            {{ javascript_include('assets/theme7/plugins/codemirror/lib/codemirror.js') }}
            {{ javascript_include('assets/theme7/plugins/codemirror/mode/javascript/javascript.js') }}
            {{ javascript_include('assets/theme7/plugins/codemirror/lib.codemirror.js') }}
        {% endif %}


    {% endif %}



</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">

{% if page is not 'login' %}
    {{ partial('inc/mobile_header') }}
{% endif %}

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">

        {% if page is 'login' %}
            {{ partial('inc/login') }}
        {% elseif page is 'install' %}
            {{ partial('install/index') }}
        {% elseif page is 'error' %}
            {{ partial('error/index') }}
        {% else %}
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                {{ partial('inc/header') }}

                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
                        <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <div class="d-flex align-items-center flex-wrap mr-1"></div>
                        </div>
                    </div>

                    <div class="d-flex flex-column-fluid">

                        <div class="container">
                            {{ content() }}
                        </div>

                    </div>
                </div>

                {{ partial('inc/footer') }}

            </div>
        {% endif %}

    </div>
</div>

<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24" />
                <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
            </g>
        </svg>
    </span>
</div>

<!-- kullanıcı paneli başlar -->
{{ partial('inc/userpanel') }}
<!-- kullanıcı paneli biter-->

<script type="text/javascript" >

    var site_url = "{{url('')}}";
    var base_url = "{{ url('backend/') }}";
    var api_url = "{{ url('api/') }}";

    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };

</script> 
{% if type is defined %}
    {% if type is 'insert' or type is 'update' %}
        {{ javascript_include('assets/theme7/js/tagify.js') }}
        {{ javascript_include('assets/theme7/js/ckeditor-classic.bundle.js') }}
        {{ javascript_include('assets/theme7/js/jquery.validate.min.js') }}
        {{ javascript_include('assets/theme7/js/select2.min.js') }}
        {{ javascript_include('assets/theme7/js/moment-tr.js') }}
        {{ javascript_include('assets/theme7/js/comboTreePlugin.js') }}
        {{ stylesheet_link('assets/theme7/css/comboTreePlugin.css') }}
    {% endif %}
{% endif %}

{% if subpage is defined %}
    {% if subpage is 'variant' %}
        {{ javascript_include('assets/theme7/js/tables/variant.js') }}
    {% elseif subpage is 'paymentlist' %}
        {{ javascript_include('assets/theme7/js/tables/virtualpos.js') }}
    {% elseif subpage is 'paymenttype' %}
        {{ javascript_include('assets/theme7/js/tables/paymenttype.js') }}
    {% elseif subpage is 'pointlogs' %}
        {{ javascript_include('assets/theme7/js/tables/points.js') }}
    {% elseif subpage is 'brand' %}
        {{ javascript_include('assets/theme7/js/tables/brand.js') }}
    {% elseif subpage is 'cargo' %}
        {{ javascript_include('assets/theme7/js/tables/cargo.js') }}
    {% elseif subpage is 'usergroup' %}
        {{ javascript_include('assets/theme7/js/tables/usergroup.js') }}
        {{ javascript_include('assets/theme7/js/tables/modules.js') }}
    {% elseif subpage is 'user' %}
        {{ javascript_include('assets/theme7/js/tables/user.js') }}
    {% elseif subpage is 'content' %}
        {{ javascript_include('assets/theme7/js/tables/content.js') }}
    {% elseif subpage is 'tags' %}
        {{ javascript_include('assets/theme7/js/tables/tags.js') }}
    {% elseif subpage is 'pnotification' %}
        {{ javascript_include('assets/theme7/js/tables/pnotification.js') }}
    {% elseif subpage is 'supplier' %}
        {{ javascript_include('assets/theme7/js/tables/supplier.js') }}
    {% elseif subpage is 'comment' %}
        {{ javascript_include('assets/theme7/js/tables/comment.js') }}
    {% elseif subpage is 'feature' %}
        {{ javascript_include('assets/theme7/js/tables/feature.js') }}
    {% elseif subpage is 'category' %}
        {{ javascript_include('assets/theme7/js/tables/cat.js') }}
    {% elseif subpage is 'bank' %}
        {{ javascript_include('assets/theme7/js/tables/bank.js') }}
    {% elseif subpage is 'product' %}
        {{ javascript_include('assets/theme7/js/tables/product.js') }}
        {{ javascript_include('assets/theme7/js/tables/statisticpro.js') }}
    {% elseif subpage is 'contentcats' %}
        {{ javascript_include('assets/theme7/js/tables/contentcats.js') }}
    {% elseif subpage is 'vouchers' %}
        {{ javascript_include('assets/theme7/js/tables/vouchers.js') }}
    {% elseif subpage is 'currency' %}
        {{ javascript_include('assets/theme7/js/tables/currency.js') }}
    {% elseif subpage is 'request' %}
        {{ javascript_include('assets/theme7/js/tables/request.js') }}
    {% elseif subpage is 'order' %}
        {{ javascript_include('assets/theme7/js/tables/order.js') }}
    {% elseif subpage is 'refund' %}
        {{ javascript_include('assets/theme7/js/tables/refund.js') }}
    {% elseif subpage is 'integration_order' %}
        {{ javascript_include('assets/theme7/js/tables/integration_order.js') }}
    {% elseif subpage is 'integration_product' %}
        {{ javascript_include('assets/theme7/js/tables/statisticpro.js') }}
        {{ javascript_include('assets/theme7/js/tables/integration_product.js') }}
    {% elseif subpage is 'productbulk' %}
        {{ javascript_include('assets/theme7/js/tables/productbulk.js') }}
        {{ javascript_include('assets/theme7/js/comboTreePlugin.js') }}
        {{ stylesheet_link('assets/theme7/css/comboTreePlugin.css') }}
    {% elseif subpage is 'index' %}
        {# javascript_include('assets/theme7/js/pages/widgets.js?v=7.0.5') #}
    {% endif %}
{% endif %}

{{ javascript_include('assets/theme7/js/functions.js') }}
{{ javascript_include('assets/theme7/js/app.js') }}

</body>
</html>

