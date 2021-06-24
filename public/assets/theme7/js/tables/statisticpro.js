"use strict";

var run = function() {

    const top_id = $('.datatable').data('id');
    let apiUrl = api_url+'v2/get/statisticpro';
    let url = base_url+'statistic/product';

    if (top_id > 0) {
        apiUrl = api_url+'v2/get/statisticpro/'+top_id;
        url = base_url+'statistic/product';
        $('.list-title span').addClass('dn');
        $('ul.breadcrumb').removeClass('dn');
    }
    $('#search').on('change keyup paste', function () {
        apiUrl = api_url+'v2/get/statisticpro';
    });
    var datatable = $('#data_statistic').KTDatatable({
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
                title: 'ÜRÜN ADI',
                width: 550,
                template: function(data) {

                    let image = site_url + '/public/media/resimyok.png';
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
                        link = '<a href=\"'+url+'/'+data.id+'\" class=" font-weight-bolder font-size-lg mb-0 text-primary">' + data.name + '</a><span class="label label-light-'+state+' ml-2">'+data.total_subcat+'</span><br>';
                    }

                    if (data.image !== null) {
                        image = site_url+'public/media/product/'+data.image;
                    }
                    const popover = 'src="'+image+'" alt="'+data.name+'" data-toggle="tooltip" data-trigger="focus" data-content="<img src=\''+image+'\' width=\'150\' class=\'img-fluid\'>"';

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
								    <img class="showImage" '+popover+'>\
								</div>\
								<div class="ml-4">'+link+'\
								</div>\
							</div>';

                    return output;
                }
            },
            {
                field: 'count',
                title: 'TOPLAM SİPARİŞ',
                class: 'float-right text-right',
                template: function (row) {
                    if (row.count > 0) {
                        return '<span class="label label-lg font-weight-bold label-primary label-inline">' + row.count + '</span>';
                    } else {
                        return '<span class="label label-lg font-weight-bold label-secondary label-inline">' + row.count + '</span>';
                    }
                }
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