<input type="hidden" id="users" value="{{ user.group_id }}">
<div class="card card-custom">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">Ürün Tabanlı Güncelleme</h3>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a class="nav-link kategori_tabanli_guncelleme"
                       href="{{ url('backend/productbulk/categoryupdate/') }}">Ketegori Tabanlı Güncelleme</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active urun_tabanli_guncelleme"
                       href="{{ url('backend/productbulk/productupdate/') }}">Ürün Tabanlı Güncelleme</a>
                </li>
            </ul>
        </div>
    </div>


    <div class="card-body">
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-12 col-xl-12">
                    <div class="row align-items-center">
                        <div class="col-md-4 my-2 my-md-0">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Ara..." id="search"/>
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Durum</label>
                                <select class="form-control" id="status_product">
                                    <option value="">Tamamı</option>
                                    <option value="1">Aktif</option>
                                    <option value="2">Pasif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Markalar</label>
                                <select class="form-control" id="brand_id" name="brand_id">
                                    <option value="">Tamamı</option>
                                    {% if brands is defined %}
                                        {% for brand in brands %}
                                            <option value="{{ brand.id }}">{{ brand.name }}</option>
                                        {% endfor %}
                                    {% endif %}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="datatable datatable-bordered datatable-head-custom table table-head-custom table-head-bg table-borderless table-vertical-center" id="data_productbulk" data-table="productbulk"></div>

    </div>
</div>
<script>
    var currency_list = '{% if currency_list is defined %}{% for currency in currency_list %}{% if loop.first %}<option value="{{ loop.index }}" selected>{{ currency }}</option>{% else %}<option value="{{ loop.index }}">{{ currency }}</option>{% endif %}{% endfor %}{% endif %}';

    $(document).ready(function () {

    });
</script>