<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Siparişler
                <span class="d-block text-muted pt-2 font-size-sm">Tüm siparişlerinizi bu ekrandan takip edin.</span></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-12 col-xl-12">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Ara..." id="search"/>
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Hediye Paketi</label>
                                <select class="form-control" id="gift_package" name="gift_package">
                                    <option value="">Tamamı</option>
                                    <option value="1">Evet</option>
                                    <option value="2">Hayır</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sipariş Durumu</label>
                                <select class="form-control" id="orderStatus" name="orderStatus">
                                    <option value="">Tamamı</option>
                                    {% if orderStatus is defined %}
                                        {% for types in orderStatus %}
                                            <option value="{{ types.id }}">{{ types.name }}</option>
                                        {% endfor %}
                                    {% endif %}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ödeme Tipi</label>
                                <select class="form-control" id="Paymenttype" name="Paymenttype">
                                    <option value="">Tamamı</option>
                                    {% if Paymenttype is defined %}
                                        {% for types in Paymenttype %}
                                            <option value="{{ types.id }}">{{ types.name }}</option>
                                        {% endfor %}
                                    {% endif %}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Kargo</label>
                                <select class="form-control" id="byCargo" name="byCargo">
                                    <option value="">Tamamı</option>
                                    {% if byCargo is defined %}
                                        {% for byCargo in byCargo %}
                                            <option value="{{ byCargo.id }}">{{ byCargo.name }}</option>
                                        {% endfor %}
                                    {% endif %}
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="datatable datatable-bordered datatable-head-custom table table-head-custom table-head-bg table-borderless table-vertical-center"
             id="data_order" data-table="order"
             data-topid="{% if top_id is defined %}{{ top_id }}{% else %}0{% endif %}"></div>
    </div>
</div>
{% if id is defined %}
    <input value="{{ id }}" hidden id="order">
    <script>
        id = document.getElementById("order").value;
        jQuery(document).ready(function () {
            showOrderSeen(id);
        });
    </script>
{% endif %}

