"use strict";

var run = function() {

    let apiUrl = api_url+'v2/get/paymenttype';
    let url = base_url+'setting/paymenttype';

    var datatable = $('#data_paymenttype').KTDatatable({
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
                field: 'name',
                title: 'ÖDEME YÖNTEMİ',
                width: 500,
                template: function(data) {
                    let link = '<span href=\"'+url+'/index/'+data.id+'\" class=" font-weight-bolder font-size-lg mb-0">' + data.name + '</span><br>';
                    return '<div class="d-flex align-items-center"><div class="ml-4">'+link+'</div></div>';
                }
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
                    return ' <a data-id="'+row.id+'" data-table="Paymenttype" data-tables="#data_Paymenttype" onclick="status(this)" <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
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



    $('#status_paymenttype').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#status_paymenttype').selectpicker();

    return {
        init: function() {
        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});
