"use strict";

var run = function() {

    let apiUrl = api_url+'v2/get/request';
    let url = base_url+'product';

    var datatable = $('#data_request').KTDatatable({
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
            },{
                field: 'product',
                title: 'Ürün',
                width: 250,
                template: function(data) {

                    var output = '';


                    let link = '<span  class=" font-weight-bolder font-size-lg mb-0">' + data.product + '</span><br>';
                    const time = moment.unix(data.created_at);



                    output = ' <div class="ml-4">'+link+' <span class="text-muted font-weight-bold ">' + time.format("DD.MM.YYYY HH:mm:ss") + '</span>\
								</div>\
							</div>';

                    return output;
                }
            },
            {
                field: 'user',
                title: 'Kullancıcı',
                width: 250,

            },{
                field: 'status',
                width: 60,
                sortable: false,
                overflow: 'visible',
                title: 'DURUM',
                class: 'float-right status',
                template: function(row) {
                    var status = {
                        1: {
                            'title': 'Aktif',
                            'class': ' btn-light-success'
                        },
                        2: {
                            'title': 'Pasif',
                            'class': ' btn-light-danger'
                        },

                    };
                    $('.showImage').popover({
                        placement: 'bottom',
                        trigger: 'hover',
                        html: true
                    });
                    return ' <a data-id="'+row.id+'" data-table="request" data-tables="#data_request" onclick="status(this)" <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
                },
            },
            {
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 125,
                class: 'float-right text-right',
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    return '\
                          <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-table="request" data-id="'+row.id+'" onclick="removeItem(this)" title="Kaldır">\
                            <i class="fa fa-trash-alt text-danger"></i>\
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



    $('#status_request').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#status_request').selectpicker();

    return {
        init: function() {
        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});
