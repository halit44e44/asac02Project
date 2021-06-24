$(document).ready(function () {

    $('.showImage').popover({
        placement: 'bottom',
        trigger: 'hover',
        html: true
    });

    /* kategori */
    $('#name').keyup(function () {
        const name = $(this).val();
        const slugurl = $('.slugurl');
        const slugText = $('.slugText');
        const slugTitle = $('.slugTitle');
        const seotitle = $('#seotitle');
        const seo_preview = $('.seo_preview');


        seo_preview.removeClass('dn');


        slugTitle.html(name);
        seotitle.val(name);
        slugurl.val(slug(name));
        slugText.html(slug(name));
    });

    $('#description').keyup(function () {
        const desc = $(this).val();
        const descPreview = $('.slugDesc');
        descPreview.html(desc);
    });

    $('#description').maxlength({
        threshold: 150,
        warningClass: "label label-primary label-rounded label-inline",
        limitReachedClass: "label label-success label-rounded label-inline"
    });

    $('#short_content').maxlength({
        threshold: 300,
        warningClass: "label label-primary label-rounded label-inline",
        limitReachedClass: "label label-success label-rounded label-inline"
    });

    $('#seotitle').keyup(function () {
        const slug_title = $('.slugTitle');
        const seo_title = $(this).val();
        slug_title.html(seo_title);
    });

    $('#lisansButton').click(function () {
        const servername = $('#servername').val();
        const licence    = $('#licence').val();
        const hata       = $('.lisans_hata');

        hata.addClass('dn');

        if (servername && licence) {
            $.ajax({
                type: 'post',
                data: 'servername='+servername+'&licence='+licence,
                url : base_url+'install/kontrol',
                success: function (response) {
                    if (response === 'true') {
                        $('#nextstep').removeClass('dn');
                        $('#lisansButton').addClass('dn');
                        $('#nextButton').removeClass('dn');
                        hata.addClass('dn');
                    } else if (response === 'wronghost') {
                        hata.removeClass('dn').html('Yazmış olduğunuz <strong>domain adresi</strong> hatalı!');
                    } else {
                        hata.removeClass('dn').html('Yazmış olduğunuz <strong>lisans numarası</strong> veya <strong>domain adresi</strong> hatalı!');
                    }
                }
            });
        }

    });

});