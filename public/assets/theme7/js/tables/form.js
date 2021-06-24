
FormValidation.formValidation(
    document.getElementById('kt_form_1'),
    {
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email boş olamaz'
                    },
                    emailAddress: {
                        message: 'Email Adresi geçerli değil'
                    }
                }
            },


            content: {
                validators: {
                    notEmpty: {
                        message: 'İçerik  boş olamaz'
                    },
                    stringLength: {
                        min: 50,
                        max:250,
                        message:'Miumum 50 max 250 karekter '
                    },
                }
            },

            url: {
                validators: {
                    notEmpty: {
                        message: 'Website URL boş olamaz'
                    },
                    uri: {
                        message: 'Website addresi geçerli değil'
                    }
                }
            },

            digits: {
                validators: {
                    notEmpty: {
                        message: 'Digits is required'
                    },
                    digits: {
                        message: 'The velue is not a valid digits'
                    }
                }
            },

            creditcard: {
                validators: {
                    notEmpty: {
                        message: 'Kredi Kart numarası boş olamaz'
                    },
                    creditCard: {
                        message: 'Kredi kart numarası geçerli değil'
                    }
                }
            },


            phone: {
                validators: {
                    notEmpty: {
                        message: 'Telefon numarası boş olamaz'
                    },
                    phone: {
                        country: 'US',
                        message: 'Lütfen geçerli bir telefon numarası giriniz'
                    },regexp: {
                        regexp: /^[1-9-0_]+$/,
                        message: 'Lütfen geçerli bir telefon numarası giriniz'
                    },
                    stringLength: {
                        min: 10,
                        max:10,
                        message: 'Başında 0 olmadan giriniz'
                    },
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'Fiyat boş olamaz'
                    },

                }
            },
            name: {
                validators: {
                    notEmpty: {
                        message: 'Ad Soyad boş olamaz'
                    },
                    name: {
                        message: ''
                    },regexp: {
                        regexp: /^[a-zA-Z-ç-üÇ-Ü-şĞ-ğı-Şİ-ş _]+$/,
                        message: 'Ad soyad da sayı karekter kullanamazsınız'
                    }
                }
            },
            birth_date: {
                validators: {
                    notEmpty: {
                        message: 'Birth date is required'
                    },
                    date: {
                        format: 'MM/DD/YYYY' ,
                        message: 'Tarih 01/01/2020 büyük 01/01/1930 küçük olamaz',
                        max:'01/01/2020',
                        min:'01/01/1930' ,
                    }
                }
            },
            id_no: {
                validators: {
                    notEmpty: {
                        message: 'Tc no boş olamaz'
                    },
                    stringLength: {
                        min: 11,
                        max:11,
                        message: 'Lütfen geçerli bir tc giriniz'
                    },regexp: {
                        regexp: /^[1-9-0_]+$/,
                        message: 'Karekter Kullanamazsınız'
                    },
                }
            },

                password: {
                    validators: {
                        notEmpty: {
                            message: 'Parola boş olamaz'
                        },
                        checkStrength: {
                            message: 'Parola minumum 6 karekterli olmak zorunda',
                            callback: function (input) {
                                return input.value.length >= 8;
                            },
                        },
                        checkUppercase: {
                            message: 'parolada büyük harf olmak zorundar',
                            callback: function (input) {
                                return input.value != input.value.toLowerCase();
                            },
                        },
                        checkLowercase: {
                            message: 'parolada küçük olmak zorundar',
                            callback: function (input) {
                                return input.value != input.value.toUpperCase();
                            },
                        },
                        checkDigit: {
                            message: 'parolada rakam olmak zorunda',
                            callback: function (input) {
                                return input.value.search(/[0-9]/) >= 0;
                            },
                        },
                        checkSembol: {
                            message: 'parolada karekter olmak zorunda',
                            callback: function (input) {
                                return  input.value.search(/[\*\|\,\:\<\>\{\}\`\;\(\)@\&\$\#\%\!\+\"\.\=\!\₺]/) >= 0;
                            },
                        },

                    },},



            option: {
                validators: {
                    notEmpty: {
                        message: 'Please select an option'
                    }
                }
            },

            options: {
                validators: {
                    choice: {
                        min:2,
                        max:5,
                        message: 'Please select at least 2 and maximum 5 options'
                    }
                }
            },

            memo: {
                validators: {
                    notEmpty: {
                        message: 'Please enter memo text'
                    },
                    stringLength: {
                        min:50,
                        max:100,
                        message: 'Please enter a menu within text length range 50 and 100'
                    }
                }
            },

            checkbox: {
                validators: {
                    choice: {
                        min:1,
                        message: 'Please kindly check this'
                    }
                }
            },

            checkboxes: {
                validators: {
                    choice: {
                        min:2,
                        max:5,
                        message: 'Please check at least 1 and maximum 2 options'
                    }
                }
            },

            radios: {
                validators: {
                    choice: {
                        min:1,
                        message: 'Please kindly check this'
                    }
                }
            },
        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            // Bootstrap Framework Integration
            bootstrap: new FormValidation.plugins.Bootstrap(),
            // Validate fields when clicking the Submit button
            submitButton: new FormValidation.plugins.SubmitButton(),
            // Submit the form when all fields are valid
            defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            alias: new FormValidation.plugins.Alias({
                required: 'notEmpty',
                checkStrength: 'callback',
                checkUppercase: 'callback',
                checkLowercase: 'callback',
                checkDigit: 'callback',
                checkSembol: 'callback',
            }),
        },

    }
);

$('#birth_date').datepicker({
    todayHighlight: true,
    templates: {
        leftArrow: '<i class="la la-angle-left"/>',
        rightArrow: '<i class="la la-angle-right">'
    }
}).on('changeDate', function(e) {
    validator.revalidateField('date');
});



$("document").ready(function() {

    var checkTcNum = function(value) {
        value = value.toString();
        var isEleven = /^[0-9]{11}$/.test(value);
        var totalX = 0;
        for (var i = 0; i < 10; i++) {
            totalX += Number(value.substr(i, 1));
        }
        var isRuleX = totalX % 10 == value.substr(10,1);
        var totalY1 = 0;
        var totalY2 = 0;
        for (var i = 0; i < 10; i+=2) {
            totalY1 += Number(value.substr(i, 1));
        }
        for (var i = 1; i < 10; i+=2) {
            totalY2 += Number(value.substr(i, 1));
        }
        var isRuleY = ((totalY1 * 7) - totalY2) % 10 == value.substr(9,0);
        return isEleven && isRuleX && isRuleY;
    };


    $('#id_no').on('keyup focus blur load', function(event) {
        event.preventDefault();
        sifre= document.getElementById('password').value;
        var isValid = checkTcNum($(this).val());
        console.log('isValid ' , isValid);
        if (isValid) {
            $('#id_no').text("FALSE").attr('class', 'form-control is-valid');





        }
        else {

            $('#id_no').text("FALSE").attr('class', 'form-control is-invalid');

        }
    });












}); //document.ready

// Class definition


