<form id="vouchersForm" method="post">
    <input type="hidden" name="id" value="{{ vouchers.id }}" />
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">Kampanya Ekle</h3>
        </div>

        <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

        <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Hediye Kodu:</label>
                    <div class="input-group">
                        <input type="text" id="voucher_code" name="voucher_code" value="{{ vouchers.code}}"  class="form-control form-control-solid" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="makeid()">Kod Üret</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">

                <div class="col-lg-12">
                    <label>Kampanya Adı: </label>
                    <div class="input-group">
                        <input type="text" id="name" name="name" class="form-control form-control-solid" placeholder="Kampanya Adı" value="{{ vouchers.name }}" />
                    </div>
                </div>
            </div>

            <div class="form-group row">

                <div class="col-lg-6">
                    <label> Max Kullanım Sayısı:</label>
                    <div class="input-group">
                        <input type="number" id="maximum_usage" name="maximum_usage" class="form-control form-control-solid"  {% if meta_value is defined %}  value="{{ meta_value['maximum_usage']  }}" {% endif %}  placeholder="Max Kullanım Sayısı" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <label> Kişi Başı Kullanım Sınırı: </label>
                    <div class="input-group">
                        <input type="number" id="limit_of_per_person" name="limit_of_per_person" class="form-control form-control-solid" placeholder="Kişi Başı Kullanım Sınırı"  {% if meta_value is defined %}value="{{  meta_value['limit_of_per_person']  }}"{% endif %}  />
                    </div>
                </div>
            </div>

            <div class="form-group row">

                <div class="col-lg-6">
                    <label> Başlangıç Tarihi:</label>
                    <div class="input-group">
                        <input type="text" id="start_date" name="start_date" class="form-control form-control-solid" value="{{ date }}"/>
                    </div>
                </div>

                <div class="col-lg-6">
                    <label> Bitiş Tarihi: </label>
                    <div class="input-group">
                        <input type="text" id="end_date" name="end_date" class="form-control form-control-solid" value="{{ enddate }}" />
                    </div>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-lg-6">
                    <label> İndirim Tipi:</label>
                    <div class="input-group">
                        <select class="form-control form-control-solid select" name="discount_type">
                            <option {%if( meta_value['discount_type']==1 ) %} selected {%endif%} value="1">Sabit</option>
                            <option {%if( meta_value['discount_type']==2 ) %} selected {%endif%}value="2">Yüzde</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <label> İndirim: </label>
                    <div class="input-group">
                        <input type="number" id="discount" name="discount" class="form-control form-control-solid" value="{{ meta_value['discount'] }}"  placeholder="Değer"/>
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label> Özel Çek Tanımla:</label>
                    <div class="input-group">
                        <select class="form-control form-control-solid select" id="kt_select2_4" name="voucher">
                            <option {%if( meta_value['voucher_type']==1 ) %} selected  {%endif%}  value="1">Tüm Kategori ve Markalar</option>
                            <option {%if( meta_value['voucher_type']==2 ) %} selected  {%endif%} value="2">Belirli Ürünlere Özel</option>
                            <option {%if( meta_value['voucher_type']==3 ) %} selected {%endif%} value="3">Belirli Kategorilere Özel</option>
                            <option{%if( meta_value['voucher_type']==4 ) %} selected {%endif%}  value="4">Belirli Markalara Özel</option>
                            <option {%if( meta_value['voucher_type']==5 ) %} selected {%endif%} value="5">Belirli Üyelere Özel</option>
                            <option {%if( meta_value['voucher_type']==6 ) %} selected {%endif%} value="6">Belirli Üye Grublarına Özel</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-6 mt-8" id="select"{%if( meta_value['voucher_type']!=1 ) %}  style="display: block;" {%endif%}  style="display: none;">
                   <div class="radio-inline">
                       <div id="usergroups" {%if( meta_value['voucher_type']==6 ) %}  style="display: block;"   {%endif%}  style="display: none;">
                           <select class="selectpicker" data-live-search="true" name="usergroups[]" multiple="multiple" >
                                 <option value="0">Tamamı</option>
                                {% if userGroups is defined %}
                                    {% for groups in userGroups %}
                                    <option  {% for voucher in meta_value['voucher_value']   %}  {%if( voucher==groups.id ) %}  selected    {%endif%}    {% endfor %} value="{{ groups.id }}">{{ groups.name }}</option>
                                    {% endfor %}
                                {% endif %}
                           </select>
                       </div>
                       <div id="product" {%if( meta_value['voucher_type']==2 ) %}  style="display: block;"   {%endif%} style="display: none;">
                           <select class="selectpicker" data-live-search="true" name="product[]" multiple="multiple">
                               <option value="0">Tamamı</option>
                               {% if product is defined %}
                                   {% for product in product %}
                                       <option  {% for voucher in meta_value['voucher_value']   %} {%if( voucher==product.id ) %}  selected    {%endif%}    {% endfor %}
                                               value="{{ product.id }}">{{ product.name }}</option>
                                   {% endfor %}
                               {% endif %}
                           </select>
                       </div>
                       <div id="cats" {%if( meta_value['voucher_type']==3 ) %}  style="display: block;"   {%endif%}  style="display: none;">
                           <select class="selectpicker" data-live-search="true" name="cats[]" multiple="multiple">
                               <option value="0">Tamamı</option>
                               {% if cats is defined %}
                                   {% for cats in cats %}
                                       <option {% for voucher in meta_value['voucher_value']   %} {%if( voucher==cats.id ) %}  selected    {%endif%}   {% endfor %}
                                               value="{{ cats.id }}">{{ cats.name }}</option>
                                   {% endfor %}
                               {% endif %}
                           </select>
                       </div>
                       <div id="brand" {%if( meta_value['voucher_type']==4 ) %}  style="display: block;"   {%endif%}  style="display: none;">
                           <select class="selectpicker" data-live-search="true"id="aaa" name="brands[]" multiple="multiple">
                               <option value="0">Tamamı</option>

                               {% if brand is defined %}
                                   {% for brand in brand %}
                                       <option{% for voucher in meta_value['voucher_value']   %}
                                          {%if( voucher==brand.id ) %} selected {% endif %}
                                       {% endfor %}
                                       value="{{ brand.id }}">{{ brand.name }}</option>
                                   {% endfor %}
                               {% endif %}
                           </select>
                       </div>
                       <div id="user" {%if( meta_value['voucher_type']==5 ) %}  style="display: block;"   {%endif%}  style="display: none;">
                           <select class="selectpicker" data-live-search="true" name="user[]" multiple="multiple">
                               <option value="0">Tamamı</option>
                               {% if user is defined %}
                                   {% for user in user %}
                                       <option{% for voucher in meta_value['voucher_value']   %}
                                           {%if( voucher==user.id ) %} selected {% endif %}
                                               {% endfor %}
                                               value="{{ user.id }}">{{ user.email }}</option>
                                   {% endfor %}
                               {% endif %}
                           </select>
                       </div>
                   </div>
                </div>
            </div>
        </div>

        <div class="card card-custom gutter-b example example-compact">
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <a href="{{ url('backend/vouchers') }}" class="btn btn-secondary float-left">Vazgeç</a>
                        <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
    $(document).ready(function () {

        $('#vouchersForm').validate({
            rules: {
                voucher_code: "required",
                name: "required",
                maximum_usage: "required",
                start_date: "required",
                end_date: "required",
                discount: "required",
            },
            messages: {
                voucher_code: "Bu alanın doldurulması zorunludur!",
                name: "Bu alanın doldurulması zorunludur!",
                maximum_usage: "Bu alanın doldurulması zorunludur!",
                start_date: "Bu alanın doldurulması zorunludur!",
                end_date: "Bu alanın doldurulması zorunludur!",
                discount: "Bu alanın doldurulması zorunludur!",
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('#vouchersForm').serialize();

                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/vouchers/update") }}',
                    data: data,
                    success: function (response) {
                        const obj = jQuery.parseJSON(response);

                        if (obj.status === 'ok') {
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                            $('.photoCard').removeClass('dn');
                            $('.lastid').val(obj.id);
                            goTop();
                        } else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                            goTop();
                        }
                    }
                });
            }
        });

    });

</script>