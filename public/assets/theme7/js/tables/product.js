"use strict";

var run = function() {

    let apiUrl = api_url+'v2/get/product';
    let url = base_url+'product';

    var datatable = $('#data_product').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: apiUrl,
                    map: function(raw) {
                        var dataSet = raw;
                        if (typeof raw.data !== 'undefined') {
                            dataSet = raw.data;
                        }
                        return dataSet;
                    },
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
        },

        layout: {
            scroll: false,
            footer: false,
        },

        sortable: true,
        pagination: true,
        search: {
            input: $('#search'),
            key: 'generalSearch',
        },

        columns: [
            {
                field: 'name',
                title: 'ÜRÜN İSMİ',
                width: 550,
                template: function(data) {

                    let image = site_url + 'media/resimyok.png';
                    const letter = '<span class="symbol-label font-size-h4 font-weight-bold">\' + data.name.substring(0, 1) + \'</span>';

                    let output = '';
                    const stateNo = KTUtil.getRandomInt(0, 7);
                    const states = [
                        'success',
                        'primary',
                        'danger',
                        'success',
                        'warning',
                        'dark',
                        'primary',
                        'info'];
                    const state = states[stateNo];

                    let link = '<a target="_blank" href=\"urun/'+data.sef+'\" class=" font-weight-bolder font-size-lg mb-0 text-primary">' + data.name + '</a><br>';

                    if (data.image !== null) {
                        image = site_url+'media/product/'+data.image;
                    }else{
                        image = site_url+'media/resimyok.png';
                    }

                    const popover = 'src="'+image+'" alt="'+data.name+'" data-toggle="tooltip" data-trigger="focus" data-content="<img src=\''+image+'\' width=\'150\' class=\'img-fluid\'>"';

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
								    <img class="showImage" '+popover+'>\
								</div>\
								<div class="ml-4">'+link+' <span class="text-muted font-weight-bold ">' + data.sef + '</span>\
								</div>\
							</div>';

                    return output;
                }
            },{
                field: 'unit',
                title: 'MİKTAR',
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.unit+' Adet</span>';
                }
            },{
                field: 'sale_price',
                title: 'FİYAT',
                sortable: false,
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.sale_price+' TL</span>';
                }
            },{
                field: 'status',
                sortable: false,
                width: 340,
                overflow: 'visible',
                title: 'İŞLEMLER',
                class: 'status text-right',
                template: function(row) {
                    const status = {
                        1: {
                            'title': 'Aktif',
                            'class': ' btn-light-success'
                        },
                        2: {
                            'title': 'Pasif',
                            'class': ' btn-light-danger'
                        },
                    };

                    const capign = {
                        2: {
                            'class': ' btn-light-success'
                        },
                        1: {
                            'class': ' btn-light-secondary text-light-dark'
                        },
                    };
                    $('.showImage').popover({
                        placement: 'bottom',
                        trigger: 'hover',
                        html: true
                    });

                    const icon_remove = '<span class="svg-icon"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-09-29-132851/theme/html/demo7/dist/../src/media/svg/icons/Tools/Axe.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect x="0" y="0" width="24" height="24"/> <path d="M15.2426407,15.8284271 L21.6066017,9.46446609 L23.0208153,10.8786797 L16.6568542,17.2426407 L15.2426407,15.8284271 Z M1.80761184,16.5355339 L11.7071068,6.63603897 C12.0976311,6.24551468 12.7307961,6.24551468 13.1213203,6.63603897 L14.5355339,8.05025253 C14.9260582,8.44077682 14.9260582,9.0739418 14.5355339,9.46446609 L4.63603897,19.363961 C4.24551468,19.7544853 3.6123497,19.7544853 3.22182541,19.363961 L1.80761184,17.9497475 C1.41708755,17.5592232 1.41708755,16.9260582 1.80761184,16.5355339 Z M15.9497475,3.80761184 L17.363961,5.22182541 C17.7544853,5.6123497 17.7544853,6.24551468 17.363961,6.63603897 L16.6568542,7.34314575 C16.26633,7.73367004 15.633165,7.73367004 15.2426407,7.34314575 L13.8284271,5.92893219 C13.4379028,5.5384079 13.4379028,4.90524292 13.8284271,4.51471863 L14.5355339,3.80761184 C14.9260582,3.41708755 15.5592232,3.41708755 15.9497475,3.80761184 Z" fill="#000000" opacity="0.3"/> <path d="M19.3284271,3.55025253 C16.9950938,4.88358587 15.3284271,5.55025253 14.3284271,5.55025253 C13.3284271,5.55025253 11.3284271,5.55025253 8.32842712,5.55025253 L8.32842712,10.5502525 C10.9950938,10.5502525 12.9950938,10.5502525 14.3284271,10.5502525 C15.6617605,10.5502525 17.3284271,11.2169192 19.3284271,12.5502525 L19.3284271,3.55025253 Z" fill="#000000" transform="translate(13.828427, 8.050253) rotate(-675.000000) translate(-13.828427, -8.050253) "/> </g> </svg><!--end::Svg Icon--></span>'
                    const icon_edit = '<span class="svg-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M15.9497475,3.80761184 L13.0246125,6.73274681 C12.2435639,7.51379539 12.2435639,8.78012535 13.0246125,9.56117394 L14.4388261,10.9753875 C15.2198746,11.7564361 16.4862046,11.7564361 17.2672532,10.9753875 L20.1923882,8.05025253 C20.7341101,10.0447871 20.2295941,12.2556873 18.674559,13.8107223 C16.8453326,15.6399488 14.1085592,16.0155296 11.8839934,14.9444337 L6.75735931,20.0710678 C5.97631073,20.8521164 4.70998077,20.8521164 3.92893219,20.0710678 C3.1478836,19.2900192 3.1478836,18.0236893 3.92893219,17.2426407 L9.05556629,12.1160066 C7.98447038,9.89144078 8.36005124,7.15466739 10.1892777,5.32544095 C11.7443127,3.77040588 13.9552129,3.26588995 15.9497475,3.80761184 Z" fill="#000000"/><path d="M16.6568542,5.92893219 L18.0710678,7.34314575 C18.4615921,7.73367004 18.4615921,8.36683502 18.0710678,8.75735931 L16.6913928,10.1370344 C16.3008685,10.5275587 15.6677035,10.5275587 15.2771792,10.1370344 L13.8629656,8.7228208 C13.4724413,8.33229651 13.4724413,7.69913153 13.8629656,7.30860724 L15.2426407,5.92893219 C15.633165,5.5384079 16.26633,5.5384079 16.6568542,5.92893219 Z" fill="#000000" opacity="0.3"/></g></svg></span>';

                    return '<a href="javascript:;" data-table="product" data-id="'+row.id+'" onclick="editItem(this)" title="Düzenle"> <span class="btn btn-sm font-weight-bold label-lg btn-light-info label-inline">'+icon_edit+' Düzenle</span> </a>' +
                        '<a data-id="'+row.id+'" data-table="product" data-tables="#data_product" onclick="status(this)"> <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>' +
                        '<a title="Yeni Fırsatlar" data-id="'+row.id+'" data-table="product" data-tables="#data_product" data-campaign="new_chance" onclick="changeCampaign(this)"> <span class="btn btn-sm font-weight-bold label-lg ' + capign[row.new_chance].class + ' label-inline">Y</span> </a>' +
                        '<a title="Günün Fırsatları" data-id="'+row.id+'" data-table="product" data-tables="#data_product" data-campaign="daily_chance" onclick="changeCampaign(this)"> <span class="btn btn-sm font-weight-bold label-lg ' + capign[row.daily_chance].class + ' label-inline">G</span> </a>' +
                        '<a title="Kaçırılmayacak Fırsatlar" data-id="'+row.id+'" data-table="product" data-tables="#data_product" data-campaign="unmissable_chance" onclick="changeCampaign(this)"> <span class="btn btn-sm font-weight-bold label-lg ' + capign[row.unmissable_chance].class + ' label-inline">K</span> </a>' +
                        '<a href="javascript:;" data-id="'+row.id+'" data-datatable="'+datatable+'" data-table="product" onclick="removeItem(this)" title="Kaldır"> <span class="btn btn-sm font-weight-bold label-lg btn-danger label-inline">'+icon_remove+' Kaldır</span> </a>';

                },
            },{
                field: 'id',
                title: 'Ürün ID',
                sortable: 'asc',
                width: 40,
                type: 'number',
                selector: false,
                textAlign: 'center',
            },{
                field: 'category',
                title: 'Kategori',
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.cat_name+'</span>';
                }
            },{
                field: 'brand',
                title: 'Marka',
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.brand_name+'</span>';
                }
            },{
                field: 'supplier',
                title: 'Tedarikçi',
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.supplier_name+'</span>';
                }
            },{
                field: 'stock_code',
                title: 'Stok Kodu',
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.stock_code+'</span>';
                }
            },{
                field: 'barcode',
                title: 'Barkod',
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.barcode+'</span>';
                }
            },{
                field: 'variant_id',
                title: 'Varyasyon',
                template: function (row) {
                    return '<span class="text-dark-75 d-block font-size-lg">'+row.variant_id+'</span>';
                }
            },{
                field: 'created_at',
                title: 'Oluşturma Tarihi',
                template: function (row) {
                    return unixtimeToTime(row.created_at);
                }
            },{
                field: 'updated_at',
                title: 'Güncelleme Tarihi',
                template: function (row) {
                    return unixtimeToTime(row.updated_at);
                }
            },],

        translate: {
            records: {
                processing: 'Lütfen bekleyin...',
                noRecords: 'Aradığınız kriterde bir içerik bulunamadı!',
            },
            toolbar: {
                pagination: {
                    items: {
                        info: 'Toplam {{total}} kayıttan {{start}} - {{end}} arası verileri görüyorsunuz.'
                    },
                },
            },
        },

    });

    $('#status_product').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#brand_id').on('change', function() {
        datatable.search($(this).val(), 'brand_id');
    });

    $('#supplier_id').on('change', function() {
        datatable.search($(this).val(), 'supplier_id');
    });

    $('#campaing_id').on('change', function() {
        const val = $(this).val();

        if (val === "new_chance") {
            datatable.search("2" ,  'new_chance');
        }

        if (val === "daily_chance") {
            datatable.search("2" , 'daily_chance');

        }
        if (val === "unmissable_chance") {
            datatable.search("2" , 'unmissable_chance');

        }

    });



    $('#status_product, #brand_id, #supplier_id, #campaing_id').selectpicker();

    return {
        init: function() {

        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});