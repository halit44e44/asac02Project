"use strict";

var run = function () {
    let apiUrl = api_url + 'v2/get/integrationproduct';
    var datatable = $('#data_product').KTDatatable({
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
                title: 'ÜRÜN İSMİ',
                width: 160,
                template: function (data) {
                    return '<div class="d-flex align-items-center"><div class="ml-4">'+data.name+'</div></div>';
                }
            },{
                field: 'IntegrationStatus',
                title: 'ENTEGRASYON DURUMU',
                width: 200,
                template: function (data) {
                    var alldata = data;
                    data = data.IntegrationStatus;
                    data = data.split('%');
                    var returnList = "";

                    data.forEach(element => {
                        if (element != "") {
                            element = element.split('#');

                            if(element[2] === "1"){
                                returnList +=  '<span class="btn btn-sm font-weight-bold label-lg btn-light-info label-inline disabled">'+element[0]+'</span>';        
                            }else{
                                returnList += '<a href="'+base_url + 'integration/product/add/'+element[1]+'/'+alldata.id+'" title="Ürünü '+element[0]+'\'a ekle">\
                                <span class="btn btn-sm font-weight-bold label-lg  btn-light-success label-inline">'+element[0]+'</span></a>';        
                            }

                        }
                    });

                    return '<div class="d-flex align-items-center">'+returnList+'</div>';
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

    return {
        init: function () {
        },
    };
}();

jQuery(document).ready(function () {
    run.init();
});