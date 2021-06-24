"use strict";

var run = function() {

    let apiUrl = api_url+'v2/get/auth';
    let url = base_url+'modules';
    const top_id = $('.datatable').data('id');
    if (top_id > 0) {
        apiUrl = api_url+'v2/get/auth/'+top_id;
    }


    var datatable = $('#data_modules').KTDatatable({
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
                title: 'MODÜLLER',
                width: 250,
                template: function (row) {
                    return '<span class="text-dark-75 font-weight-bolder font-size-lg mb-0">'+row.name+'</span>';
                }

            },{

                field: 'read',
                sortable: false,
                overflow: 'visible',
                title: 'GÖRÜNTÜLEME YETKİSİ',
                template: function(row) {
                    var read = {
                        1: {
                            'checked': 'checked="checked"'
                        },
                        0: {
                            'checked': ''
                        },

                    };

                    return' <span class="switch switch-outline switch-sm switch-icon switch-success">\n' +
                        '    <label>\n' +
                        '     <input type="checkbox" ' + read[row.read].checked + '  name="select" data-id="'+row.id+'" data-name="read" data-status="'+row.read+'" onclick="read(this)"/>\n' +
                        '     <span></span>\n' +
                        '    </label>\n' +
                        '   </span>';

                },
            },
            {

                field: 'write',
                width: 190,
                sortable: false,
                overflow: 'visible',
                title: 'YAZMA YETKİSİ',
                template: function(row) {
                    var write = {
                        1: {
                            'checked': 'checked="checked"'
                        },
                        0: {
                            'checked': ''
                        },  2:{
                            'checked': 'disabled="disabled"'
                        }
                    };

                    return' <span class="switch switch-outline switch-sm switch-icon switch-info">\n' +
                        '    <label>\n' +
                        '     <input type="checkbox" ' + write[row.write].checked + '  name="select" data-id="'+row.id+'" data-name="write" data-status="'+row.write+'" onclick="read(this)"  />\n' +
                        '     <span></span>\n' +
                        '    </label>\n' +
                        '   </span>';

                },
            },
            {

                field: 'edit',
                width: 150,
                sortable: false,
                overflow: 'visible',
                title: 'DÜZENLEME YETKİSİ',
                template: function(row) {
                    var edit = {
                        1: {
                            'checked': 'checked="checked"'
                        },
                        0: {
                            'checked': ''
                        },
                        2:{
                            'checked': 'disabled="disabled"'
                        }
                    };

                    return' <span class="switch switch-outline switch-sm switch-icon switch-primary">\n' +
                        '    <label>\n' +
                        '     <input type="checkbox" ' + edit[row.edit].checked + '  name="select" data-id="'+row.id+'" data-name="edit" data-status="'+row.edit+'" onclick="read(this)"/>\n' +
                        '     <span></span>\n' +
                        '    </label>\n' +
                        '   </span>';

                },
            },
            {

                field: 'delete',
                width: 190,
                sortable: false,
                overflow: 'visible',
                title: 'SİLME YETKİSİ',
                class: 'float-right status',
                template: function(row) {
                    var sil = {
                        1: {
                            'checked': 'checked="checked"'
                        },
                        0: {
                            'checked': ''
                        },  2:{
                            'checked': 'disabled="disabled"'
                        }
                    };

                    return' <span class="switch switch-outline switch-sm switch-icon switch-dark">\n' +
                        '    <label>\n' +
                        '     <input type="checkbox" ' + sil[row.delete].checked + ' name="select" data-id="'+row.id+'" data-name="delete" data-status="'+row.delete+'" onclick="read(this)"  name="select"/>\n' +
                        '     <span></span>\n' +
                        '    </label>\n' +
                        '   </span>';

                },
            }
            ],
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

    return {
        init: function() {

        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});


function read(el) {
    const id = $(el).data('id');
    const status = $(el).data('status');
    const name = $(el).data('name');
    $.ajax({
        type: 'post',
        url: base_url + 'modules/do/'+name+'/' + id+'/' +status,
    });
    $('#data_modules').KTDatatable().reload();


}