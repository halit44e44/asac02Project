"use strict";

var run = function() {

    let apiUrl = api_url+'v2/get/currency';
    let url = base_url+'brand';

    var datatable = $('#data_currency').KTDatatable({
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
            input: $('#search_currency'),
            key: 'generalSearch'
        },

        columns: [
            {
                field: 'name',
                title: 'DÖVİZ KURU',
                width: 250,
                sortable: false,
                class: 'text-left pl-5',
                template: function(data) {
                    var number = KTUtil.getRandomInt(1, 14);
                    var user_img = '100_' + number + '.jpg';

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

                    const time = moment.unix(data.created_at);

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
									<span class="symbol-label font-size-h4 font-weight-bold">' + data.name.substring(0, 1) + '</span>\
								</div>\
								<div class="ml-4">\
									<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.name + '</div>\
									<a href="javascript:;" class="text-muted font-weight-bold text-hover-primary">' + time.format("DD.MM.YYYY HH:mm:ss") + '</a>\
								</div>\
							</div>';

                    return output;
                }
            },
            {
                field: 'unit',
                title: 'BİRİM',
                sortable: false,
                width: 50,
                type: 'number',
                selector: false,
                textAlign: 'center',
            },
            {
                field: 'forex_buying',
                title: 'ALIŞ',
                sortable: false,
                width: 70,
                selector: false,
                textAlign: 'center',
            },
            {
                field: 'forex_selling',
                title: 'SATIŞ',
                sortable: false,
                width: 70,
                selector: false,
                textAlign: 'center',
            },
            {
                field: 'Actions',
                title: 'İŞLEMLER',
                sortable: false,
                width: 125,
                class: 'float-right text-right mr-5',
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    return '\
                        <a href="javascript:;" data-title="'+row.name+'" onclick="showCurrency(this);" data-id="'+row.id+'" class="btn btn-sm btn-clean btn-icon"  title="Düzenle">\
                            <i class="fa fa-paint-brush text-warning"></i>\
                        </a>'
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



    $('#status_bank').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#status_bank').selectpicker();

    return {
        init: function() {
        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});
