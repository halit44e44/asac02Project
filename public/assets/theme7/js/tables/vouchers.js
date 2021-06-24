"use strict";

var run = function() {

    var datatable = $('#data_vouchers').KTDatatable({
        data: {
            type: 'remote',

            source: {
                read: {
                    url: api_url+'v2/get/vouchers',
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
                textAlign: 'center',
            },

            {
                field: 'name',
                title: 'BAŞLIK',
                width: 120
            },

            {
                field:"voucher_code" ,
                title: 'HEDİYE KODU',
                sortable: false,
                width: 120,
                template: function (row) {
                    return '<span class="label label-lg font-weight-boldlabel-primary label-light-primary label-inline">'+row.voucher_code+'</span>';
                }
            },
            {
                field:"discount" ,
                title: 'İNDİRİM',
                width: 120,
                sortable: false,
            },
            {
                field: 'created_at',
                title: 'OLUŞTURULMA TARİHİ',
                class: 'text-center',
                template: function (row) {
                    var timestamp = moment.unix(row.created_at);
                    return '<span class="label label-lg font-weight-boldlabel-light-primary label-inline">'+timestamp.format("DD.MM.YYYY HH:mm:ss");+'</span>';

                }
            },  {
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
                    return '<a data-id="'+row.id+'" data-table="vouchers" data-tables="#data_vouchers" onclick="status(this) "> <span class="btn btn-sm font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span> </a>';


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

                    return '<a class="btn btn-sm btn-clean btn-icon" data-table="vouchers" data-id="'+row.id+'" onclick="editItem(this)"  title="Düzenle">\
                            <i class="fa fa-paint-brush text-warning"></i>\
                        </a>\
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-id="'+row.id+'" data-table="vouchers" data-datatable="'+datatable+'"  onclick="removeItem(this)" title="Kaldır">\
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
  $('#status_vouchers').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

  $('#status_vouchers').selectpicker();

  return {
        init: function() {

        },
    };
}();
$('#start_date').datepicker({
    todayHighlight: true,
    templates: {
        leftArrow: '<i class="la la-angle-left"/>',
        rightArrow: '<i class="la la-angle-right">'
    }
}).on('changeDate', function(e) {
    validator.revalidateField('date');
});


$('#end_date').datepicker({
    todayHighlight: true,
    templates: {
        leftArrow: '<i class="la la-angle-left"/>',
        rightArrow: '<i class="la la-angle-right">'
    }
}).on('changeDate', function(e) {
    validator.revalidateField('date');
});

$('#kt_select2_4').on('change', function() {
    if ( document.getElementById("kt_select2_4").value==="1"){

        document.getElementById("select").style ="display: none;";


    }
   if ( document.getElementById("kt_select2_4").value==="2"){

       document.getElementById("select").style ="display: block;";
       document.getElementById("product").style ="display: block;";
       document.getElementById("user").style ="display: none;";
       document.getElementById("cats").style ="display: none;";
       document.getElementById("brand").style ="display: none;";
       document.getElementById("usergroups").style ="display: none;";

   }
    if ( document.getElementById("kt_select2_4").value==="3"){

        document.getElementById("select").style ="display: block;";
        document.getElementById("cats").style ="display: block;";
        document.getElementById("user").style ="display: none;";
        document.getElementById("product").style ="display: none;";
        document.getElementById("brand").style ="display: none;";
        document.getElementById("usergroups").style ="display: none;";
    }
    if ( document.getElementById("kt_select2_4").value==="4"){
        document.getElementById("select").style ="display: block;";
        document.getElementById("brand").style ="display: block;";
        document.getElementById("user").style ="display: none;";
        document.getElementById("product").style ="display: none;";
        document.getElementById("cats").style ="display: none;";
        document.getElementById("usergroups").style ="display: none;";

    }
    if ( document.getElementById("kt_select2_4").value==="5"){
        document.getElementById("select").style ="display: block;";
        document.getElementById("user").style ="display: block;";
        document.getElementById("cats").style ="display: none;";
        document.getElementById("product").style ="display: none;";
        document.getElementById("brand").style ="display: none;";
        document.getElementById("usergroups").style ="display: none;";

    }
    if ( document.getElementById("kt_select2_4").value==="6"){
        document.getElementById("select").style ="display: block;";
        document.getElementById("usergroups").style ="display: block;";
        document.getElementById("user").style ="display: none;";
        document.getElementById("product").style ="display: none;";
        document.getElementById("brand").style ="display: none;";
        document.getElementById("cats").style ="display: none;";
    }

});

$('#pro_id').selectpicker();


$('#kt_select2_2').select2({
    placeholder: "Select a state"
});

$('#kt_select2_3').select2({
    placeholder: "Select a state"
});

jQuery(document).ready(function() {
    run.init();
});

