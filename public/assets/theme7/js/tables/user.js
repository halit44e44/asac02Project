"use strict";

var run = function() {

    var datatable = $('#data_user').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: api_url+'v2/get/user',
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
            scroll: true
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
                title: 'MÜŞTERİ',
                width: 250,
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

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
									<span class="symbol-label font-size-h4 font-weight-bold">' + data.name.substring(0, 1) + '</span>\
								</div>\
								<div class="ml-4">\
									<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.name + '</div>\
									<a href="javascript:;" class="text-muted font-weight-bold text-hover-primary">' + data.email + '</a>\
								</div>\
							</div>';

                    return output;
                }
            }, {
                field: 'user_group',
                title: 'KULLANICI GRUBU',
                sortable: false,
                width: 170,
                template: function (row) {
                    let color = "label-light-primary";
                    if (row.user_group === 'Administrator') {
                        color = "label-light-info";
                    }
                    return '<span class="label label-lg font-weight-bold ' + color + ' label-inline">' + row.user_group + '</span>';
                }
            }, {
                field: 'created_at',
                title: 'ÜYELİK TARİHİ',
                class: 'text-center',
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
                    return ' <a data-id="'+row.id+'" data-table="user" data-tables="#data_user" onclick="status(this)" <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
                },
            },{
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 125,
                class: 'float-right text-right',
                overflow: 'visible',
                autoHide: false,
                template: function(row) {

                    return '<a class="btn btn-sm btn-clean btn-icon" data-table="user" data-id="'+row.id+'" onclick="editItem(this)"  title="Düzenle">\
                            <i class="fa fa-user-edit text-warning"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-table="user" data-id="'+row.id+'"  data-groupid="'+row.group_id+'" onclick="removeItem(this)" title="Kaldır">\
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



    $('#status_user').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#user_groups').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'group_id');
    });

    $('#status_user, #user_groups').selectpicker();




    return {
        init: function() {

        },
    };
}();


jQuery(document).ready(function() {

    run.init();
})

