"use strict";

var run = function() {

    let apiUrl = api_url+'v2/get/supplier';
    let url = base_url+'supplier';

    var datatable = $('#data_supplier').KTDatatable({
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
                title: 'Tedarikçi',
                width: 250,
                template: function(data) {

                    var image = site_url+'media/resimyok.png';
                    var letter = '<span class="symbol-label font-size-h4 font-weight-bold">\' + data.name.substring(0, 1) + \'</span>';

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

                    let link = '<span href=\"'+url+'/index/'+data.id+'\" class=" font-weight-bolder font-size-lg mb-0">' + data.name + '</span><br>';
                    const time = moment.unix(data.created_at);


                    const popover = 'src="'+image+'" alt="'+data.name+'"';

                    output = '<div class="d-flex align-items-center">\
								<div class="symbol symbol-40 symbol-light-'+state+' flex-shrink-0">\
								    <img class="showImage" '+popover+'>\
								</div>\
								<div class="ml-4">'+link+' <span class="text-muted font-weight-bold ">' + time.format("DD.MM.YYYY HH:mm:ss") + '</span>\
								</div>\
							</div>';

                    return output;
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
                    return '<a data-id="'+row.id+'" data-table="supplier" data-tables="#data_supplier" onclick="status(this)"  <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';
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

                    return '<a class="btn btn-sm btn-clean btn-icon" data-table="supplier" data-id="'+row.id+'" onclick="editItem(this)"  title="Düzenle">\
                            <i class="fa fa-paint-brush text-warning"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-id="'+row.id+'" data-table="supplier" data-datatable="'+datatable+'"  onclick="removeItem(this)" title="Kaldır">\
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


    $('#status_supplier').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#status_supplier').selectpicker();

    return {
        init: function() {},
    };
}();

jQuery(document).ready(function() {
    run.init();
});