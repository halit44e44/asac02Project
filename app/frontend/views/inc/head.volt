{% if meta_tag is defined %}{{ meta_tag }}{% endif %}

<link rel="icon" type="image/png" href="{{ url('media/fav.png') }}" />

<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link href="//fonts.googleapis.com/css?family=Barlow:400,400i,700|PT+Sans:400,400i,700&display=swap" rel="stylesheet">

{{ stylesheet_link('assets/frontend/css/magnific-popup.css') }}
{{ stylesheet_link('assets/frontend/css/swiper.min.css') }}
{{ stylesheet_link('assets/frontend/css/jquery.modal.min.css') }}
{{ stylesheet_link('assets/frontend/css/xzoom.css') }}
{{ stylesheet_link('assets/frontend/css/simple-line-icons.css') }}

{{ javascript_include('assets/frontend/js/jquery-3.3.1.js') }}
{{ javascript_include('assets/frontend/js/jquery.magnific-popup.min.js') }}
{{ javascript_include('assets/frontend/js/swiper.min.js') }}
{{ javascript_include('assets/frontend/js/app.js') }}
{{ javascript_include('assets/frontend/js/function.js') }}
{{ javascript_include('assets/frontend/js/jquery.modal.min.js') }}
{{ javascript_include('assets/frontend/js/xzoom.min.js') }}
{{ javascript_include('assets/frontend/js/jquery.mask.min.js') }}
{{ javascript_include('assets/frontend/js/script.js') }}
{{ javascript_include('assets/frontend/js/jquery-rate-picker.js') }}

<?php $rand = rand(9,999999); ?>
{{ stylesheet_link('assets/frontend/css/style.css?v=' ~ rand) }}

{{ partial('inc/style') }}

{{ stylesheet_link('assets/frontend/css/media.css?v=' ~ rand) }}

{% if google_analytics is defined %}
    <script>
        {% if google_analytics is defined %}{{ google_analytics }}{% endif %}
    </script>
{% endif %}

{% if google_order is defined %}
    <script>
        {% if google_order is defined %}{{ google_order }}{% endif %}
    </script>
{% endif %}

