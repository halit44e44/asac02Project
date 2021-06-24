"use strict";

var run = function () {

    let apiUrl = api_url + 'v2/get/refund';
    let url = base_url + 'refund';

    var datatable = $('#data_refund').KTDatatable({
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
                field: 'user_info',
                title: 'Adı Soyadı',
                sortable: false,
                width: 160,
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

                    let link = '<span href=\"' + url + '/index/' + data.user_info + '\" class=" font-weight-bolder font-size-lg mb-0">' + data.user_info + '</span><br>';
                    const time = moment.unix(data.created_at);

                    output = '<div class="d-flex align-items-center">\
								<div class="ml-4">' + link + ' <span class="text-muted font-weight-bold ">' + time.format("DD.MM.YYYY HH:mm:ss") + '</span>\
								</div>\
							</div>';

                    return output;
                }
            },
            {
                field: 'PaymenttypeText',
                title: 'ÖDEME TÜRÜ',
                width: 300,
                sortable: false,
                class: 'text-center',
                template: function (row) {
                    return '<span class="label label-lg font-weight-boldlabel-primary label-light-success label-inline">' + row.PaymenttypeText + '</span>';
                }
            },
            {
                field: 'code',
                title: 'TALEP KODU',
                class: 'text-center',
                sortable: false,
                template: function (row) {
                    return '<span class="label label-lg font-weight-boldlabel-primary label-light-success label-inline">' + row.code + '</span>';
                }
            },{
                field: 'total_order',
                title: 'TOPLAM TUTAR',
                class: 'text-center',
                sortable: false,
                width: 120,
                template: function (row) {

                    return '<span class="label label-lg font-weight-bold label-primary label-light-info label-inline">'+ row.total_order +' '+row.order_currency+ '</span>';

                }
            },{
                field: 'total_order',
                title: 'İADE TUTARI',
                class: 'text-center',
                sortable: false,
                width: 120,
                template: function (row) {

                    return '<span class="label label-lg font-weight-bold label-primary label-light-info label-inline">'+ row.refund_amount +' '+row.order_currency+ '</span>';

                }
            },{
                field: 'orderStatusinfo',
                title: 'TALEP DURUMU',
                sortable: false,
                template: function (row) {
                    return '<span class="label label-lg font-weight-boldlabel-primary label-light-success label-inline">' + row.orderStatusinfo + '</span>';
                }
            }, {
                field: 'order_date',
                title: 'SİPARİŞ TARİHİ',
                class: 'text-center',
                sortable: false,
                template: function (row) {
                    return unixtimeToTime(row.created_at);
                }
            }, {
                field: 'created_at',
                title: 'İADE TARİHİ',
                class: 'text-center',
                sortable: false,
                template: function (row) {
                    return unixtimeToTime(row.created_at);
                }
            },
            {
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 100,
                class: 'text-right',
                overflow: 'visible',
                autoHide: false,
                template: function (row) {

                    return '\
                        <a href="' + url + '/detail/' + row.id + '" class="btn btn-sm btn-clean btn-icon bg-light" title="İade/İptal Detayı">\
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


    $('#status_refund').selectpicker();
    $('#refundStatus').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });
    return {
        init: function () {
        },
    };
}();

jQuery(document).ready(function () {
    run.init();
});