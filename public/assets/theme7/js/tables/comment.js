"use strict";

var run = function() {

    const pro_id = $('.datatable').data('proid');
    let apiUrl = api_url+'v2/get/comment';
    let url = base_url+'comment';


    if (pro_id > 0) {
        apiUrl = api_url+'v2/get/comment/'+pro_id;
        url = base_url+'comment';
        $('.list-title span').addClass('dn');
        $('ul.breadcrumb').removeClass('dn');
    }
    var datatable = $('#data_comment').KTDatatable({
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
                field: 'userInfo',
                title: 'KULLANICI',
                sortable: false,
                width: 250,
                template: function (row) {
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
									<span class="symbol-label font-size-h4 font-weight-bold">' + row.userInfo.substring(0, 1) + '</span>\
								</div>\
								<div class="ml-4">\
									<div class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + row.userInfo + '</div>\
									<a href="javascript:;" class="text-muted font-weight-bold text-hover-primary">' + row.ip_address + '</a>\
								</div>\
							</div>';

                    return output;
                }
            },{
                field: 'point',
                title: 'PUAN',
                template: function (row) {
                    let point = '';
                    for (let i = 0; i < row.point; i++) {
                        point += '<i class="fa fa-star"></i>';
                    }

                    return point;
                }
            },{
                field: 'created_at',
                title: 'Oluşturlma Tarihi',
                template: function (row) {
                    return unixtimeToTime(row.created_at);
                }
            }, {
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
                    return '<a data-id="'+row.id+'"  data-table="comment" data-tables="#data_comment" onclick="status(this)"  <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';                },
            },{
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 125,
                class: 'float-right text-right',
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    return '<a href="javascript:;" onclick="showComment(this);" data-id="'+row.id+'" class="btn btn-sm btn-clean btn-icon" title="Yorum Göster">\
                            <i class="fa fa-comment-alt text-success mr-5"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-id="'+row.id+'" data-table="comment" data-datatable="'+datatable+'"  onclick="removeItem(this)" title="Kaldır">\
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

    $('#status_comment').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#status_comment').selectpicker();

    return {
        init: function() {

        },
    };
}();

jQuery(document).ready(function() {

    run.init();
});
