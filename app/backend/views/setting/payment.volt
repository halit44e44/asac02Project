<form method="post" class="form" id="paymentForm">
    <input type="hidden" id="id" name="id" class="form-control" value="{% if id is defined %}{{id}}{% endif %}" />
    <div class="card card-custom">

        <div class="card-header card-header-tabs-line">
            <div class="card-title">
                <h3 class="card-label">Ödeme Sistemi Genel Ayarlar</h3>
            </div>
        </div>

        <div class="alert alert-secondary rounded-0 dn" role="alert"></div>

        <div class="card-body">
            <div class="tab-content">

                <div class="form-group row">
                    <div class="col-lg-12">
                        <label class="font-weight-bold">Banka Adı:</label>
                        <input type="text" id="name" name="name"  class="form-control"  value="{% if virtual.name is defined %}{{ virtual.name}}{% endif %}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="font-weight-bold">Mağaza No</label>
                        <input type="text" id="shop_no" name="shop_no"  class="form-control" value="{% if meta_value['shop_no'] is defined %} {{ meta_value['shop_no']}}{% endif %}"/>
                    </div>

                    <div class="col-lg-6">
                        <label class="font-weight-bold">API Kullanıcısı</label>
                        <input type="text" id="api_user" name="api_user" class="form-control"  value="{% if meta_value['api_user'] is defined %}{{ meta_value['api_user']}}{% endif %}"/>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="font-weight-bold">3D Secure Kullan</label>
                        <select class="form-control form-control-solid form-control-lg" name="3d_secure">
                            <option {% if meta_value['3d_secure'] is defined %}  {% if meta_value['3d_secure']==1  %} selected {% endif %} {% endif %} value="1">3D Secure Kullan</option>
                            <option {% if meta_value['3d_secure'] is defined %}  {% if meta_value['3d_secure']==2  %} selected {% endif %} {% endif %}value="2">3D Secure Kullanma</option>
                            <option {% if meta_value['3d_secure'] is defined %}  {% if meta_value['3d_secure']==3  %} selected {% endif %} {% endif %} value="3">Müşteriye Sor</option>
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <label class="font-weight-bold">3D Secure İşyeri Anahtarı</label>
                        <input text="text" id="treed_secure_key" name="treed_secure_key" class="form-control"value="{% if meta_value['3d_secure_key'] is defined %}{{ meta_value['3d_secure_key']}}{% endif %}"  />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="font-weight-bold">Otorizasyon Tipi</label>
                        <select class="form-control form-control-solid form-control-lg" name="license">
                            <option {% if meta_value['license'] is defined %}  {% if meta_value['license']==1  %} selected {% endif %} {% endif %}  value="1">Normal Otorizasyon</option>
                            <option{% if meta_value['license'] is defined %}  {% if meta_value['license']==2  %} selected {% endif %} {% endif %}  value="2">Ön Otorizasyon</option>
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <label class="font-weight-bold">Bonus Kullanımı</label>
                        <select class="form-control form-control-solid form-control-lg" name="bonus">
                            <option{% if meta_value['bonus'] is defined %}  {% if meta_value['bonus']==1  %} selected {% endif %} {% endif %} value="1">Açık</option>
                            <option {% if meta_value['bonus'] is defined %}  {% if meta_value['bonus']==2  %} selected {% endif %} {% endif %}value="2">Kapalı</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="font-weight-bold"> Minimum Taksit Tutarı</label>
                        <input text="number" id="min_installment" name="min_installment" class="form-control"  value="{% if meta_value['min_installment'] is defined %}{{ meta_value['min_installment']  }}{% endif %}"   />
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card card-custom">

        <div class="card-header card-header-tabs-line">
            <div class="card-title">
                <h3 class="card-label">Oranlar</h3>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group row">

                <div class="col-lg-1">
                    <label class="font-weight-bold">1</label>
                    <input text="number" id="1" name="1" class="form-control"     value="{% if rate['1'] is defined %}{{ rate["1"]  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">2</label>
                    <input text="number" id="2" name="2" class="form-control"  value="{% if rate['2'] is defined %}{{ rate['2']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">3</label>
                    <input text="number" id="3" name="3" class="form-control"  value=" {% if rate['3'] is defined %}{{ rate['3']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">4</label>
                    <input text="number" id="4" name="4" class="form-control"     value="{% if rate['4'] is defined %}{{ rate['4']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">5</label>
                    <input text="number" id="5" name="5" class="form-control"    value="{% if rate['5'] is defined %}{{ rate['5']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">6</label>
                    <input text="number" id="6" name="6" class="form-control"    value="{% if rate['6'] is defined %}{{ rate['6']  }}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">7</label>
                    <input text="number" id="7" name="7" class="form-control"     value="{% if rate['7'] is defined %}{{ rate['7']  }}{% endif %}"   />

                </div>

                <div class="col-lg-1">
                    <label class="font-weight-bold">8</label>
                    <input text="number" id="8" name="8" class="form-control"     value="{% if rate['8'] is defined %}{{ rate['8']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">9</label>
                    <input text="number" id="9" name="9" class="form-control"    value="{% if rate['9'] is defined %}{{ rate['9']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">10</label>
                    <input text="number" id="10" name="10" class="form-control"    value="{% if rate['10'] is defined %}{{ rate['10']  }}{% endif %}"  />

                </div><div class="col-lg-1">
                    <label class="font-weight-bold">11</label>
                    <input text="number" id="11" name="11" class="form-control"    value="{% if rate['11'] is defined %}{{ rate['11']  }}{% endif %}"   />

                </div><div class="col-lg-1">
                    <label class="font-weight-bold">12</label>
                    <input text="number" id="12" name="12" class="form-control"   value="{% if rate['12'] is defined %}{{ rate['12']  }}{% endif %}"  />

                </div>
            </div>
            <div class="form-group row">

                <div class="col-lg-1">
                    <label class="font-weight-bold">13</label>
                    <input text="number" id="13" name="13" class="form-control"     value="{% if rate['13'] is defined %}{{ rate['13']  }}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">14</label>
                    <input text="number" id="14" name="14" class="form-control"     value="{% if rate['14'] is defined %}{{ rate['14']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">15</label>
                    <input text="number" id="15" name="15" class="form-control"    value="{% if rate['15'] is defined %}{{ rate['15']  }}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">16</label>
                    <input text="number" id="16" name="16" class="form-control"     value="{% if rate['16'] is defined %}{{ rate['16']  }}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">17</label>
                    <input text="number" id="17" name="17" class="form-control"   value="{% if rate['17'] is defined %}{{rate['17']}} {% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">18</label>
                    <input text="number" id="18" name="18" class="form-control"     value="{% if rate['18'] is defined %}{{ rate['18']}}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">19</label>
                    <input text="number" id="19" name="19" class="form-control"     value="{% if rate['19'] is defined %}{{ rate['19']}}{% endif %}"  />

                </div>

                <div class="col-lg-1">
                    <label class="font-weight-bold">20</label>
                    <input text="number" id="20" name="20" class="form-control"    value="{% if rate['20'] is defined %}{{ rate['20']}}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">21</label>
                    <input text="number" id="21" name="21" class="form-control"     value="{% if rate['21'] is defined %}{{ rate['21']}}{% endif %}"   />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">22</label>
                    <input text="number" id="22" name="22" class="form-control"     value="{% if rate['22'] is defined %}{{rate['22']}}{% endif %}"  />

                </div><div class="col-lg-1">
                    <label class="font-weight-bold">23</label>
                    <input text="number" id="23" name="23" class="form-control"     value="{% if rate['23'] is defined %}{{rate['23']}}{% endif %}"  />

                </div><div class="col-lg-1">
                    <label class="font-weight-bold">24</label>
                    <input text="number" id="24" name="24" class="form-control"    value="{% if rate['24'] is defined %}{{rate['24']}}{% endif %}" />

                </div>
            </div>
            <div class="form-group row">

                <div class="col-lg-1">
                    <label class="font-weight-bold">25</label>
                    <input text="number" id="25" name="25" class="form-control"    value="{% if rate['25'] is defined %}{{ rate['25']  }}{% endif %}" />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">26</label>
                    <input text="number" id="26" name="26" class="form-control"    value="{% if rate['26'] is defined %}{{ rate['26']  }}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">27</label>
                    <input text="number" id="27" name="27" class="form-control"    value="{% if rate['27'] is defined %}{{ rate['27']  }}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">28</label>
                    <input text="number" id="28" name="28" class="form-control"    value="{% if rate['28'] is defined %}{{ rate['28']  }}{% endif %}" />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">29</label>
                    <input text="number" id="29" name="29" class="form-control"   value="{% if rate['29'] is defined %}{{ rate['29']  }}{% endif %}" />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">30</label>
                    <input text="number" id="30" name="30" class="form-control" value="{% if rate['30'] is defined %}{{ rate['31']  }}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">31</label>
                    <input text="number" id="31" name="31" class="form-control"    value="{% if rate['31'] is defined %}{{ rate['31']  }}{% endif %}" />

                </div>

                <div class="col-lg-1">
                    <label class="font-weight-bold">32</label>
                    <input text="number" id="32" name="32" class="form-control"    value="{% if rate['32'] is defined %}{{ rate['32']  }}{% endif %}"  />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">33</label>
                    <input text="number" id="33" name="33" class="form-control"     value="{% if rate['33'] is defined %}{{ rate['33']  }}{% endif %}" />

                </div>
                <div class="col-lg-1">
                    <label class="font-weight-bold">34</label>
                    <input text="number" id="34" name="34" class="form-control"     value="{% if rate['34'] is defined %}{{ rate['34']  }}{% endif %}" />

                </div><div class="col-lg-1">
                    <label class="font-weight-bold">35</label>
                    <input text="number" id="35" name="35" class="form-control"    value="{% if rate['35'] is defined %}{{ rate['35']  }}{% endif %}"  />

                </div><div class="col-lg-1">
                    <label class="font-weight-bold">36</label>
                    <input text="number" id="36" name="36" class="form-control"  value="{% if rate['36'] is defined %}{{rate['36']  }}{% endif %}"  />

                </div>
            </div>
        </div>

    </div>
    <div class="card card-custom">

        <div class="card-header card-header-tabs-line">
            <div class="card-title">
                <h3 class="card-label">Taksit Seçenekleri</h3>
            </div>
        </div>

        <div class="card-body">
            <div class="tab-content">

                <div class="form-group row">
                    <div class="col-lg-2">
                        <input type="text" id="min_sum" name="min_sum" class="form-control"  value="{% if meta_value['min_sum'] is defined %}{{ meta_value['min_sum']}}{% endif %}" />
                    </div>
                    <div class="col-lg-2">
                        <p class="font-weight-bolder mt-3" id="comment_total">Tl ve üzeri Alışveriş</p>
                    </div>

                    <div class="col-lg-1">
                        <input type="text" id="first" name="first"  class="form-control"    value="{% if meta_value['first'] is defined %}{{ meta_value['first']}}{% endif %}"/>
                    </div>
                    <div class="col-lg-1">
                        <label class="font-weight-bolder mt-3 col-lg-2" id="comment_total">-</label>
                    </div>

                    <div class="col-lg-1">
                        <input type="text" id="last" name="last"  class="form-control"   value="{% if meta_value['last'] is defined %}{{ meta_value['last']}}{% endif %}"  />
                    </div>

                    <div class="col-lg-1">
                        <label class="font-weight-bolder mt-3" id="comment_total">Taksit</label>
                    </div>

                    <div class="col-lg-1">
                        <input type="text" id="installment" name="installment"  class="form-control"   value="{% if meta_value['installment'] is defined %}{{ meta_value['installment']}}{% endif %}"/>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
            </div>
        </div>

    </div>
</form>

<script>
$(document).ready(function() {

    $('#paymentForm').validate({
        rules: {
            name: "required",
            shop_no: "required",
            api_user:"required",
            treed_secure_key:"required",
        },
        messages: {
            name: "Bu alan zorunludur!",
            shop_no: "Bu alan zorunludur!",
            api_user: "Bu alan zorunludur!",
            treed_secure_key: "Bu alan zorunludur!",
        },
        submitHandler: function () {
            $('.alert').addClass('dn');
            const data = $('#paymentForm').serialize();

            $.ajax({

                type: 'post',
                url: '{{ url("backend/setting/payment/") }}',
                data: data,
                success: function (response) {
                    const obj = jQuery.parseJSON(response);
                    if (obj.status === true) {
                        $('.alert').removeClass('dn').html('İşlem başarılı bir şekilde tamamlandı!');
                        goTop();
                    } else if(obj.status === false) {
                        $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                    }
                }
            });
        }
    });
});
</script>