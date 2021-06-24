"use strict";

var run = function () {
    let apiUrl = api_url + 'v2/get/integrationorder';
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
                field: 'buyer_name',
                title: 'ADI SOYADI',
                width: 120,
                template: function (data) {
                    return '<div class="d-flex align-items-center">\
								<div class="ml-4"><span>' + data.buyer_name + '</span><br>\
								</div>\
							</div>';
                }
            },{
                field: 'order_code',
                title: 'SİPARİŞ NUMARASI',
                width: 160,
                template: function (data) {
                    return '<div class="d-flex align-items-center">\
								<div class="ml-4"><span>#' + data.order_code + '</span><br>\
								</div>\
							</div>';
                }
            },{
                field: 'place',
                title: 'YER / BÖLGE',
                template: function (data) {
                    return '<div class="d-flex align-items-center">\
                    <a href="javascript:;" data-table="product" data-id="13" title="entegrasyon yeri">\
                    <span class="btn btn-sm font-weight-bold label-lg  btn-light-success label-inline">'+data.place+'</span></a>\
					</div>';
                }
            },{
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 100,
                class: 'text-right',
                overflow: 'visible',
                autoHide: false,
                template: function (row) {
                    return '\
                        <a href="' + base_url + 'integration/order/detail/' + row.id + '" class="btn btn-sm btn-clean btn-icon bg-light" title="Sipariş Detayı">\
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

    return {
        init: function () {
        },
    };
}();

jQuery(document).ready(function () {
    run.init();
});