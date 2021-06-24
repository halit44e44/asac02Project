"use strict";

var run = function () {
    const top_id = $('.datatable').data('topid');
    let apiUrl = api_url + 'v2/get/order';
    let url = base_url + 'order';
    if (top_id > 0) {
        apiUrl = api_url+'v2/get/order/'+top_id;
        url = base_url+'order';
        $('.list-title span').addClass('dn');
        $('ul.breadcrumb').removeClass('dn');
    }
    var datatable = $('#data_order').KTDatatable({
        data: {
            type: 'remote',

            source: {
                read: {
                    url: apiUrl,
                    map: function (raw) {
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
            key: 'generalSearch'
        },

        columns: [
            {
                field: 'id',
                title: '#',
                sortable: 'asc',
                width: 40,
                type: 'number',
                selector: false,
                textAlign: 'center',
            }, {
                field: 'name',
                title: 'ADI SOYADI',
                width: 300,
                template: function (data) {

                    var output = '';
                    var stateNo = KTUtil.getRandomInt(0, 7);
                    var states = [
                        'success',
                        'primary',
                        'danger',
                        'success',
                        'warning',
                        'dark',
                        'primary',
                        'info'];
                    var state = states[stateNo];

                    let link = '<span class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.name + '</span><br>';
                    if (data.total_subcat !== 0) {
                        link = '<a href=\"'+url+'/index/'+data.id+'\" class=" font-weight-bolder font-size-lg mb-0 text-primary">' + data.name + '</a><span class="label label-light-'+state+' ml-2">'+data.total_subcat+'</span><br>';
                    }
                    const time = moment.unix(data.created_at);

                    output = '<div class="d-flex align-items-center">\
								<div class="ml-4">' + link + ' <span class="text-muted font-weight-bold ">' + time.format("DD/MM/YYYY HH:mm:ss") + '</span>\
								</div>\
							</div>';

                    return output;
                }
            },
            {
                field: 'payment_type',
                title: 'ÖDEME TÜRÜ',
                class: 'text-center',
                width: 150,
                template: function (row) {

                    const ptype = {
                        1: {
                            'class': ' label-color1'
                        },
                        2: {
                            'class': ' label-color2'
                        },
                        3: {
                            'class': ' label-color3'
                        },
                        4: {
                            'class': ' label-color4'
                        },
                        5: {
                            'class': ' label-color5'
                        },
                        6: {
                            'class': ' label-color6'
                        },
                    };


                    return '<span class="label label-lg font-weight-boldest label-primary label-inline label-payment ' + ptype[row.payment_type].class + '">' + row.payment_type_text + '</span>';
                }
            },
            {
                field: 'gift_package',
                width: 100,
                class: 'text-center',
                title: 'HEDİYE PAKETİ',
                template: function (row) {
                    var status = {
                        1: {
                            'title': 'Evet',
                            'class': ' btn-light-success'
                        },
                        2: {
                            'title': 'Hayır',
                            'class': ' btn-light-danger'
                        },
                    };
                    return ' <a data-id="' + row.id + '" data-table="order" data-tables="#data_order"  <span class="text-muted font-weight-bold  ' + status[row.gift_package].class + ' label-inline">' + status[row.gift_package].title + '</span> </a>';
                },

            },{
                field: 'total_price',
                title: 'TUTAR',
                class: 'text-center',
                width: 120,
                template: function (row) {
                    if (top_id > 0) {
                        return '<span class="label label-lg font-weight-bold label-primary label-light-info label-inline">' + row.total_price + " " + row.products.currency + '</span>';
                    }
                    else {
                        return '<span class="label label-lg font-weight-bold label-primary label-light-info label-inline">' + row.total_price + " " + row.currency_kur + '</span>';
                    }
                }
            }, {
                field: 'order_status',
                title: 'durum',
                class: 'text-center',
                overflow: 'visible',
                width: 255,
                template: function (row) {

                        return   '<select onchange="orderstatus2(this)" data-id="'+row.id+'" \n'  +
                            '        class="form-control font-size-lg font-weight-bold" id="'+row.id+'"\n' +
                            '        name="orderStatus">\n' +
                            '            <option value="1">Sipariş Alındı</option>\n' +
                            '            <option value="2">Onay Bekliyor</option>\n' +
                            '            <option value="3">Onaylandı</option>\n' +
                            '            <option value="4">Ödeme Bekliyor</option>\n' +
                            '            <option value="5">Hazırlanıyor</option>\n' +
                            '            <option value="6">Tedarik Sürecinde</option>\n' +
                            '            <option value="7">Kargoya Verildi</option>\n' +
                            '            <option value="8">Teslim Edildi</option>\n' +
                            '            <option value="9">İptal Edildi</option>\n' +
                            '            <option value="10">İade Edildi</option>\n' +
                            '            <option value="11">Silindi</option>\n' +
                            '            <option value="12">İade Talebi Alındı</option>\n' +
                            '            <option value="13">İade Ulaştı Ödeme Bekleniyor</option>\n' +
                            '            <option value="14">İade Ödemesi Yapıldı</option>\n' +
                            '            <option value="15">Teslimat Öncesi İptal Talebi</option>\n' +
                            '            <option value="16">İptal Talebi</option>\n' +
                            '            <option value="17">Teslim Edildi</option>\n' +
                            '            <option value="18">İade Talebi İptal Edildi</option>\n' +
                            '            <option value="19">İade Talebi Onaylandı</option>\n' +
                            '</select>';





                }  },
            {
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 100,
                class: 'text-right',
                overflow: 'visible',
                autoHide: false,
                template: function (row) {
                    document.getElementById(row.id).value =row.order_status;
                    return '\
                        <a href="' + url + '/detail/' + row.id + '" class="btn btn-sm btn-clean btn-icon bg-light" title="Sipariş Detayı">\
                           <i class="fa fa-info text-primary"></i>\
                        </a>';

                },
            }],
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


    $('#status_order').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#product').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'id');
    });

/*
    $('.order_status').on('change', function () {
        const id = this.val();
    });
*/
    $('#Paymenttype').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'payment_type');
    });

    $('#orderStatus').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'order_status');
    });

    $('#byCargo').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'cargo_type');
    });


    $('#gift_package').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'gift_package');
    });

    $('#gift_package, #orderStatus, #Paymenttype, #byCargo').selectpicker();

    return {
        init: function () {
        },
    };
}();
function orderstatus2(el) {
    const id = $(el).data('id');
    var e = document.getElementById(id);
    var status = e.options[e.selectedIndex].value;
    $.ajax(base_url + 'order/do/' + id + '/' + status, function (data) {

    });
}
jQuery(document).ready(function () {
    run.init();
});


