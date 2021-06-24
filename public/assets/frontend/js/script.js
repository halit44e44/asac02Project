/*
	Oyos Yazılım
	01 Şubat 2019 - ismail ihsan bülbül - e-ben@msn.com
*/
$(function() {
	$(".galeri_popup").magnificPopup({
		type: 'image',
		gallery:{
			enabled:true
		}
	});
	$('.ajax_link').magnificPopup({type:'ajax'});


	//ajax ve benzeri formlar için bu formata
	calistir();

	if(1==0) {console.log("Hello mother fucker!")}
});

function calistir() {
	$.validator.messages.required = "Bu alanın doldurulması zorunludur!";
	$(".fkontrol").validate({
		submitHandler: function(form) {
			form.submit();
		}
	});
}

function sehir_getir(id) {
	$.ajax({
		url:'http://localhost/eticaret/ajax/sehirler/' + id,
		type:'GET',
		dataType: 'json',
		success: function( json ) {
			console.log('girdi!');
			var $select = $('#sehir');
			$select.find('option').remove();
			$select.append($('<option>').text('Şehir').attr('value', 0));
			$.each(json, function(i, obj){
					$select.append($('<option>').text(obj.name).attr('value', obj.id));
			});
		}
	});
}

function ilce_getir(id) {
	$.ajax({
		url:'http://localhost/eticaret/ajax/ilceler/' + id,
		type:'GET',
		dataType: 'json',
		success: function( json ) {
			console.log('girdi!');
			var $select = $('#ilce');
			$select.find('option').remove();
			$select.append($('<option>').text('İlçe').attr('value', 0));
			$.each(json, function(i, obj){
					$select.append($('<option>').text(obj.name).attr('value', obj.id));
			});
		}
	});
}

function adres_sil(id) {
	var sor = confirm('Adresi silmek istediğinizden eminmisiniz ?');
	if(sor==true) {
		$.ajax({
			url:'http://localhost/eticaret/ajax/adres_sil/' + id,
			type:'GET',
			//dataType: 'json',
			success: function(sonuc) {
				if(sonuc=='ok') {
					$('#adres_'+id).css('background','#eee').fadeOut(500,function() {
						$(this).remove();
					});
				} else {
					alert('Silme işlemi sırasında bir hata ile karşılaşıldı lütfen daha sonra tekrar deneyin!');
				}
			}

		});
	}
}

