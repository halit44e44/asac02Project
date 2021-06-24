"use strict";

var run = function() {

    let apiUrl = api_url+'v2/get/content';
    let url = base_url+'content';

    var datatable = $('#data_content').KTDatatable({
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
                title: 'BAŞLIK',
                width: 400,
                template: function(data) {

                    const cat_id = data.cat_id;
                    let image = '';
                    let src = '';
                    let output = '';
                    let popover = '';
                    let link = '<span href=\"'+url+'/index/'+data.id+'\" class=" font-weight-bolder font-size-lg mb-0">' + data.name + '</span><br>';
                    const stateNo = KTUtil.getRandomInt(0, 7);
                    const states = ['success', 'primary', 'danger', 'success', 'warning', 'dark', 'primary', 'info'];
                    const state = states[stateNo];

                    console.log('cat_id: '+ cat_id + 'name: ' + data.name);

                    if (cat_id === "2") {
                        image = site_url+'media/document.png';
                        popover = '';
                    } else if (cat_id === "3") {
                        image = site_url+'media/corporation.png';
                        popover = '';
                    } else {
                        if (data.image !== null) {
                            image = site_url+'media/content/'+data.image;
                            popover = 'data-toggle="tooltip" data-trigger="focus" data-content="<img src=\''+image+'\' width=\'150\' class=\'img-fluid\'>"';
                        } else {
                            image = site_url + 'media/resimyok.png';
                            popover = '';
                        }
                    }


                    src = 'src="'+image+'" alt="'+data.name+'" '+popover+'';

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
                field: 'category',
                title: 'Kategori',
                sortable: false,
                width: 120
            },{
                field: 'created_at',
                title: 'OLUŞTURULMA TARİHİ',
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
                    $('.showImage').popover({
                        placement: 'bottom',
                        trigger: 'hover',
                        html: true
                    });
                    return ' <a  data-id="'+row.id+'" data-table="content" data-tables="#data_content" onclick="status(this)" <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
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

                    let dn = '';
                    if (row.cat_id === "2" || row.cat_id === "3") {
                        dn = 'dn';
                    } else {
                        dn = '';
                    }

                    return '<a class="btn btn-sm btn-clean btn-icon" data-table="content" data-id="'+row.id+'" onclick="editItem(this)"  title="Düzenle">\
                            <i class="fa fa-paint-brush text-warning"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon '+dn+'" data-id="'+row.id+'" data-table="content" data-datatable="'+datatable+'" onclick="removeItem(this)" title="Kaldır">\
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



    $('#status').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#category').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'content_cat_id');
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
