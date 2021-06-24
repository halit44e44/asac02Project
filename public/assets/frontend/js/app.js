$(document).ready(function () {

    const url = document.getElementsByTagName('base')[0].href;

    sepetCount();

    $('#phone, .phone').mask('(000) 000-0000');


    /* dil değiştirme */
    $('.changelang').click(function () {
        const lang = $(this).data('lang');
        if (lang) {
            $.get(url+'index/lang/'+lang, function (response) {
                if (response === 'ok') {
                    location.reload();
                }
            });
        }
    });

    $('#uye_giris, #uyeSifirlaForm, #gonder').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    /* üye giriş */
    $('#uyeGiris').click(function () {

        const email = $('#email').val();
        const password = $('#password').val();
        const hata = $('.hata');

        if (email.length === 0) {
            hata.removeClass('dn').html('Lütfen email alanını doldurunuz!');
            return false;
        }

        if (isEmail(email) === false) {
            hata.removeClass('dn').html('Lütfen geçerli bir email adresi yazınız!');
            return false;
        }

        if (password.length === 0) {
            hata.removeClass('dn').html('Lütfen şifre alanını doldurunuz!');
            return false;
        }

        hata.addClass('dn');

        $.ajax({
            type: 'post',
            url: url+'uye/giris',
            data: 'email='+email+'&password='+password,
            success: function (response) {
                const result = jQuery.parseJSON(response);
                if (result.status === 'ok') {
                    window.location.href = url+'uye/favori';
                } else if (result.status === 'fail') {
                    hata.removeClass('dn').html('Giriş bilgileriniz hatalı, lütfen tekrar deneyiniz!');
                    return false;
                } else if (result.status === 'nouser') {
                    hata.removeClass('dn').html('Böyle bir kullanıcı bulunamadı!');
                    return false;
                }
            }
        });
    });

    $('#uyeliksiz_giris').click(function () {
        const data = $('#uyeKayitForm').serialize();

        const name = $('#uyelıksiz_name').val();
        const email = $('#uyelıksiz_email').val();
        const phone = $('#uyelıksiz_phone').val();


        const hata = $('.hata');

        let bildirimval = 0;


        if (name.length === 0) {
            hata.removeClass('dn').html('Lütfen isim alanını doldurunuz!');
            return false;
        }

        if (phone.length === 0) {
            hata.removeClass('dn').html('Lütfen telefon alanını doldurunuz!');
            return false;
        }

        if (email.length === 0) {
            hata.removeClass('dn').html('Lütfen email alanını doldurunuz!');
            return false;
        }

        if (isEmail(email) === false) {
            hata.removeClass('dn').html('Lütfen geçerli bir email adresi yazınız!');
            return false;
        }
        hata.addClass('dn');

        $.ajax({
            type: 'post',
            url: url+'sepet/bilgi',
            data: 'email='+email+'&phone='+phone+'&name='+name,
            success: function (response) {
                const result = jQuery.parseJSON(response);
                if (result.status === 'ok') {
                    hata.removeClass('dn').html('Giriş yapılıyor Lütfen Bekleyiniz!');
                    window.location.href = url;

                } else if (result.status === 'hasuser') {
                    hata.removeClass('dn').html('Bu email adresine kayıtlı başka bir kullanıcımız var!');
                    return false;
                }
                else if (result.status === 'hasphone') {
                    hata.removeClass('dn').html('Bu telefon numarasına kayıtlı başka bir kullanıcımız var!');
                    return false;
                }
                else {
                    hata.removeClass('dn').html('Beklenilmedik bir hata ile karşılaşıldı!');
                    return false;
                }
            }
        });
    });

    /* üye kayıt */
    $('#uyeKayit').click(function () {
        const data = $('#uyeKayitForm').serialize();

        const name = $('#name').val();
        const email = $('#email').val();
        const phone = $('#phone').val();
        const password = $('#password').val();
        const bildirim = $('#bildirim');

        const hata = $('.hata');

        let bildirimval = 0;


        if (name.length === 0) {
            hata.removeClass('dn').html('Lütfen isim alanını doldurunuz!');
            return false;
        }

        if (phone.length === 0) {
            hata.removeClass('dn').html('Lütfen telefon alanını doldurunuz!');
            return false;
        }

        if (email.length === 0) {
            hata.removeClass('dn').html('Lütfen email alanını doldurunuz!');
            return false;
        }

        if (isEmail(email) === false) {
            hata.removeClass('dn').html('Lütfen geçerli bir email adresi yazınız!');
            return false;
        }

        if (password.length === 0) {
            hata.removeClass('dn').html('Lütfen şifre alanını doldurunuz!');
            return false;
        }

        if (bildirim.is(':checked')) {
            bildirimval = 1;
        }

        hata.addClass('dn');

        $.ajax({
            type: 'post',
            url: url+'uye/kayit',
            data: 'email='+email+'&password='+password+'&phone='+phone+'&name='+name+'&bildirim='+bildirimval,
            success: function (response) {
                const result = jQuery.parseJSON(response);
                if (result.status === 'ok') {
                    window.location.href = url+'uye/giris/ilk';
                } else if (result.status === 'hasuser') {
                    hata.removeClass('dn').html('Bu email adresine kayıtlı başka bir kullanıcımız var!');
                    return false;
                } else if (result.status === 'simplepass') {
                    hata.removeClass('dn').html('Şifreniz çok basit, lütfen güçlü bir şifre belirleyiniz!');
                    return false;
                } else if (result.status === 'hasphone') {
                    hata.removeClass('dn').html('Bu telefon numarasına kayıtlı başka bir kullanıcımız var!');
                    return false;
                } else if (result.status === 'tc') {
                    hata.removeClass('dn').html('Tc Kimlik Numaranız Giriniz!');
                    return false;
                }
                else {
                    hata.removeClass('dn').html('Beklenilmedik bir hata ile karşılaşıldı!');
                    return false;
                }
            }
        });
    });

    /* şifremi unuttum */
    $('#uyeSifirla').click(function () {

        const data = $('#uyeSifirlaForm').serialize();
        const email = $('#email').val();
        const hata = $('.hata');

        if (email.length === 0) {
            hata.removeClass('dn').html('Lütfen email alanını doldurunuz!');
            return false;
        }

        if (isEmail(email) === false) {
            hata.removeClass('dn').html('Lütfen geçerli bir email adresi yazınız!');
            return false;
        }

        $('.bilgi').addClass('dn');
        $.ajax({
            type: 'post',
            url: url+'uye/sifirla',
            data:data,
            success: function (response) {
                if (response === 'ok') {
                    $('.hata').addClass('yesil').removeClass('dn').html('Yeni şifreniz email adresinize gönderilmiştir.');
                } else if (response === 'nouser') {
                    $('.hata').addClass('kbg').removeClass('dn').html('Yazmış olduğunuz email adresine ait bir kayıt bulunamadı!');
                } else if (response === 'nosmtp') {
                    $('.hata').addClass('kbg').removeClass('dn').html('SMTP Yapılandırması eksik!');
                }
            }
        });
    });

    /* üye bilgilerini düzenle */
    $('#uyeBilgi').click(function () {

        $('#uyari').removeClass('dn');
        return false;

        const data  = $('#bilgiForm').serialize();
        const name  = $('#name');
        const phone = $('#phone');
        const id_no = $('#id_no');
        const gun   = $('#gun');
        const ay    = $('#ay');
        const yil   = $('#yil');
        const hata  = $('.hata');

        if (name.val().length === 0) {
            name.addClass('error');
            return false;
        } else {
            name.removeClass('error');
        }

        if (phone.val().length === 0) {
            phone.addClass('error');
            return false;
        } else {
            phone.removeClass('error');
        }

        if (id_no.val().length === 0) {
            id_no.addClass('error');
            return false;
        } else {
            id_no.removeClass('error');
        }

        if (gun.val() === '00') {
            gun.addClass('error');
            return false;
        } else {
            gun.removeClass('error');
        }

        if (ay.val() === '00') {
            ay.addClass('error');
            return false;
        } else {
            ay.removeClass('error');
        }

        if (yil.val() === '0000') {
            yil.addClass('error');
            return false;
        } else {
            yil.removeClass('error');
        }

        $.ajax({
            type: 'post',
            url: url+'uye/bilgi',
            data: data,
            success: function (response) {
                const result = jQuery.parseJSON(response);
                if (result.status === 'ok') {
                    hata.removeClass('dn').html('İşlem başarılı bir şekilde kaydedildi.');
                } else {
                    hata.removeClass('dn').html('İşlem sırasında bir hata meydana geldi!');
                    return false;
                }
            }
        });

    });

    /* üye şifre bilgilerini düzenle */
    $('#uyeSifre').click(function () {

        $('#uyari').removeClass('dn');
        return false;

        const data = $('#sifreForm').serialize();
        const password  = $('#password');
        const password1 = $('#password1');
        const password2 = $('#password2');
        const hata  = $('.hata');

        hata.addClass('dn');

        if (password.val().length === 0) {
            password.addClass('error');
            return false;
        } else {
            password.removeClass('error');
        }

        if (password1.val().length === 0) {
            password1.addClass('error');
            return false;
        } else {
            password1.removeClass('error');
        }

        if (password2.val().length === 0) {
            password2.addClass('error');
            return false;
        } else {
            password2.removeClass('error');
        }

        $.ajax({
            type: 'post',
            url: url+'uye/sifre',
            data: data,
            success: function (response) {
                const result = jQuery.parseJSON(response);
                if (result.status === 'ok') {
                    hata.removeClass('dn').html('Şifreniz başarılı bir şekilde değiştirildi.');
                } else {
                    hata.removeClass('dn').html('Lütfen şifrelerinizi kontrol ederek tekrar deneyiniz!');
                    return false;
                }
            }
        });


    });

    /* ulke değiş sehir getir */
    $('.country').on('change', function () {
        const id = $(this).val();
        $.ajax({
            type: 'post',
            url: url+'uye/country',
            data: 'id='+id,
            success: function (respond) {
                $('.city').html(respond);
            }
        });
    });

    /* il getir */
    $('.city').on('change', function () {
        const id = $(this).val();
        $.ajax({
            type: 'post',
            url: url+'uye/city',
            data: 'id='+id,
            success: function (respond) {
                $('.town').html(respond);
            }
        });
    });

    /* ilce getir */
    $('.town').on('change', function () {
        const id = $(this).val();
        $.ajax({
            type: 'post',
            url: url+'uye/town',
            data: 'id='+id,
            success: function (respond) {
                $('.district').html(respond);
            }
        });
    });

    /* mahalle getir */
    $('.district').on('change', function () {
        const id = $(this).val();
        $.ajax({
            type: 'post',
            url: url+'uye/district',
            data: 'id='+id,
            success: function (respond) {

                $('.neighborhood').html(respond);
            }
        });
    });

    /* zip getir */
    $('.neighborhood').on('change', function () {
        const id = $(this).val();
        $.ajax({
            type: 'post',
            url: url+'uye/neighborhood',
            data: 'id='+id,
            success: function (respond) {
                $('.zip_code').val(respond);
            }
        });
    });

    /* üye yeni adres ekle */
    $('.adresEkle').click(function () {
        const data = $('#adresForm').serialize();
        const name = $('.name');
        const user_info = $('.user_info');
        const phone = $('.phone');
        const country = $('.country');
        const city = $('.city');
        const town = $('.town');
        const district = $('.district');
        const zip_code = $('.zip_code');
        const address = $('.address');
        const hata = $('.hata');

        if (name.val().length === 0) {
            name.addClass('error');
            return false;
        } else {
            name.removeClass('error');
        }

        if (user_info.val().length === 0) {
            user_info.addClass('error');
            return false;
        } else {
            user_info.removeClass('error');
        }

        if (phone.val().length === 0) {
            phone.addClass('error');
            return false;
        } else {
            phone.removeClass('error');
        }

        if (country.val() === '0') {
            country.addClass('error');
            return false;
        } else {
            country.removeClass('error');
        }

        if (city.val() === '0') {
            city.addClass('error');
            return false;
        } else {
            city.removeClass('error');
        }

        if (town.val() === '0') {
            town.addClass('error');
            return false;
        } else {
            town.removeClass('error');
        }

        if (district.val() === '0') {
            district.addClass('error');
            return false;
        } else {
            district.removeClass('error');
        }

        if (zip_code.val().length === 0) {
            zip_code.addClass('error');
            return false;
        } else {
            zip_code.removeClass('error');
        }

        if (address.val().length === 0) {
            address.addClass('error');
            return false;
        } else {
            address.removeClass('error');
        }

        $.ajax({
            type: 'post',
            url: url+'uye/adres',
            data: data,
            success: function (response) {
                const result = jQuery.parseJSON(response);
                if (result.status === 'ok') {
                    $.modal.close();
                    hata.removeClass('dn').html('Yeni adresiniz başarıyla eklendi.');
                    window.location.reload();
                } else {
                    hata.removeClass('dn').html('Adres eklenirken bir hata meydana geldi. Lütfen daha sonra tekrar deneyiniz!');
                    return false;
                }
            }
        });

    });
    $('.adresEklesesion').click(function () {
        const data = $('#adresForm').serialize();
        const name = $('.name');
        const user_info = $('.user_info');
        const email = $('.email');
        const phone = $('.phone');
        const country = $('.country');
        const city = $('.city');
        const town = $('.town');
        const district = $('.district');
        const zip_code = $('.zip_code');
        const address = $('.address');
        const hata = $('.hata');

        if (name.val().length === 0) {
            name.addClass('error');
            return false;
        } else {
            name.removeClass('error');
        }
        if (email.val().length === 0) {
            email.addClass('error');
            return false;
        } else {
            email.removeClass('error');
        }
        if (user_info.val().length === 0) {
            user_info.addClass('error');
            return false;
        } else {
            user_info.removeClass('error');
        }

        if (phone.val().length === 0) {
            phone.addClass('error');
            return false;
        } else {
            phone.removeClass('error');
        }

        if (country.val() === '0') {
            country.addClass('error');
            return false;
        } else {
            country.removeClass('error');
        }

        if (city.val() === '0') {
            city.addClass('error');
            return false;
        } else {
            city.removeClass('error');
        }

        if (town.val() === '0') {
            town.addClass('error');
            return false;
        } else {
            town.removeClass('error');
        }

        if (district.val() === '0') {
            district.addClass('error');
            return false;
        } else {
            district.removeClass('error');
        }

        if (zip_code.val().length === 0) {
            zip_code.addClass('error');
            return false;
        } else {
            zip_code.removeClass('error');
        }

        if (address.val().length === 0) {
            address.addClass('error');
            return false;
        } else {
            address.removeClass('error');
        }

        $.ajax({
            type: 'post',
            url: url+'uye/adresuyeliksiz',
            data: data,
            success: function (response) {
                const result = jQuery.parseJSON(response);
                if (result.status === 'ok') {
                    $.modal.close();
                    hata.removeClass('dn').html('Yeni adresiniz başarıyla eklendi.');
                    window.location.reload();
                }if (result.status==="hasuser"){
                    hata.removeClass('dn').html('Bu mail başka kullanıcı tarafından kullanılıyor.');
                    return false;
                }
                else {
                    hata.removeClass('dn').html('Adres eklenirken bir hata meydana geldi. Lütfen daha sonra tekrar deneyiniz!');
                    return false;
                }
            }
        });

    });

    /* adres sil */
    $('.adresSil').click(function () {

        const id = $(this).data('id');
        const hata = $('.hata');

        hata.addClass('dn');

        $.get(url+'uye/kaldir/adres/'+id, function (response) {
            const result = jQuery.parseJSON(response);
            if (result.status === 'ok') {
                hata.removeClass('dn').html('Adresiniz başarıyla kaldırıldı.');
                window.location.reload();
            } else {
                hata.removeClass('dn').html('İşlem sırasında bir hata meydana geldi!');
                return false;
            }
        });
    });

    $('.adresDuzenle').click(function () {
        const id = $(this).data('id');
        $.get(url+'uye/adresduzenle/'+id, function (response) {

            $('#adres_duzenle').html(response);
            $("#adres_duzenle").modal({});

            $('#phone, .phone').mask('(000) 000-0000');

            /* ulke değiş sehir getir */
            $('.country').on('change', function () {
                const id = $(this).val();
                $.ajax({
                    type: 'post',
                    url: url+'uye/country',
                    data: 'id='+id,
                    success: function (respond) {
                        $('.city').html(respond);
                    }
                });
            });

            /* il getir */
            $('.city').on('change', function () {
                const id = $(this).val();
                $.ajax({
                    type: 'post',
                    url: url+'uye/city',
                    data: 'id='+id,
                    success: function (respond) {
                        $('.town').html(respond);
                    }
                });
            });

            /* ilce getir */
            $('.town').on('change', function () {
                const id = $(this).val();
                $.ajax({
                    type: 'post',
                    url: url+'uye/town',
                    data: 'id='+id,
                    success: function (respond) {
                        $('.district').html(respond);
                    }
                });
            });

            /* mahalle getir */
            $('.district').on('change', function () {
                const id = $(this).val();
                $.ajax({
                    type: 'post',
                    url: url+'uye/district',
                    data: 'id='+id,
                    success: function (respond) {

                        $('.neighborhood').html(respond);
                    }
                });
            });

            /* zip getir */
            $('.neighborhood').on('change', function () {
                const id = $(this).val();
                $.ajax({
                    type: 'post',
                    url: url+'uye/neighborhood',
                    data: 'id='+id,
                    success: function (respond) {
                        $('.zip_code').val(respond);
                    }
                });
            });

            $('.adresiDuzenle').click(function () {
                const data = $('#adresDuzenleForm').serialize();
                const name = $('.name');
                const user_info = $('.user_info');
                const phone = $('.phone');
                const ulkeler = $('.ulkeler');
                const sehirler = $('.sehirler');
                const ilceler = $('.ilceler');
                const zip_code = $('.zip_code');
                const address = $('.address');
                const hata = $('.hata');

                $.ajax({
                    type: 'post',
                    url: url+'uye/adres',
                    data: data,
                    success: function (response) {
                        const result = jQuery.parseJSON(response);
                        if (result.status === 'ok') {
                            $.modal.close();
                            hata.removeClass('dn').html('Adresiniz başarıyla düzenlendi.');
                            window.location.reload();
                        } else {
                            hata.removeClass('dn').html('Adres düzenlenirken bir hata meydana geldi. Lütfen daha sonra tekrar deneyiniz!');
                            return false;
                        }
                    }
                });
            });
        });
    });

    /* pagination go top */
    $('.page a').click(function() {
        goTop();
    });
    
});