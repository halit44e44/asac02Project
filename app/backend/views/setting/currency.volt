<div class="card card-custom">
    <div class="card-header card-header-tabs-line">
        <div class="card-title">
            <h3 class="card-label">Döviz Kurları
                <span class="d-block text-muted pt-2 font-size-sm">Merkez bankasından alınan kur bilgileri.</span>
            </h3>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line">
                <li class="nav-item">
                    <a href="javascript:;" id="updateCurrency" class="btn btn-primary font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M8.43296491,7.17429118 L9.40782327,7.85689436 C9.49616631,7.91875282 9.56214077,8.00751728 9.5959027,8.10994332 C9.68235021,8.37220548 9.53982427,8.65489052 9.27756211,8.74133803 L5.89079566,9.85769242 C5.84469033,9.87288977 5.79661753,9.8812917 5.74809064,9.88263369 C5.4720538,9.8902674 5.24209339,9.67268366 5.23445968,9.39664682 L5.13610134,5.83998177 C5.13313425,5.73269078 5.16477113,5.62729274 5.22633424,5.53937151 C5.384723,5.31316892 5.69649589,5.25819495 5.92269848,5.4165837 L6.72910242,5.98123382 C8.16546398,4.72182424 10.0239806,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 C7.581722,20 4,16.418278 4,12 L6,12 C6,15.3137085 8.6862915,18 12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C10.6885336,6 9.44767246,6.42282109 8.43296491,7.17429118 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
                            </svg>
                        </span>Yenile
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="alert alert-secondary rounded-0 dn currencyList" role="alert"></div>

    <div class="card-body">
        <div class="tab-content">
            <div class="card-body">
                <div class="mb-7">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-4 my-2 my-md-0">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" placeholder="Ara..." id="search_currency" />
                                        <span>
                                            <i class="flaticon2-search-1 text-muted"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <div class="datatable datatable-bordered datatable-head-custom table table-head-custom table-head-bg table-borderless table-vertical-center" id="data_currency" data-table="content" ></div>

        </div>

    </div>
</div></div>
<div class="modal fade currencyModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <form method="post" class="currencyPost">
        <input type="hidden" name="id" class="id">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="alert alert-secondary rounded-0 alertCurrencyModal dn" role="alert"></div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    <button type="submit"  class="btn btn-primary">Kaydet</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {

        $('#updateCurrency').click(function () {
            $('.alert').addClass('dn');
            $.get('{{ url('api/currency') }}', function (response) {
                if (response === 'ok') {
                    $('.currencyList').removeClass('dn').html('Güncelleme işlemi başarılı!');
                    const datatable = $('.datatable').KTDatatable();
                    datatable.reload();
                }
            });
        });

        $('.currencyPost').validate({
            rules: {
                buy: "required",
                sell: "required"
            },
            messages: {
                buy: "Bu alan zorunludur!",
                sell: "Bu alan zorunludur!"
            },
            submitHandler: function () {
                $('.alert').addClass('dn');
                const data = $('.currencyPost').serialize();
                $.ajax({
                    type: 'post',
                    url: '{{ url("backend/setting/getcurrency/") }}',
                    data: data,
                    success: function (response) {
                        if (response === 'ok') {
                            $('.currencyModal').modal('hide');
                            const datatable = $('.datatable').KTDatatable();
                            datatable.reload();
                        } else {
                            $('.alertCurrencyModal').removeClass('dn').removeClass('alert-secondary').addClass('alert-danger').html('Bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!');
                        }
                    }
                });
            }
        });

    });
</script>