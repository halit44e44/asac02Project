var slug = function (str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆĞÍÌÎÏİŇÑÓÖÒÔÕØŘŔŠŞŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇğíìîïıňñóöòôõøðřŕšşťúůüùûýÿžþÞĐđßÆa·/_,:;";
    var to = "AAAAAACCCDEEEEEEEEGIIIIINNOOOOOORRSSTUUUUUYYZaaaaaacccdeeeeeeeegiiiiinnooooooorrsstuuuuuyyzbBDdBAa------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
};
var unixtimeToTime = function (timestamp) {
    var time = moment.unix(timestamp);
    //return '<span class="label label-lg font-weight-boldlabel-light-primary label-inline">'+time.format("DD.MM.YYYY HH:mm:ss");+'</span>';
    return '<span class="font-weight-bolder text-primary mb-0">'+time.format("DD.MM.YYYY HH:mm:ss")+'</span>';
};

function status(el) {
    const id = $(el).data('id');
    const table = $(el).data('table');
    const tables = $(el).data('tables');

    $.ajax({
        type: 'get',
        url: base_url + 'status/do/' + table + '/' + id,
    });

    $(tables).KTDatatable().reload();
}

function changeCampaign(el) {
    const id = $(el).data('id');
    const table = $(el).data('table');
    const tables = $(el).data('tables');
    const campaign = $(el).data('campaign');

    $.ajax({
        type: 'get',
        url: base_url + 'status/campaign/' + id + '/' + campaign + '/'+table,
    });

    $(tables).KTDatatable().reload();
}

function goTop() {
    $("html, body").animate({scrollTop: 0}, "slow");
    return false;
}

function setFooterMenu(el) {
    const id = $(el).data('id');
    const table = $(el).data('table');
    const tables = $(el).data('tables');
    const position = $(el).data('position');

    $.ajax({
        type: 'get',
        url: base_url + 'status/nav/' + id + '/' + position + '/'+table,
    });

    $(tables).KTDatatable().reload();
}

function removeItem(el) {
    const id = $(el).data('id');
    const groupid = $(el).data('groupid');
    const table = $(el).data('table');
    if (table === 'usergroup' && id === 1) {
        Swal.fire(
            "Silinemez",
            "Administrator grubunu silemezsiniz",
            "error"
        );
        return;
    }
    if (table === 'user' && groupid === 1) {
        Swal.fire(
            "Silinemez",
            "Administrator grubunu silemezsiniz",
            "error"
        );
        return;
    }
    if (table === 'cats') {

        $.get(base_url + 'category/kontrol/'+id).done(function (data) {
            if (data === "true") {

                Swal.fire(
                    {

                        title: 'Kategoriye bağlı ürünler var!',
                        icon: 'warning',
                        html: 'Ürünleri taşımanız gerekmektedir  <br><br> Bu işlem geri Alınamaz<br><br><div id="cats"></div>',
                        showCancelButton: true,
                        confirmButtonText: "Evet, eminim!",
                        cancelButtonText: "Vazgeç",
                    }

                ).then(function (result) {

                    if (result.value) {
                       const yeni_id=$('#category').val();
                        $.get(base_url + 'remove/do/', {table: table, id: id ,yeni_id:yeni_id}).done(function (data) {
                            if (data.status === "noauth") {


                                Swal.fire(
                                    "Silinemez!",
                                    "Yetkiniz Yokdur!",
                                    "error"
                                );
                            }
                            if (data.status === true) {
                                $('#data_' + table).KTDatatable().reload();

                                Swal.fire(
                                    "Silindi!",
                                    "İşlem başarılı bir şekilde gerçekleşti",
                                    "success"
                                );
                            } else if (data.status === false) {
                                Swal.fire(
                                    "Silinemedi!",
                                    "İşlem sırasında bir hata oluştu",
                                    "error"
                                );
                            }
                        });
                    }
                });;

                $('#cats').load( "backend/category/cats/");

            } else if (data === "false") {
                Swal.fire({
                    title: "Silmek istediğinize emin misiniz?",
                    text: "Bu işlem geri alınamaz!",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonText: "Evet, eminim!",
                    cancelButtonText: "Vazgeç",
                }).then(function (result) {

                    if (result.value) {

                        $.get(base_url + 'remove/do/', {table: table, id: id}).done(function (data) {
                            if (data.status === "noauth") {


                                Swal.fire(
                                    "Silinemez!",
                                    "Yetkiniz Yokdur!",
                                    "error"
                                );
                            }
                            if (data.status === true) {
                                $('#data_' + table).KTDatatable().reload();

                                Swal.fire(
                                    "Silindi!",
                                    "İşlem başarılı bir şekilde gerçekleşti",
                                    "success"
                                );
                            } else if (data.status === false) {
                                Swal.fire(
                                    "Silinemedi!",
                                    "İşlem sırasında bir hata oluştu",
                                    "error"
                                );
                            }
                        });
                    }
                });
            }
        });

        return;
    }
    Swal.fire({
        title: "Silmek istediğinize emin misiniz?",
        text: "Bu işlem geri alınamaz!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Evet, eminim!",
        cancelButtonText: "Vazgeç",
    }).then(function (result) {

        if (result.value) {

            $.get(base_url + 'remove/do/', {table: table, id: id}).done(function (data) {
                if (data.status === "noauth") {


                    Swal.fire(
                        "Silinemez!",
                        "Yetkiniz Yokdur!",
                        "error"
                    );
                }
                if (data.status === true) {
                    $('#data_' + table).KTDatatable().reload();

                    Swal.fire(
                        "Silindi!",
                        "İşlem başarılı bir şekilde gerçekleşti",
                        "success"
                    );
                } else if (data.status === false) {
                    Swal.fire(
                        "Silinemedi!",
                        "İşlem sırasında bir hata oluştu",
                        "error"
                    );
                }
            });
        }
    });
}

function showComment(el) {
    const id = $(el).data('id');
    $.get(base_url + 'comment/get/' + id, function (data) {
        $('.commentModal table tbody').html(data);
        $('.commentModal').modal('show');
    });
}

function showCommentSeen(id) {
    $.get(base_url + 'comment/get/' + id, function (data) {
        $('.commentModal table tbody').html(data);
        $('.commentModal').modal('show');
    });
}
// NOTE AYARLARI
function showNote(el) {
    const id = $(el).data('id');
    $.get(base_url + 'pnotification/get/' + id, function (data) {
        $('.noteModal table tbody').html(data);
        $('.noteModal').modal('show');
    });
}

function showNoteSeen(id) {
    $.get(base_url + 'pnotification/get/' + id, function (data) {
        $('.noteModal table tbody').html(data);
        $('.noteModal').modal('show');
    });
}

function showCurrency(el) {
    const id = $(el).data('id');
    const title = $(el).data('title');
    $.get(base_url + 'setting/getcurrency/' + id, function (data) {
        $('.currencyModal .modal-body').html(data);
        $('.currencyModal .modal-title').html(title);
        $('.currencyModal .currencyPost .id').val(id);
        $('.currencyModal').modal('show');
    });
}


function makeid() {
    length = 8;
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    document.getElementById("voucher_code").value = result;
    return result;
}

function removeImage(el) {

    const id = $(el).data('id');
    const table = $(el).data('table');

    $.get(base_url + 'upload/remove/', {table: table, id: id}, "json").done(function (data) {
        data = JSON.parse(data); 
        if (data.status === "success") {
            $('#image_'+id).hide();
        }else{
            Swal.fire(
                "Hata!",
                "Resim silinemedi!",
                "warning"
            );
        }
    });
}

function updateImage(el) {
    const id = $(el).data('id');
    const data = $('#form_' + id).serialize();

    $('#cardi_' + id).addClass('dn');
    $('#image_' + id).removeClass('cardfix');

    $.ajax({
        type: 'post',
        url: base_url + 'upload/update/',
        data: data,
        dataType: "json",
        success: function (response) {

            if (response.status === 'success') {
                $('#cardi_'+id).removeClass('dn');
                $('#image_'+id).addClass('cardfix');

            } else if (response.status == 'same') {
                Swal.fire(
                    "Hata!",
                    "Düzenlemek istediğiniz isimde bir fotoğraf mevcut.",
                    "warning"
                );
            } else {
                Swal.fire(
                    "Hata!",
                    "Fotoğraf bilgileri düzenlenemedi!",
                    "warning"
                );
            }
        }
    });
}

function editItem(el) {
    const id = $(el).data('id');

    const table = $(el).data('table');
    if (table === "user") {
        $.get(base_url + 'edit/do/', {table: table, id: id}).done(function (data) {
            if (data.status === "noauth") {
                Swal.fire(
                    "Düzenlenemez!",
                    "Yetkiniz Yokdur!",
                    "warning"
                );
            } else if (data.status === true) {
                location.href = "backend/user/profile/vizor/" + id;
            }
        });
    } else {
        $.get(base_url + 'edit/do/', {table: table, id: id}).done(function (data) {
            if (data.status === "noauth") {
                Swal.fire(
                    "Düzenlenemez!",
                    "Yetkiniz Yokdur!",
                    "warning"
                );
            } else if (data.status === true) {
                if (table === "cats") {
                    location.href = "backend/category/update/" + id;
                } else {
                    location.href = "backend/" + table + "/update/" + id;

                }
            }


        });
    }

}