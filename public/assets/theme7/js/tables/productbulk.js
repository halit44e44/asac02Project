"use strict";
function editProduct(item) {
    var element = $(item).parent().parent().parent().find(".inputTD");

    element.each(function() {
        if ($(this).data("id") != "rate") {
            $(this).html('<input type="text" class="dataİnput" name="'+$(this).data("id")+'" value="'+$(this).text()+'">');
        }else {
            $(this).html('<select class="dataİnput" name="'+$(this).data("id")+'">'+currency_list+'</select>');
        }
    });

    $(item).parent().html('<a class="btn btn-sm btn-text-success btn-hover-light-success font-weight-bold mr-2" data-id="'+$(item).data("id")+'" onclick="saveProduct(this)">KAYDET</a>');
}

function saveProduct(item) {
    var element = $(item).parent().parent().parent().find(".dataİnput");
    var liste = {};

    liste["id"] = $(item).data("id");

    element.each(function() {
        liste[$(this).attr("name")] = $(this).val();
    });

    $.ajax({ cache: false,
        url: base_url+'productbulk/productupdate',
        type: 'post',
        data: liste,
        beforeSend: function(){
            $(item).text("GÖNDERİLİYOR");
        }
    }).done(function (data) {
        const obj = jQuery.parseJSON(data);
        if (obj.status === 'ok') {
            element.each(function() {
                if ($(this).attr("name") != "rate") {
                    $(this).parent().html('<p class="inputTD" data-id="'+$(this).attr("name")+'">'+$(this).val()+'</p>')        
                }else {
                    $(this).parent().html('<p class="inputTD" data-id="'+$(this).attr("name")+'">'+$(this).children("option:selected").text()+'</p>')        
                }
    
            });

            //$(item).parent().html('<p data-id="'+$(item).data("id")+'" onclick="editProduct(this)">DÜZENLE</p>');
            $(item).parent().html('<a class="btn btn-sm btn-text-primary btn-hover-light-primary font-weight-bold mr-2" data-id="' + $(item).data("id") + '" onclick="editProduct(this)">DÜZENLE</a>');

        }else{
            console.log(data);
            alert("ÜRÜN DÜZENLENEMEDİ!");
            $(item).parent().html('<a class="btn btn-sm btn-text-success btn-hover-light-success font-weight-bold mr-2" data-id="'+$(item).data("id")+'" onclick="saveProduct(this)">KAYDET</a>');

        }
    }).fail(function (jqXHR, textStatus) {
        console.log("hata");
    });
}

var run = function() {
    let apiUrl = api_url+'v2/get/product';

    var datatable = $('#data_productbulk').KTDatatable({
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
            onEnter: true
        },

        columns: [
            {
                field: 'name',
                title: 'Ürün Adı',
                width: 400,
                template: function (row) {
                    return '<p class="inputTD" data-id="name">'+row.name+'</p>';
                }
            },
            {
                field: 'stock_code',
                title: 'Stok Kodu',
                template: function (row) {
                    return '<p class="inputTD" data-id="stock_code">'+row.stock_code+'</p>';
                }
            },
            {
                field: 'stock',
                title: 'Stok Adedi',
                class: 'text-center',
                template: function (row) {
                    return '<p class="inputTD" data-id="stock">'+row.stock+'</p>';
                }
            },
            {
                field: 'vat_rate',
                title: 'KDV(%)',
                class: 'text-center',
                template: function (row) {
                    return '<p class="inputTD" data-id="vat_rate">'+row.vat_rate+'</p>';
                }
            },
            {
                field: 'cargo_weight',
                title: 'Desi',
                class: 'text-center',
                template: function (row) {
                    return '<p class="inputTD" data-id="cargo_weight">'+row.cargo_weight+'</p>';
                }
            },
            {
                field: 'purchase_price',
                title: 'Alış Fiyatı',
                class: 'text-center',
                autoHide:false,
                template: function (row) {
                    return '<p class="inputTD" data-id="purchase_price">'+row.purchase_price+'</p>';
                }
            },
            {
                field: 'rate',
                title: 'Döviz Kuru',
                class: 'text-center',
                autoHide: false,
                template: function (row) {
                    return '<p class="inputTD" data-id="rate">'+row.rate+'</p>';
                }
            },
            {
                field: 'transfer_discount',
                title: 'Havale İndirimi',
                class: 'text-center',
                template: function (row) {
                    return '<p class="inputTD" data-id="transfer_discount">'+row.transfer_discount+'</p>';
                }
            },
            {
                title: 'İŞLEM',
                field: 'id',
                sortable: false,
                width: 100,
                class: 'text-right pr-3',
                overflow: 'visible',
                template: function (row) {
                    //return '<p data-id="'+ row.id +'" onclick="editProduct(this)"><i class="fa fa-paint-brush text-warning"></i></p>';
                    return '<a class="btn btn-sm btn-text-primary btn-hover-light-primary font-weight-bold mr-2" data-id="'+ row.id +'" onclick="editProduct(this)" title="Düzenle">DÜZENLE</a>'
                },
                autoHide: false
            },

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

    $('#status_product').on('change', function() {
        datatable.search($(this).val().toLowerCase(), 'status');
    });

    $('#brand_id').on('change', function() {
        datatable.search($(this).val(), 'brand_id');
    });

    $('#supplier_id').on('change', function() {
        datatable.search($(this).val(), 'supplier_id');
    });

    $('#status_product, #brand_id, #supplier_id').selectpicker();

    return {
        init: function() {

        },
    };
}();

jQuery(document).ready(function() {
    run.init();
});