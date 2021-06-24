"use strict";

// Class definition
var KTWizard5 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _validations = [];

	// Private functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: false  // allow step clicking
		});

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}

			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
					if (status == 'Valid') {
						wizard.goTo(wizard.getNewStep());

						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: "Tüm alanları Doldurunuz",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Tamam!",
							customClass: {
								confirmButton: "btn font-weight-bold btn-light"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Change event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {
			Swal.fire({
				text: "Onayınız ile kurulum tamamlanacaktır.",
				icon: "success",
				showCancelButton: true,
				buttonsStyling: false,
				confirmButtonText: "Evet, onaylıyorum!",
				cancelButtonText: "Hayır, vazgeç!",
				customClass: {
					confirmButton: "btn font-weight-bold btn-primary",
					cancelButton: "btn font-weight-bold btn-default"
				}
			}).then(function (result) {
				if (result.value) {
					_formEl.submit(); // Submit form
				} else if (result.dismiss === 'cancel') {
					Swal.fire({
						text: "Beklenilmedik bir hata meydana geldi!",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Tekrar Dene",
						customClass: {
							confirmButton: "btn font-weight-bold btn-primary",
						}
					});
				}
			});
		});
	}

	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(

			_formEl,
			{
				fields: {
					servername: {
						validators: {
							notEmpty: {
								message: 'Sunucu Adı Boş Olamaz!'
							}
						}
					},
					licence: {
						validators: {
							notEmpty: {
								message: 'Linsans Key Boş Olamaz!'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
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
					birth_date: {
						validators: {
							notEmpty: {
								message: 'Doğum taraihi boş olamaz'
							},
							date: {
								format: 'MM/DD/YYYY' ,
								message: 'Tarih 01/01/2020 büyük 01/01/1930 küçük olamaz',
								max:'01/01/2020',
								min:'01/01/1930' ,
							}
						}
					},
				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
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
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');

			_initWizard();
			_initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	$('#birth_date').datepicker({
		todayHighlight: true,
		templates: {
			leftArrow: '<i class="la la-angle-left"/>',
			rightArrow: '<i class="la la-angle-right">'
		}
	}).on('changeDate', function(e) {
		validator.revalidateField('date');
	});
	KTWizard5.init();
});
