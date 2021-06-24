"use strict";

var run = function () {

    const user_id = $('.datatable').data('userid');
    let apiUrl = api_url + 'v2/get/pnotification';
    let url = base_url + 'notification';
    //let apiUrl = api_url + 'v2/get/order';
    //let url = base_url + 'order';

    if (user_id > 0) {
        apiUrl = api_url + 'v2/get/order/' + user_id;
        url = base_url + 'order';
        $('.list-title span').addClass('dn');
        $('ul.breadcrumb').removeClass('dn');
    }

    var datatable = $('#data_pnotification').KTDatatable({
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
                title: 'Kullanıcı',
                width: 250,
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

                    const state = states[stateNo];

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-' + state + ' flex-shrink-0">\
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
                field: 'order_id',
                title: 'SİPARİŞ KODU',
                width: 200,
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

                    let link = '<span class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.order_id + '</span><br>';
                    if (data.total_subcat !== 0) {
                        link = '<a target="_blank" href=\"' + url + '/../order/detail/' + data.orderGo + '\" class=" font-weight-bolder font-size-lg mb-0 text-primary">' + data.order_id + '</a>';
                    }


                    output = '<div class="d-flex align-items-center">\
								<div class="ml-4">' + link + '\
								</div>\
							</div>';

                    return output;
                }
            }, {
                field: 'bank_id',
                title: 'BANKA',
            }, {
                field: 'created_at',
                title: 'BİLDİRİM TARİHİ',
                class: 'text-center',
                template: function (row) {
                    return unixtimeToTime(row.created_at);
                }
            },{
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 125,
                class: 'float-right text-right',
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    return '<a href="javascript:;" onclick="showNote(this);" data-id="'+row.id+'" class="btn btn-sm btn-clean btn-icon" title="Müşteri Notu">\
                            <i class="fa fa-comment-alt text-success mr-5"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-id="'+row.id+'" data-table="pnotification" data-datatable="'+datatable+'"  onclick="removeItem(this)" title="Kaldır">\
                            <i class="fa fa-trash-alt text-danger"></i>\
                        </a>'
                },
            }, {
                field: 'status',
                width: 100,
                sortable: false,
                overflow: 'visible',
                title: 'DURUM',
                class: 'float-right status',
                template: function(row) {
                    var status = {
                        1: {
                            'title': 'İşleme Alındı',
                            'class': ' btn-light-success'
                        },
                        2: {
                            'title': 'Beklemede',
                            'class': ' btn-light-danger'
                        },
                    };
                    return '<a data-id="'+row.id+'"  data-table="pnotification" data-tables="#data_pnotification" onclick="statusNoti(this)"  <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';                },
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

    $('#status_payment').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#user_groups_cat').on('change', function () {
        datatable.search($(this).val().toLowerCase(), 'user_id');
    });

    $('#status_payment, #user_groups_cat').selectpicker();

    return {
        init: function () {

        },
    };
}();

jQuery(document).ready(function () {
    run.init();
});

function statusNoti(el) {
    const id = $(el).data('id');
    const table = $(el).data('table');
    const tables = $(el).data('tables');

    $.ajax({
        type: 'get',
        url: base_url + 'pnotification/do/'+ id,
    });

    $(tables).KTDatatable().reload();
}