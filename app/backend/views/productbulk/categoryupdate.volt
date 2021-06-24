<input type="hidden" id="users" value="{{ user.group_id }}">
<form id="categoryupdateForm" method="post" autocomplete="off">
    <div class="card card-custom mb-10">
        <div class="card-header card-header-tabs-line">
            <div class="card-title">
                <h3 class="card-label">Filtreler<span class="d-block text-muted pt-2 font-size-sm">Lütfen önce filtre ayarlarını tamamlayınız.</span></h3>
            </div>
            <div class="card-toolbar">
                <ul class="nav nav-dark nav-bold nav-tabs nav-tabs-line" data-remember-tab="tab_id" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active kategori_tabanli_guncelleme" href="{{ url('backend/productbulk/categoryupdate/') }}">Ketegori Tabanlı Güncelleme</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link urun_tabanli_guncelleme" href="{{ url('backend/productbulk/productupdate/') }}">Ürün Tabanlı Güncelleme</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="alert alert-secondary rounded-0 dn" role="alert"></div>
        <div class="card-body">
            <div class="tab-pane" id="categoryupdate" role="tabpanel">
                <form id="categoryupdateForm" method="post"  autocomplete="off">
                    <input type="hidden" name="param" value="categoryupdate" />
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right">Kategori:</label>
                        <div class="col-lg-9 col-xl-4">
                            <input class="form-control" type="text" id="catPicker" placeholder="Kategori seç" autocomplete="off" />
                        </div>
                        <input type="text" id="cat_id" name="cat_id" hidden>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right">Marka:</label>
                        <div class="col-lg-9 col-xl-4">
                            <select class="form-control" name="brand">
                                <option value="">Tümü</option>
                                {% if brands is defined %}
                                {% for brand in brands %}
                                <option value="{{ brand.id }}">{{ brand.name }}</option>
                                {% endfor %}
                                {% endif %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right">Fiyat: (Satış fiyatına göre)</label>
                        <div class="col-lg-9 col-xl-1">
                            <input type="text" name="price_start" class="form-control form-control-solid" value="0">
                        </div>
                        <div class="col-lg-9 col-xl-1">
                            <input type="text" name="price_end" class="form-control form-control-solid" value="0">
                        </div>
                        <div class="col-lg-9 col-xl-2">
                            <select class="form-control" name="currency">
                                {% if currency_list is defined %}
                                {% for currency in currency_list %}
                                {% if loop.first %}
                                <option value="{{ loop.index }}" selected>{{ currency }}</option>
                                {% else %}
                                <option value="{{ loop.index }}">{{ currency }}</option>
                                {% endif %}
                                {% endfor %}
                                {% endif %}
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label text-lg-right">Ürün Durumuna Göre:</label>
                        <div class="col-lg-9 col-xl-4">
                        <select class="form-control" name="status">
                            <option value="">Seçiniz</option>
                            <option value="1">Aktif Ürünler</option>
                            <option value="2">Pasif Ürünler</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card card-custom mb-10">
        <div class="card-header">
            <div class="card-title">
            <h3 class="card-label">Değerler<span class="d-block text-muted pt-2 font-size-sm">Fiyat işlemlerini aşağıdaki alandan yapınız.</span></h3>
        </div>
    </div>
        
    <div class="card-body">
        <div class="form-group row">
            <div class="col-lg-2 float-right">
                <label class="checkbox checkbox-lg col-form-label float-right">
                    <input type="checkbox" name="guncelle" value="quantity">
                    <span></span>
                </label>
            </div>
        
            <label class="col-lg-2 col-form-label text-lg-right">Stok Adedi:</label>
        
            <div class="col-lg-9 col-xl-1">
                <input type="text" name="quantity" class="form-control form-control-solid" value="0">
            </div>

            <div class="col-lg-9 col-xl-2">
                <select class="form-control" name="operations">
                    <option value="1">Arttır</option>
                    <option value="2">Azalt</option>
                    <option value="3">Eşittir</option>
                </select>
            </div>
        </div>
        
        <div class="form-group row">
            <div class="col-lg-2 float-right">
                <label class="checkbox checkbox-lg col-form-label float-right">
                    <input type="checkbox" name="guncelle" value="kdv">
                    <span></span>
                </label>
            </div>

            <label class="col-lg-2 col-form-label text-lg-right">KDV:</label>
            
            <div class="col-lg-9 col-xl-2">
                <input type="text" name="kdv" class="form-control form-control-solid" value="18">
            </div>

            <label>%</label>
        </div>

        <div class="form-group row">
            <div class="col-lg-2 float-right">
                <label class="checkbox checkbox-lg col-form-label float-right">
                    <input type="checkbox" name="guncelle" value="cargo">
                    <span></span>
                </label>
            </div>

            <label class="col-lg-2 col-form-label text-lg-right">Kargo Kullanımı:</label>

            <div class="col-lg-9 col-xl-2 col-form-label">
                <div class="radio-inline">
                    <label class="radio radio-success">
                        <input type="radio" name="cargo_status" value="enable"/>
                        <span></span>
                        Evet
                    </label>

                    <label class="radio radio-success">
                        <input type="radio" name="cargo_status" value="disable"/>
                        <span></span>
                        Hayır
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-2 float-right">
                <label class="checkbox checkbox-lg col-form-label float-right">
                    <input type="checkbox" name="guncelle" value="product">
                    <span></span>
                </label>
            </div>

            <label class="col-lg-2 col-form-label text-lg-right">Ürün Durumu:</label>

            <div class="col-lg-9 col-xl-2 col-form-label">
                <div class="radio-inline">
                    <label class="radio radio-success">
                        <input type="radio" name="product_status" value="enable"/>
                        <span></span>
                        Evet
                    </label>

                    <label class="radio radio-success">
                        <input type="radio" name="product_status" value="disable"/>
                        <span></span>
                        Hayır
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-2 float-right">
                <label class="checkbox checkbox-lg col-form-label float-right">
                    <input class="" type="checkbox" name="guncelle" value="price">
                    <span></span>
                </label>
            </div>

            <label class="col-lg-2 col-form-label text-lg-right">Ürün Fiyatı:</label>

            <div class="col-lg-9 col-xl-3">
                <select class="form-control" name="price_kind">
                    <option value="1">Ürün Satış Fiyatı</option>
                    <option value="2">Ürün Alış Fiyatı</option>
                </select>
            </div>

            <div class="col-lg-9 col-xl-2">
                <select class="form-control" name="price_operations">
                    <option value="1">Çarp</option>
                    <option value="2">Eşit</option>
                    <option value="3">Arttır</option>
                    <option value="4">Azalt</option>
                </select>
            </div>

            <div class="col-lg-9 col-xl-1">
                <input type="text" name="price_operations_value" class="form-control form-control-solid" value="">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 text-right">
                <button type="button" id="submit" class="btn btn-success btn-xl">Güncelle</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        const categoryPicker = $('#catPicker').comboTree({
            source: {{ catList }},
            cascadeSelect: true,
            collapse: false
        });

        //Sadece bir tane checkbox'ın işaretli olması için
        $('input[type=checkbox]').click(function () {
            console.log($(this));
            $("input[type=checkbox]").prop("checked", false);
            $(this).prop("checked", true);
        });

        $('#submit').on('click', function () {
            $("#cat_id").val(categoryPicker.getSelectedIds());
            const data = $('#categoryupdateForm').serialize();
            const user=$('#users').val();
            if (user === "3") {
                Swal.fire("Hata!", "Düzenleme yetkiniz bulunmamaktadır!", "warning");
                return false;
            }else {
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/productbulk/categoryupdate/") }}',
                    data: data,
                    success: function (response) {
                        const obj = jQuery.parseJSON(response);

                        if (obj.status === 'ok') {
                            $("#submitBtn").prop('disabled', true);
                            $('.alert').removeClass('dn').removeClass('alert-danger').addClass('alert-secondary').html('İşlem başarılı bir şekilde tamamlandı!');
                            goTop();
                        }else {
                            $('.alert').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                            goTop();
                        }
                    }
                });
            }

        });

    });
</script>