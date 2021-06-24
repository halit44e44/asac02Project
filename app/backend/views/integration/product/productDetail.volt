<style>
    .dropdown-toggle.bs-placeholder.btn{
        color:black!important;
    }
</style>

<div class="card card-custom mb-10">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">{{productName}}</h3>
        </div>
    </div>
</div>

{% for integrationCategory in integrationCategoryList %}
    <div class="card card-custom mb-10">
        <div class="card-header card-header-tabs-line">
            <div class="card-title">
                <h3 class="card-label">Kategori: {{integrationCategory['site_category_name']}}</h3>
            </div>
        </div>

        <div class="card-body">
            <form action="" method="POST">
                    <input type="hidden" name="place_category_id" value="{{integrationCategory['place_category_id']}}">

                    {% for variant in productVariant %}
                        <div class="d-flex justify-content-between flex-column flex-md-row">
                            <h3 class="font-weight-boldest mb-10">
                                Variant: {{variant['variant_name']}}
                            </h3>
                        </div>

                        {% for field in integrationCategory['custom_fields'] %}
                                <div class="form-group mb-8">
                                    <label class="font-weight-bolder">{{field['name']}}</label>
                                    <select
                                        class="form-control form-control-solid form-control-lg picker"
                                        data-live-search="true"
                                        {% if field['multipleSelect'] === 'true' %} multiple="multiple" {% endif %}
                                        name="{{variant['site_variant_id']}}#!{{field['name']}}"
                                        {% if field['mandatory'] === 'false' %} required {% endif %}
                                    >
                                        {% if field['list'] is defined %}
                                                <option value="">Seçim Yapınız</option>
                                            {% for value in field['list'] %}
                                                <option value="{{ value['id'] }}#!{{ value['name'] }}">{{ value['name'] }}</option>
                                            {% endfor %}
                                        {% endif %}
                                    </select>
                                </div>
                            {% endfor %}
                    {% endfor %}

                <div class="form-group mb-8">
                    <button type="submit" id="submitBtn" class="btn btn-primary font-weight-bolder mr-2 mb-10 px-8 col-md-12">Kaydet</button>
                </div>  
            </form>
        </div>
    </div>
{% endfor %}

<script>
    $(document).ready(function () {

        $( "form" ).submit(function( event ) {
            var dataString = $(this).serialize();  

            $.ajax({
                type: "POST",
                url: "",
                data: dataString,
                success: function (res) {
                    console.log(res); 
                }
            });

            event.preventDefault();
        });


        $('.picker').selectpicker({
            style: 'fixbtn',
            noneSelectedText: 'Seçim yapınız'
        });
    });

</script>