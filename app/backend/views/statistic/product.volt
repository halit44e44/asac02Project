<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                En çok sipariş verilen ürünler
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-lg-12 col-xl-12">
                    <div class="row align-items-center">
                        <div class="col-md-5 my-2 my-md-0">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Ara..." id="search" />
                                <span>
                                    <i class="flaticon2-search-1 text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="datatable datatable-bordered datatable-head-custom table table-head-custom table-head-bg table-borderless table-vertical-center" id="data_statistic" data-table="content" data-id="{% if id is defined%}{{ id }}{% else %}0{% endif %}"></div>
    </div>
</div>
