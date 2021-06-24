{% if modalLogo(activetheme)[activetheme] is defined %}
    <div class="modal p0m0" style="max-width: 600px !important;">
        <a href="{{ url(modalUrl(activetheme)) }}" style="display: flex;">
            <img src="{{ url('public/media/theme_content/modal/' ~ modalLogo(activetheme) ) }}" class="w100">
        </a>
    </div>
    <script>
        $(document).ready(function () {
            $(".modal").modal({});
        });
    </script>
{% endif %}