"use strict";

var run = function() {

    var datatable = $('#data_points').KTDatatable({
        data: {
            type: 'remote',
            source: {
                read: {
                    url: api_url+'v2/get/points',
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
                sortable:false,
                width: 250,
                template: function(data) {
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
									<span class="symbol-label font-size-h4 font-weight-bold">' + data.user_info.substring(0, 1) + '</span>\
								</div>\
								<div class="ml-4">\
									<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.user_info + '</div>\
									<a href="javascript:;" class="text-muted font-weight-bold text-hover-primary">' + data.user_email + '</a>\
								</div>\
							</div>';

                    return output;
                }
            }, {
                field: 'operation',
                title: 'Yapılan İşlem',
                width: 120,
                template: function (row) {
                    const operation = {
                        "comment": {
                            'title': 'Yorum',
                            'class': ' label-light-info'
                        },
                        "register": {
                            'title': 'Üyelik Kaydı',
                            'class': ' label-light-success'
                        },
                        "advice": {
                            'title': 'Tavsiye',
                            'class': ' label-light-warning'
                        },
                        "shopping": {
                            'title': 'Alışveriş',
                            'class': ' label-light-primary'
                        },
                    };
                    return '<span class="label label-lg font-weight-bold '+operation[row.operation].class+' label-inline">' + operation[row.operation].title + '</span>';
                }
            },{
                field: 'point',
                title: 'PUAN',
                template: function(row) {
                    let output = '';
                    output += '<div class="font-weight-bold text-muted">Kazanılan Puan: <span class="text-primary font-weight-bolder">' + row.point + '</span></div>';

                    return output;
                }
            }, {
                field: 'created_at',
                title: 'İŞLEM TARİHİ',
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
                    return ' <a data-id="'+row.id+'" data-table="points" data-tables="#data_points" onclick="status(this)" <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
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



    $('#status_points').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#status_points').selectpicker();

    return {
        init: function() {

        },
    };
}();


jQuery(document).ready(function() {

    run.init();
})

