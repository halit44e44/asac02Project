"use strict";

var run = function() {

    const top_id = $('.datatable').data('topid');
    let apiUrl = api_url+'v2/get/cats';
    let url = base_url+'category';

    if (top_id > 0) {
        apiUrl = api_url+'v2/get/cats/'+top_id;
        url = base_url+'category';
        $('.list-title span').addClass('dn');
        $('ul.breadcrumb').removeClass('dn');
    }

    $('#search').on('change keyup paste', function () {
        apiUrl = api_url+'v2/get/cats/';
    });

    var datatable = $('#data_cats').KTDatatable({
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
            key: 'generalSearch',
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

                    let image = site_url + 'media/resimyok.png';
                    const letter = '<span class="symbol-label font-size-h4 font-weight-bold">\' + data.name.substring(0, 1) + \'</span>';

                    let output = '';
                    const stateNo = KTUtil.getRandomInt(0, 7);
                    const states = [
                        'success',
                        'primary',
                        'danger',
                        'success',
                        'warning',
                        'dark',
                        'primary',
                        'info'];
                    const state = states[stateNo];

                    let link = '<span class="text-dark-75 font-weight-bolder font-size-lg mb-0">' + data.name + '</span><br>';
                    if (data.total_subcat !== 0) {
                        link = '<a href=\"'+url+'/index/'+data.id+'\" class=" font-weight-bolder font-size-lg mb-0 text-primary">' + data.name + '</a><span class="label label-light-'+state+' ml-2">'+data.total_subcat+'</span><br>';
                    }

                    if (data.image !== null) {
                        image = site_url+'media/category/'+data.image;
                    }
                    const popover = 'src="'+image+'" alt="'+data.name+'" data-toggle="tooltip" data-trigger="focus" data-content="<img src=\''+image+'\' width=\'150\' class=\'img-fluid\'>"';

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
								    <img class="showImage" '+popover+'>\
								</div>\
								<div class="ml-4">'+link+' <span class="text-muted font-weight-bold ">' + data.sef + '</span>\
								</div>\
							</div>';

                    return output;
                }
            },{
                field: 'created_at',
                title: 'OLUŞTURULMA TARİHİ',
                class: 'text-center',
                template: function (row) {
                    return unixtimeToTime(row.created_at);
                }
            }, {
                field: 'status',
                width: 130,
                sortable: false,
                overflow: 'visible',
                title: 'DURUM',
                class: 'status text-right float-right pr-4',
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

                    const capign = {
                        2: {
                            'class': ' btn-light-success'
                        },
                        1: {
                            'class': ' btn-light-danger'
                        },
                    };

                    $('.showImage').popover({
                        placement: 'bottom',
                        trigger: 'hover',
                        html: true
                    });
                    return '<a style="margin-top:5px" data-id="'+row.id+'" data-table="cats" data-tables="#data_cats" onclick="status(this)" <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>' +
                        '<a title="Kaçırılmayacak Fırsatlar" data-id="'+row.id+'" data-table="cats" data-tables="#data_cats" data-campaign="unmissable_chance" onclick="changeCampaign(this)"> <span class="btn btn-sm font-weight-bold label-lg ' + capign[row.unmissable_chance].class + ' label-inline">K</span> </a>'+
                        '<a title="Banner Fırsatlar" data-id="'+row.id+'" data-table="cats" data-tables="#data_cats" data-campaign="banner" onclick="changeCampaign(this)"> <span class="btn btn-sm font-weight-bold label-lg ' + capign[row.banner].class + ' label-inline">B</span> </a>';
                },
            }, {
                field: 'Actions',
                title: 'İşlemler',
                sortable: false,
                width: 90,
                class: ' text-right float-right',
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    return '<a class="btn btn-sm btn-clean btn-icon" data-table="cats" data-id="'+row.id+'" onclick="editItem(this)"  title="Düzenle">\
                            <i class="fa fa-paint-brush text-warning"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-id="'+row.id+'" data-datatable="'+datatable+'" data-table="cats"  onclick="removeItem(this)" title="Kaldır">\
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

    $('#status_cat').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#user_groups_cat').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'user_id');
    });

    $('#status_cat, #user_groups_cat').selectpicker();

    $('#search').on('change keyup paste', function () {
        const query = $(this).val();
        //datatable.search(query.toLowerCase(), 'name');
        // $.ajax({
        //     type: 'post',
        //     url: base_url+'category',
        //     data: data,
        //     success: function (respond) {
        //         console.log(respond);
        //     }
        // });
    });

    $('#search').keyup(function () {

    });

    return {
        init: function() {

        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});