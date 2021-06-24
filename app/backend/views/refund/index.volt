<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">İade ve İptal Talepleri
                <span class="d-block text-muted pt-2 font-size-sm">Satın alınan ürünlerin iade ve iptal talepleri.</span></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-12 col-xl-12">
                    <div class="row align-items-center">
                        <div class="col-md-3 my-2 my-md-0">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Ara..." id="search"/>
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sipariş Durumu</label>
                                <select class="form-control" id="refundStatus" name="refundStatus">
                                    <option value="">Tamamı</option>
                                    <option value="1">İade Talebi</option>
                                    <option value="2">Onaylanmış İade Talebi</option>
                                    <option value="3">Silinmiş İade Talebi</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="datatable datatable-bordered datatable-head-custom table table-head-custom table-head-bg table-borderless table-vertical-center"
             id="data_refund" data-table="refund"></div>
    </div>
</div>


