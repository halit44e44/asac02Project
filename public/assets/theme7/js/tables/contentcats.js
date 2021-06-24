"use strict";

var run = function() {

    const top_id = $('.datatable').data('topid');
    let apiUrl = api_url+'v2/get/contentcats';
    let url = base_url+'contentcats';

    if (top_id > 0) {
        apiUrl = api_url+'v2/get/contentcats/'+top_id;
        url = base_url+'contentcats';
        $('.list-title span').addClass('dn');
        $('ul.breadcrumb').removeClass('dn');
    }

    var datatable = $('#data_contentcats').KTDatatable({
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
                title: 'KATEGORİ',
                width: 250,
                template: function(data) {

                    const id = data.id;
                    let image = '';
                    let src = '';
                    let output = '';
                    let popover = '';
                    let link = '<span href=\"'+url+'/index/'+data.id+'\" class=" font-weight-bolder font-size-lg mb-0">' + data.name + '</span><br>';

                    if (id == 2) {
                        image = site_url+'media/document.png';
                        popover = '';
                    } else if (id == 3) {
                        image = site_url+'media/corporation.png';
                    } else {
                        if (data.image !== null) {
                            image = site_url+'media/contentcats/'+data.image;
                            popover = 'data-toggle="tooltip" data-trigger="focus" data-content="<img src=\''+image+'\' width=\'150\' class=\'img-fluid\'>"';
                        } else {
                            image = site_url + 'media/resimyok.png';
                            popover = '';
                        }
                    }

                    src = 'src="'+image+'" alt="'+data.name+'" '+popover+'';

                    const stateNo = KTUtil.getRandomInt(0, 7);
                    const states = ['success', 'primary', 'danger', 'success', 'warning', 'dark', 'primary', 'info'];
                    const state = states[stateNo];

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
								    <img class="showImage" '+src+'>\
								</div>\
								<div class="ml-4">'+link+' <span class="text-muted font-weight-bold ">' + data.sef + '</span>\
								</div>\
							</div>';

                    return output;
                }
            },{
                field: 'created_at',
                title: 'OLUŞTURMA TARİHİ',
                class: 'text-center',
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
                    $('.showImage').popover({
                        placement: 'bottom',
                        trigger: 'hover',
                        html: true
                    });
                    return ' <a data-id="'+row.id+'" data-table="contentcats" data-tables="#data_contentcats" onclick="status(this)" <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
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
                    let dn = '';
                    if (row.id === "1" || row.id === "2" || row.id === "3") {
                        dn = 'dn';
                    } else {
                        dn = '';
                    }

                    const nav = {
                        2: {
                            'class': ' btn-light-success'
                        },
                        0: {
                            'class': ' btn-light-secondary text-light-dark'
                        },
                    };

                    return '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon '+dn+'" data-id="'+row.id+'" data-table="contentcats" data-datatable="'+datatable+'"  onclick="removeItem(this)" title="Kaldır"><i class="fa fa-trash-alt text-danger"></i></a>\
                    \<a class="btn btn-sm btn-clean btn-icon" data-table="contentcats" data-id="'+row.id+'" onclick="editItem(this)"  title="Düzenle"><i class="fa fa-paint-brush text-warning"></i></a>\
                    \<a title="Footer Menü" data-id="'+row.id+'" data-table="contentcats" data-position="footer" data-tables="#data_contentcats" onclick="setFooterMenu(this)"> <span class="btn btn-sm font-weight-bold label-lg '+nav[row.nav].class+' label-inline">F</span> </a>';
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

    $('#status_contentcats').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#status_contentcats').selectpicker();

    return {
        init: function() {
        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});