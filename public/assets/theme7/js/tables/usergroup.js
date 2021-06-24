"use strict";

var run = function() {

    var datatable = $('#data_usergroup').KTDatatable({
        data: {
            type: 'remote',

            source: {
                read: {
                    url: api_url+'v2/get/usergroup',
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
            }, {
                field: 'name',
                title: 'GRUP İSMİ',
                template: function (row) {
                    return '<span class="text-dark-75 font-weight-bolder font-size-lg mb-0">'+row.name+'</span>';
                }
            },
            {
                field: 'created_at',
                title: 'Oluşturma TARİHİ',
                template: function (row) {
                    return unixtimeToTime(row.created_at);

                }
            },
            {
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
                    return '<a data-id="'+row.id+'"  data-table="usergroup" data-tables="#data_usergroup" onclick="status(this)"  <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
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

                    return '<a class="btn btn-sm btn-clean btn-icon" data-table="usergroup" data-id="'+row.id+'" onclick="editItem(this)"  title="Düzenle">\
                            <i class="fa fa-paint-brush text-warning"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-id="'+row.id+'" data-table="usergroup" onclick="removeItem(this)" title="Kaldır">\
                            <i class="fa fa-trash-alt text-danger"></i>\
                        </a>\
                        <a href="backend/modules/index/'+row.id+'" class="btn btn-sm btn-clean btn-icon" title="Yetki">\
                           <i class="fa fa-users-cog text-primary"></i>\
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


    $('#status').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#category').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'category');
    });

    $('#status, #category').selectpicker();


    return {
        init: function() {

        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});